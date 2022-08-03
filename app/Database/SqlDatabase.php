<?php

declare(strict_types=1);

namespace App\Database;

use App\Config\Config;
use App\Interfaces\DatabaseInterface;
use PDO;

class SqlDatabase implements DatabaseInterface
{
    protected PDO $db;

    public function __construct(protected Config $config)
    {
        $dbConfig = $config->db();
        $host     = "host={$dbConfig['host']}";
        $port     = "port={$dbConfig['port']}";
        $dbname   = "dbname={$dbConfig['database']}";
        $dsn      = "{$dbConfig['driver']}:{$host};{$port};{$dbname}";
        $this->db = new PDO(
            $dsn,
            $dbConfig['username'],
            $dbConfig['password'],
            [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ]
        );
    }

    public function getInstance(): PDO
    {
        return $this->db;
    }
}