<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use App\App;
use App\Container;

require_once __DIR__ . '/../vendor/autoload.php';

$router = require_once __DIR__ . '/../routes.php';

$path = __DIR__ . $_SERVER['REQUEST_URI'];

if (file_exists($path) && is_file($path)) {
    return false;
}

$container = new Container();
(new App($container, $router))
    ->boot()
    ->run();