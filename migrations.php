<?php /** @noinspection ALL */

declare(strict_types=1);

use App\App;
use App\Container;
use App\Database\Migration;

require_once __DIR__ . '/vendor/autoload.php';

$container = new Container();
(new App($container))->boot();

$migration = $container->get(Migration::class);

$primaryKeySql = 'id INT UNSIGNED PRIMARY KEY UNIQUE NOT NULL AUTO_INCREMENT';

$migration->register("createCustomerTable", "
    CREATE TABLE IF NOT EXISTS customers (
        {$primaryKeySql},
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) UNIQUE NOT NULL,
        gender ENUM('male', 'female') NOT NULL,
        password VARCHAR(255) NOT NULL
    );
");

$migration->register("createBusinessTable", "
    CREATE TABLE IF NOT EXISTS businesses (
        {$primaryKeySql},
        name VARCHAR(255),
        email VARCHAR(255) UNIQUE NOT NULL,
        address TEXT
    );
");

$migration->register("createEventTable", "
    CREATE TABLE IF NOT EXISTS events (
        {$primaryKeySql},
        business_id INT UNSIGNED NOT NULL,
        name VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        FOREIGN KEY (business_id) REFERENCES customers(id) ON DELETE CASCADE
    );
");

$migration->register("createAppointmentsTable", "
    CREATE TABLE IF NOT EXISTS appointments (
        {$primaryKeySql},
        event_id INT UNSIGNED NOT NULL,
        customer_id INT UNSIGNED NOT NULL,
        name VARCHAR(255) NOT NULL,
        date DATETIME,
        FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
        FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE
    );
");

$migration
    ->fresh()
    ->init()
    ->run();