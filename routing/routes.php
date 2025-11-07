<?php

use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use Phroute\Phroute\RouteCollector;

session_start();

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/PublicController.php';
require_once __DIR__ . '/../app/controllers/PostsController.php';
require_once __DIR__ . '/../app/middleware/AuthMiddleware.php';
require_once __DIR__ . '/../app/services/ImageService.php';

require_once __DIR__ . '/../vendor/autoload.php';

// require_once __DIR__ . '/../config/database.php';

$router = new RouteCollector();

$router->get('/', [PublicController::class, 'home']);
$router->get('/dashboard', [PublicController::class, 'dashboard']);
$router->get('/posts/index', [PublicController::class, 'indexPosts']);
$router->get('/posts/detail/{title}', [PostsController::class, 'detail']);


$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);


$router->get('/posts/create', function () {

    AuthMiddleware::handle();
    $controller = new PostsController();
    $controller->create();
});

$router->post('/posts/store', function () {
    AuthMiddleware::handle();
    $controller = new PostsController();
    $controller->store();
});

$router->get('/posts/edit/{id}', function ($id) {
    AuthMiddleware::handle();
    $controller = new PostsController();
    $controller->edit($id);
});

$router->post('/posts/update/{id}', function ($id) {
    AuthMiddleware::handle();
    $controller = new PostsController();
    $controller->update($id);
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
