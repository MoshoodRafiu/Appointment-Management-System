<?php

use App\Container;
use App\Controllers\AuthController;
use App\Router\Router;

$container = new Container();
$router = new Router($container);

$router->get('/register', [AuthController::class, 'showRegister']);

return $router;