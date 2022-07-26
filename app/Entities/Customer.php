<?php

declare(strict_types=1);

namespace App\Entities;

use App\Enums\Gender;

class Customer extends Entity
{
    protected array $fields = [
        'name', 'email', 'gender', 'password'
    ];

    public function __construct(
        public ?int $id = null,
        public ?string $name = null,
        public ?string $email = null,
        public ?Gender $gender = null,
        public ?string $password = null
    ) {
    }
}
