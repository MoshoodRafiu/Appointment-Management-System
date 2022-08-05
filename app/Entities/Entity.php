<?php

namespace App\Entities;

use DateTime;

abstract class Entity
{
    protected DateTime $created_at;
    protected DateTime $updated_at;

    public function __construct()
    {
        $this->created_at = new DateTime();
        $this->updated_at = new DateTime();
    }
}