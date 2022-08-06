<?php

declare(strict_types=1);

namespace App\Entities;

use App\Enums\Gender;

class Customer extends Entity
{
    protected array $fields = [
        'name', 'email', 'gender', 'password'
    ];
}
