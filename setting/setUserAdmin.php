<?php

use Dotenv\Dotenv;

include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$username = $_ENV['ADMIN_USERNMAME'];
$password = $_ENV['ADMIN_PASSWORD'];

$password_hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $connection->prepare("INSERT INTO user (username, password) VALUES (?, ?)");
$stmt->execute([$username, $password_hash]);

echo "Inserito $username, nel database: $db_name";