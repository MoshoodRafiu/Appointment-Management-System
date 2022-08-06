<?php

declare(strict_types=1);

namespace App\Entities;

class Event extends Entity
{
    protected array $fields = [
        'business_id', 'name', 'description'
    ];
}
