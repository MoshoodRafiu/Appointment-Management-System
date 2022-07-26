<?php

declare(strict_types=1);

namespace App\Database;

use App\Config\Config;
use App\Interfaces\DatabaseInterface;
use PDO;

class SqlDatabase implements DatabaseInterface
{
    protected PDO $db;

    public function __construct(protected Config $config){
        $dbConfig = $config->db();
        $dsn = "{$dbConfig['driver']}:host={$dbConfig['host']};port={$dbConfig['port']};dbname={$dbConfig['database']}";
        $this->db = new PDO($dsn, $dbConfig['username'], $dbConfig['password']);
    }

    public function getInstance(): PDO
    {
        return $this->db;
    }
}