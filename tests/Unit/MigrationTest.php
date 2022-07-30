<?php

namespace Tests\Unit;

use App\Database\Migration;
use App\Database\SqlDatabase;
use PHPUnit\Framework\TestCase;

class MigrationTest extends TestCase
{
    /**
     * @test
     * @throws \App\Exceptions\MigrationException
     */
    public function it_registers_a_migration(): void
    {
        $sqlDatabaseMock = $this->createMock(SqlDatabase::class);

        $migration = new Migration($sqlDatabaseMock);
        $migration->register('testMigration', 'TEST SQL');
        $expected = [
            'testMigration' => 'TEST SQL'
        ];
        $this->assertEquals($expected, $migration->getEntries());
    }
}