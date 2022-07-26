<?php /** @noinspection ALL */

declare(strict_types=1);

namespace App\Config;

class Config
{
    public function db(): array
    {
        return [
            'driver'   => $_ENV['DATABASE_DRIVER'],
            'host'     => $_ENV['DATABASE_HOST'],
            'port'     => $_ENV['DATABASE_PORT'],
            'database' => $_ENV['DATABASE_DATABASE'],
            'username' => $_ENV['DATABASE_USERNAME'],
            'password' => $_ENV['DATABASE_PASSWORD'],
        ];
    }
}