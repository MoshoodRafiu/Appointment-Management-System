<?php

declare(strict_types=1);

namespace App\Entities;

use App\Enums\Gender;

class Customer extends Entity
{
    public function __construct(
        public ?string $name = null,
        public ?string $email = null,
        public ?Gender $gender = null,
        public ?string $password = null
    ) {
        parent::__construct();
    }
}
