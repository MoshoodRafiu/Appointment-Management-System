<?php /** @noinspection ALL */

namespace Tests\Unit;

use App\Config\Config;
use App\Database\Migration;
use App\Database\SqlDatabase;
use App\Exceptions\MigrationException;
use PHPUnit\Framework\TestCase;
use Tests\LoadEnv;
use Tests\PersistData;

class MigrationTest extends TestCase
{
    use PersistData;

    protected Migration $migration;

    protected function setUp(): void
    {
        $this->initDb();
        $this->migration = new Migration($this->database);
        $this->migration->init();
    }

    protected function tearDown(): void
    {
        $this->refreshDatabase();
    }

    /**
     * @test
     */
    public function it_inits_database(): void
    {
        $this->assertTrue($this->tableExists('migrations'));
    }

    /**
     * @test
     * @throws MigrationException
     */
    public function it_registers_a_migration(): void
    {
        $this->migration->register('testMigration', 'TEST SQL');
        $expected = [
            'testMigration' => 'TEST SQL'
        ];
        $this->assertEquals($expected, $this->migration->getEntries());
    }

    /**
     * @test
     */
    public function it_runs_the_migration(): void
    {
        $this->migration->register(
            'testMigration',
            'CREATE TABLE users ( name VARCHAR(255) )'
        );
        $this->migration->run();
        $this->assertTrue($this->tableExists('users'));
    }

    /**
     * @test
     */
    public function it_sets_and_gets_migrated_entries(): void
    {
        $this->migration->register(
            'testMigration',
            'CREATE TABLE users ( name VARCHAR(255) )'
        );
        $this->migration->run();
        $expected = ['testMigration'];
        $this->assertEquals($expected, $this->migration->getMigratedEntries());
    }
}