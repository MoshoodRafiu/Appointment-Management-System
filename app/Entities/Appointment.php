<?php

declare(strict_types=1);

namespace App\Entities;

use DateTime;

class Appointment extends Entity
{
    protected array $fields = [
        'event_id', 'customer_id', 'name', 'date'
    ];
}
