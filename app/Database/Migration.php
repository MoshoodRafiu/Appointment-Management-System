<?php

namespace App\Database;

use App\Exceptions\MigrationException;
use App\Interfaces\DatabaseInterface;
use PDO;

class Migration
{
    public const TABLE = 'migrations';
    protected array $entries = [];
    protected PDO   $db;

    public function __construct(DatabaseInterface $database)
    {
        $this->db = $database->getInstance();
    }

    public function init(): self
    {
        $this->db->query(
            "CREATE TABLE IF NOT EXISTS " . $this::TABLE . "(
                name TEXT NOT NULL,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            );"
        );
        return $this;
    }

    public function register(string $name, string $query): self
    {
        if (isset($this->entries[$name])) {
            throw new MigrationException('Migration with name ' . $name . ' already exists');
        }
        $this->entries[$name] = trim($query);
        return $this;
    }

    public function run(): self
    {
        $migrated = $this->getMigratedEntries();
        $entries  = array_filter($this->entries, fn($v) => !in_array($v, $migrated));

        foreach ($entries as $entry) {
            $this->db->query($entry);
        }

        $this->setMigratedEntries(array_keys($entries));

        echo "Migration ran successfully";
        return $this;
    }

    protected function getMigratedEntries(): bool|array
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
            $query .= ' ("' . $entry . '")' . ($entry !== end($entries) ? ',' : ';');

        }
        var_dump($query);
        return array_map(
            fn($v) => $v->query,
            $this->db->query($query)->fetchAll()
        );
    }
}