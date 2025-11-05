<?php

class PostsController
{

    private $connection;
    private $imageService;

    public function __construct()
    {
       
        
        $this->connection = require __DIR__ . '/../../config/database.php';
        $this->imageService = new ImageService();
        // var_dump($this->connection);
        // die;
    }

    public function create()
    {
        require_once __DIR__ . '/../../views/admin/posts/create.php';
    }

    public function store()
    {

        $title = trim($_POST['title'] ?? '');
        $subtitle = trim($_POST['subtitle'] ?? '');

        // Il body non deve essere in trim cosi da non rompere il post generato con il Rich Text Editor
        $body = $_POST['body'];

        if (!$this->validatePost($title, $subtitle, $body)) {
            $_SESSION['alert'] = 'Campi vuoti';
            header('Location: /posts/create');
            exit;
        }

        $safe_body = $this->sanitazeBody($title, $subtitle, $body);

        $file_name = $this->imageService->uploads($_FILES['image'] ?? null);
        if (!$file_name) {
            $_SESSION['alert'] = 'Inserisci immagine!';
            header('Location: /posts/create');
            exit;
        }

        // Salvare il post nel database
        if ($this->savePost($title, $subtitle, $safe_body, $file_name)) {
            $_SESSION['success'] = 'Post creato con successo!';
            header('Location: /');
            exit;
        } else {
            $_SESSION['alert'] = 'Si è verificato un errore';
            header('Location: /posts/create');
            exit;
        }
    }

    public function validatePost($title, $subtitle, $body)
    {
        return !empty($title) && !empty($subtitle) && !empty($body);
    }

    public function sanitazeBody($body)
    {

        // Rimuove i tags non consentiti, lasciando solo quelli consentiti dall' allowed_tags
        $allowed_tags = '<h1><h2><h3><h4><p><a><ul><ol><li><br><strong><em><b><i><u><blockquote><div>';

        return strip_tags($body, $allowed_tags);
    }

    public function savePost($title, $subtitle, $body, $image)
    {

        $stmt = $this->connection->prepare("INSERT INTO posts (title, subtitle, body, image) VALUES (:title, :subtitle, :body, :image)");

        return $stmt->execute([
            ':title' => $title,
            ':subtitle' => $subtitle,
            ':body' => $body,
            ':image' => $image
        ]);
    }

    public function getPost($title)
    {
        $stmt = $this->connection->prepare("SELECT * FROM posts WHERE title = :title LIMIT 1");
        $stmt->bindParam(':title', $title);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function detail($title)
    {
        $title =  urldecode($title);

        $post = $this->getPost($title);

        if (!$post) {
            http_response_code(404);
            $_SESSION['alert'] = 'Post non trovato!';
            header('Location: /');
            exit;
        }

        require_once __DIR__ . '/../../views/posts/detail.php';
    }
}
