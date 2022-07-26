<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Config\Config;

interface DatabaseInterface
{
    /**
     * Gets the database instance
     */
    public function getInstance();
}