<?php

use App\Controllers\AuthController;
use App\Router\Router;

$router = new Router();

$router->get('/register', [AuthController::class, 'showRegister']);

return $router;