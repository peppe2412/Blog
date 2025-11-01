<?php

use Dotenv\Dotenv;
use PHPAuth\Config as PHPAuthConfig;
use PHPAuth\Auth as PHPAuth;

include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$email = $_ENV['ADMIN_EMAIL'];
$password = $_ENV['ADMIN_PASSWORD'];

$config = new PHPAuthConfig($connection);
$auth = new PHPAuth($connection, $config);

$result = $auth->register($email, $password, $password);

if($result['error']){
    echo 'errore: ' . $result['message'];
    exit;
}

// attivare l'utente 
$connection->prepare("UPDATE phpauth_users SET isactive = 1 WHERE email = ?")->execute([$email]);

// creare il ruolo admin e renderlo all'utente
$connection->exec("ALTER TABLE phpauth_users ADD COLUMN IF NOT EXISTS role VARCHAR(100) DEFAULT 'user'");
$connection->prepare("UPDATE phpauth_users SET role = 'admin' WHERE email = ?")->execute([$email]);

// echo "L'utente $email è stato attivato nel database: $db_name";