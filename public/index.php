<?php

declare(strict_types=1);

use App\App;
use App\Router\Router;

require_once __DIR__ . '/../vendor/autoload.php';
$router = require_once __DIR__ . '/../routes.php';

$router->get('/', function () {
  return "Hello World";
});

(new App($router))->run();