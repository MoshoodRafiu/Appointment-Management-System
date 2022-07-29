<?php /** @noinspection ALL */

declare(strict_types=1);

use App\App;
use App\Container;
use App\Database\Migration;

require_once __DIR__ . '/vendor/autoload.php';

$container = new Container();
(new App($container))->boot();

$migration = $container->get(Migration::class);

$migration->register("createUserTable", "
    CREATE TABLE IF NOT EXISTS users (
        id INT,
        name VARCHAR(255)
    );
");

$migration
    ->init()
    ->run();