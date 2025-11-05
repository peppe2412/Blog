<?php

use PHPAuth\Config as PHPAuthConfig;
use PHPAuth\Auth as PHPAuth;

class AuthController
{

    private $auth;

    public function __construct()
    {
        require_once __DIR__ . '/../../config/database.php';
        require_once __DIR__ . '/../../vendor/autoload.php';

        $config = new PHPAuthConfig($connection);
        $this->auth = new PHPAuth($connection, $config);
    }

    public function showLogin()
    {
        require_once __DIR__ . '/../../views/auth/login.php';
    }

    public function login()
    {

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header('Location: /login');
            exit;
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $result = $this->auth->login($email, $password);

        if ($result['error']) {
            $_SESSION['login_error'] = 'Credenziali non valide';
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

    public function logout()
    {

        if (!empty($_SESSION['auth_hash'])) {
            $this->auth->logout($_SESSION['auth_hash']);
            unset($_SESSION['auth_hash']);
            $_SESSION['alert_logout'] = 'Disconnessione effettuata!';
            header('Location: /login');
            exit;
        }
    }
}
