<?php

declare(strict_types=1);

namespace App\Entities;

class Business extends Entity
{
    protected array $fields = [
        'name', 'email', 'address'
    ];
}
