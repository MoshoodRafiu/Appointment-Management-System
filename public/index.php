<?php

declare(strict_types=1);

use App\App;

require_once __DIR__ . '/../vendor/autoload.php';
$router = require_once __DIR__ . '/../routes.php';

try {
    (new App($router))->run();
} catch (\Exception) {
    echo "There was an error starting the application";
}