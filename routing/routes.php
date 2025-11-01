<?php

use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use Phroute\Phroute\RouteCollector;
use PHPAuth\Config as PHPAuthConfig;
use PHPAuth\Auth as PHPAuth;

session_start();

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

require_once __DIR__ . '/../vendor/autoload.php';

$router = new RouteCollector();

$router->get('/', function () {
    require_once __DIR__ . '/../views/home.php';
});

$router->get('/login', function () {
    require_once __DIR__ . '/../views/auth/login.php';
});

$router->post('/login', function () {

    require_once __DIR__ . '/../config/database.php';
    require_once __DIR__ . '/../vendor/autoload.php';

    $config = new PHPAuthConfig($connection);
    $auth = new PHPAuth($connection, $config);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $result = $auth->login($email, $password);

        if ($result['error']) {
            // $message =  'errore: ' . $result['message'];
            $_SESSION['login_error'] = $result['message'];
            header('Location: /login');
            exit;
        } else {
            // salvare il token della sessione
            $_SESSION['auth_hash'] = $result['hash'];

            // renderizzare alla pagina richiesta, dopo il login
            $_SESSION['auth_success'] = 'Accesso effettuato!';
            header('Location: /dashboard');
            exit;
        }
    }
});

$router->get('/logout', function () {
    require_once __DIR__ . '/../config/database.php';
    require_once __DIR__ . '/../vendor/autoload.php';

    $config = new PHPAuthConfig($connection);
    $auth = new PHPAuth($connection, $config);

    if (!empty($_SESSION['auth_hash'])) {
        $auth->logout($_SESSION['auth_hash']);
        unset($_SESSION['auth_hash']);
        $_SESSION['alert_logout'] = 'Disconnessione effettuata!';
        header('Location: /login');
        exit;
    }
});

$router->get('/dashboard', function () {
    require_once __DIR__ . '/../setting/middleware/auth.php';
    require_once __DIR__ . '/../views/admin/dashboard.php';
});

$router->get('/posts/create', function () {
    require_once __DIR__ . '/../setting/middleware/auth.php';
    require_once __DIR__ . '/../views/admin/posts/create.php';
});

$router->post('/posts/store', function () {
    require_once __DIR__ . '/../config/database.php';

    $title = trim($_POST['title'] ?? '');
    $subtitle = trim($_POST['subtitle'] ?? '');

    // Il body non deve essere in trim cosi da non rompere il post generato con il Rich Text Editor
    $body = $_POST['body'];

    // Rimuove i tags non consentiti, lasciando solo quelli consentiti dall' allowed_tags
    $allowed_tags = '<h1><h2><h3><h4><p><a><ul><ol><li><br><strong><em><b><i><u><img><blockquote><div>';
    $safe_body = strip_tags($body, $allowed_tags);

    if ($title == '' || $subtitle == '' || $safe_body == '') {
        $_SESSION['alert'] = 'Campi vuoti';
        header('Location: /posts/create');
        exit;
    }

    // Immagini - salvare le immagini nella cartella uploads
    $uploads_directory = __DIR__ . '/../public/uploads';
    if (!file_exists($uploads_directory)) {
        mkdir($uploads_directory, 0777, true);
    }

    // Inizializzare i nomi dei file 
    $file_name = null;

    // verifica se è stato caricato un file
    if (!empty($_FILES['image']['name'])) {
        // dettagli del file
        $file_temporany = $_FILES['image']['tmp_name'];
        $file_origin = basename($_FILES['image']['name']);
        $exstension = strtolower(pathinfo($file_origin, PATHINFO_EXTENSION));

        $allowed = ['png', 'jpg', 'jpeg'];

        if (in_array($exstension, $allowed)) {
            // creare un nome unico per evitare conflitti
            $file_name = uniqid('post_') .  '.' . $exstension;
            $filePath = $uploads_directory . '/' . $file_name;

            if (!move_uploaded_file($file_temporany, $filePath)) {
                $_SESSION['alert'] = 'Si è verificato un errore durante  il caricamento!';
                header('Location: /posts/create');
                exit;
            }
        } else {
            $_SESSION['alert'] = 'Formato dell\'immagine non supportato';
            header('Location: /posts/create');
            exit;
        }
    }

    // Salvare il post nel database
    $stmt = $connection->prepare("INSERT INTO posts (title, subtitle, body, image) VALUES (:title, :subtitle, :body, :image)");

    if ($stmt->execute([
        ':title' => $title,
        ':subtitle' => $subtitle,
        ':body' => $safe_body,
        ':image' => $file_name
    ])) {
        $_SESSION['success'] = 'Post creato con successo!';
        header('Location: /');
        exit;
    } else {
        $_SESSION['alert'] = 'Si è verificato un errore';
        header('Location: /posts/create');
        exit;
    }
});

$router->get('/posts/detail/{title}', function ($title) use ($connection) {
    require_once __DIR__ . '/../config/database.php';

    $title =  urldecode($title);


    $stmt = $connection->prepare("SELECT * FROM posts WHERE title = :title LIMIT 1");
    $stmt->bindParam(':title', $title);
    $stmt->execute();
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$post) {
        http_response_code(404);
        $_SESSION['alert'] = 'Post non trovato!';
        header('Location: /');
        exit;
    }

    require_once __DIR__ . '/../views/posts/detail.php';
});

try {
    $dispatcher = new Dispatcher($router->getData());
    $response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $path);
} catch (HttpRouteNotFoundException $e) {
    http_response_code(404);
    include_once __DIR__ . '/../views/error/404.php';
} catch (Error $e) {
    echo 'Errore: ' . $e->getMessage();
}
