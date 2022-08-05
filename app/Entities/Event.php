<?php

declare(strict_types=1);

namespace App\Entities;

class Event extends Entity
{
    public function __construct(
        public ?int $id = null,
        public ?int $business_id = null,
        public ?string $name = null,
        public ?string $description = null
    ) {
        parent::__construct();
    }
}
