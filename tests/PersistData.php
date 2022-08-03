<?php /** @noinspection ALL */

namespace Tests;

use App\Config\Config;
use App\Container;
use App\Database\SqlDatabase;
use App\Interfaces\DatabaseInterface;
use PDO;

trait PersistData
{
    use LoadEnv;
    protected Config $config;
    protected SqlDatabase $database;
    protected string  $databaseName = 'test';

    public function initDb()
    {
        $this->loadEnv();
        $this->config = new Config();
        $this->database = new SqlDatabase($this->config);
    }

    public function instance(): PDO
    {
        return $this->database->getInstance();
    }

    public function tableExists(string $tableName): bool
    {
        try {
            return !!$this->instance()
                          ->query("SELECT 1 FROM {$tableName} LIMIT 1");
        } catch (\Exception) {
            return false;
        }
    }

    public function refreshDatabase(): void
    {
        $tables = $this->instance()->query("SHOW TABLES")->fetchAll();
        $this->instance()->query("SET FOREIGN_KEY_CHECKS=0");
        foreach ($tables as $table) {
            $this->instance()
                 ->query("DROP TABLES {$table->Tables_in_test}")
                 ->fetchAll();
        }
    }
}