<?php
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use PHPAuth\Config as PHPAuthConfig;
use PHPAuth\Auth as PHPAuth;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$host = $_ENV['DB_HOST'];
$db_name = $_ENV['DB_NAME'];
$db_username = $_ENV['DB_USERNAME'];
$db_password = $_ENV['DB_PASSWORD'];

try{
    $connection = new PDO("mysql:host=$host;dbname=$db_name", $db_username, $db_password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $config = new PHPAuthConfig($connection);
    $auth = new PHPAuth($connection, $config);

    // echo "Connesso al database: $db_name \n";
} catch(Error $e){
    echo "Errore: " . $e->getMessage();
}