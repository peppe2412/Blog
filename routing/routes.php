<?php

use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use Phroute\Phroute\RouteCollector;

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

require_once __DIR__ . '/../vendor/autoload.php';

$router = new RouteCollector();

$router->get('/', function(){
    require_once __DIR__ . '/../views/home.php';
});


try{
    $dispatcher = new Dispatcher($router->getData());
    $response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $path);
} catch (HttpRouteNotFoundException $e){
    http_response_code(404);
    include_once __DIR__ . '/../views/error/404.php';
} catch (Error $e){
    echo 'Errore: ' . $e->getMessage();
}