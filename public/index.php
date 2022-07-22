<?php

declare(strict_types=1);

use App\App;
use App\Router\Router;

require_once __DIR__ . "/../vendor/autoload.php";

$router = new Router();

$router->get('/', function () {
  return "Hello World";
});

(new App($router))->run();