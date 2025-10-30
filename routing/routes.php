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

$router->get('/dashboard', function () {
    require_once __DIR__ . '/../setting/middleware/auth.php';
    require_once __DIR__ . '/../views/admin/dashboard.php';
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
