<?php

namespace Tests;

use Dotenv\Dotenv;

trait LoadEnv
{
    public function loadEnv()
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__), '.env.testing');
        $dotenv->load();
    }
}