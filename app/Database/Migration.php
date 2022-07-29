<?php

namespace App\Database;

use App\Interfaces\DatabaseInterface;
use PDO;

class Migration
{
    protected array $entries = [];
    protected  PDO $db;

    public function __construct(DatabaseInterface $database)
    {
        $this->db = $database->getInstance();
    }

    public function register(string $query): self
    {
        $this->entries[] = $query;
        return $this;
    }

    public function run(): self
    {
        foreach ($this->entries as $entry) {
            $this->db->query($entry);
        }
        return $this;
    }
}