<?php

declare(strict_types=1);

namespace App\Entities;

class Business extends Entity
{
    protected array $fields = [
        'name', 'email', 'address'
    ];

    public function __construct(
        public ?int $id = null,
        public ?string $name = null,
        public ?string $email = null,
        public ?string $address = null
    ) {
    }
}
