<?php

namespace App\Database;

use App\Config\Config;
use App\Exceptions\MigrationException;
use App\Interfaces\DatabaseInterface;
use PDO;

class Migration
{
    public const TABLE = 'migrations';
    protected array $entries = [];
    protected PDO   $db;

    public function __construct(DatabaseInterface $database, protected Config $config)
    {
        $this->db = $database->getInstance();
    }

    /**
     * Creates the migrations table
     *
     * @return $this
     */
    public function init(): self
    {
        $this->db->query(
            "CREATE TABLE IF NOT EXISTS " . $this::TABLE . "(
                name TEXT NOT NULL,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            )"
        );
        return $this;
    }

    /**
     * Refreshes the database
     *
     * @param bool $constrained
     * @return $this
     */
    public function fresh(?bool $constrained = false): self
    {
        $tables = $this->db->query("SHOW TABLES")->fetchAll();
        if (!$constrained) {
            $this->db->query("SET FOREIGN_KEY_CHECKS=0");
        }
        foreach ($tables as $table) {
            $this->db
                 ->query(
                     "DROP TABLES {$table->{'Tables_in_' . $this->config->db()['database']}}
                 ")
                 ->fetchAll();
        }
        return $this;
    }

    /**
     * Register a migration
     *
     * @param string $name
     * @param string $query
     * @return $this
     * @throws MigrationException
     */
    public function register(string $name, string $query): self
    {
        if (isset($this->entries[$name])) {
            throw new MigrationException('Migration with name ' . $name . ' already exists');
        }
        $this->entries[$name] = trim($query);
        return $this;
    }

    /**
     * Runs the registered migrations
     *
     * @return $this
     */
    public function run(): self
    {
        $migrated = $this->getMigratedEntries();

        $entries  = array_filter(
            $this->entries,
            fn($v) => !in_array($v, $migrated),
            ARRAY_FILTER_USE_KEY
        );

        foreach ($entries as $entry) {
            $this->db->query($entry);
        }

        if ($entries) {
            $this->setMigratedEntries(array_keys($entries));
        }
        return $this;
    }

    public function getEntries(): array
    {
        return $this->entries;
    }

    public function getMigratedEntries(): bool|array
    {
        $query = 'SELECT name FROM ' . $this::TABLE;
        return array_map(
            fn($v) => $v->name,
            $this->db->query($query)->fetchAll()
        );
    }

    protected function setMigratedEntries($entries): bool|array
    {
        $query = 'INSERT INTO ' . $this::TABLE . ' (name) VALUES';
        foreach ($entries as $entry) {
            $query .= ' ("' . $entry . '")' . ($entry !== end($entries) ? ',' : '');
        }

        return array_map(
            fn($v) => $v->query,
            $this->db->query($query)->fetchAll()
        );
    }
}