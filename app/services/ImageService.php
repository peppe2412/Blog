<?php

class ImageService
{

    private $uploads_directory;
    private $allowed;

    public function __construct()
    {
        $this->uploads_directory = __DIR__ . '/../../public/uploads';
        $this->allowed = ['png', 'jpg', 'jpeg'];
    }

    public function uploads($file)
    {

        // verifica se è stato caricato un file
        if (empty($_FILES['image']['name'])) {
            $_SESSION['alert'] = 'Inserisci immagine!';
            header('Location: /posts/create');
            exit;
        }

        // dettagli del file
        $fileTmp = $file['tmp_name'];
        $exstension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($exstension, $this->allowed)) {
            return null;
        }

        // creare un nome unico per evitare conflitti
        $file_name = uniqid('post_') .  '.' . $exstension;
        $filePath = $this->uploads_directory . '/' . $file_name;

        return move_uploaded_file($fileTmp, $filePath) ? $file_name : null;
    }

    public function uploadsDirectory()
    {
        if (!file_exists($this->uploads_directory)) {
            mkdir($this->uploads_directory, 0777, true);
        }
    }
}
