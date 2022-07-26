<?php

namespace App\Models;

use App\App;
use App\Interfaces\DatabaseInterface;

abstract class Model
{
    protected \PDO $db;

    public function __construct(DatabaseInterface $database)
    {
        $this->db = $database->getInstance();
    }
}