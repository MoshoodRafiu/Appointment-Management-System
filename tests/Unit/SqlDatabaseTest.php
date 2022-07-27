<?php

namespace Tests\Unit;

use App\Config\Config;
use App\Database\SqlDatabase;
use PHPUnit\Framework\TestCase;
use Tests\LoadEnv;
use function PHPUnit\Framework\assertInstanceOf;

class SqlDatabaseTest extends TestCase
{
    use LoadEnv;

    protected function setUp(): void
    {
        $this->loadEnv();
    }

    /**
     * @test
     */
    public function it_gets_database_instance()
    {
        $configMock = $this->createMock(Config::class);
        $configMock->method('db')->willReturn([
            'driver'   => $_ENV['DATABASE_DRIVER'],
            'host'     => $_ENV['DATABASE_HOST'],
            'port'     => $_ENV['DATABASE_PORT'],
            'database' => $_ENV['DATABASE_DATABASE'],
            'username' => $_ENV['DATABASE_USERNAME'],
            'password' => $_ENV['DATABASE_PASSWORD'],
        ]);

        assertInstanceOf(\PDO::class, (new SqlDatabase($configMock))->getInstance());
    }
}