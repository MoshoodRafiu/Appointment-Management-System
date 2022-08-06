<?php

declare(strict_types=1);

namespace App\Entities;

use DateTime;

class Appointment extends Entity
{
    protected array $fields = [
        'event_id', 'customer_id', 'name', 'date'
    ];

    public function __construct(
        public ?int $id = null,
        public ?int $event_id = null,
        public ?int $customer_id = null,
        public ?string $name = null,
        public ?DateTime $date = null
    ) {
    }
}
