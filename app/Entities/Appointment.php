<?php

declare(strict_types=1);

namespace App\Entities;

use DateTime;

class Appointment extends Entity
{
    public function __construct(
        public ?int $event_id = null,
        public ?int $customer_id = null,
        public ?string $name = null,
        public ?DateTime $date = null
    ) {
        parent::__construct();
    }
}
