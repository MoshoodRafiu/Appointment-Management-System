<?php

use App\Router\Router;

$router = new Router();

$router->get('/:hello/', function () {
  return "Hello World";
});

return $router;