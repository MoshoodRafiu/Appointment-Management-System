<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use App\App;

require_once __DIR__ . '/../vendor/autoload.php';
$router = require_once __DIR__ . '/../routes.php';

$path = __DIR__ . $_SERVER['REQUEST_URI'];
if (file_exists($path)) {
    return false;
}

(new App($router))->run();