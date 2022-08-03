<?php

namespace Tests\Unit;

use App\Database\SqlDatabase;
use PHPUnit\Framework\TestCase;
use Tests\LoadEnv;
use Tests\Config;
use function PHPUnit\Framework\assertInstanceOf;

class SqlDatabaseTest extends TestCase
{
    use LoadEnv, Config;

    protected function setUp(): void
    {
        $this->loadEnv();
    }

    /**
     * @test
     */
    public function it_gets_database_instance()
    {
        assertInstanceOf(\PDO::class, (new SqlDatabase($this->getConfigMock()))->getInstance());
    }
}