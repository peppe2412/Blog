<!-- Rendere le pagine non accessibili per chi non è loggato -->

<?php
include_once __DIR__ . '/../../vendor/autoload.php';
include_once __DIR__ . '/../../config/database.php';

session_start();

use PHPAuth\Config as PHPAuthConfig;
use PHPAuth\Auth as PHPAuth;

$config = new PHPAuthConfig($connection);
$auth = new PHPAuth($connection, $config);

if(empty($_SESSION['auth_hash']) || !$auth->checkSession($_SESSION['auth_hash'])){
    
    $_SESSION['alert'] = 'Non hai i permessi per accedere alla pagina';

    header('Location: /');
    exit;
}