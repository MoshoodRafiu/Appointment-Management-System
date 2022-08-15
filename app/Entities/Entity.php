<?php

namespace App\Entities;

use App\Exceptions\EntityException;
use DateTime;

abstract class Entity
{

    /**
     * @var array
     */
    protected array $fields = [];

    /**
     * @var string
     */
    public string $primaryKey = 'id';

    /**
     * @var bool
     */
    protected bool $withTimestamps = true;

    /**
     * @var array|string[]
     */
    protected array $timeStampFields = ['created_at', 'updated_at'];

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        $attributes = [];

        foreach ($this->fields as $field) {
            $attributes[$field] = $this->{$field};
        }

        if ($this->{$this->primaryKey}) {
            $attributes[$this->primaryKey] = $this->{$this->primaryKey};
        }

        return array_merge($attributes, $this->getTimestamps());
    }

    /**
     * @return array
     */
    public function getTimestamps(): array
    {
        if (!$this->withTimestamps) {
            return [];
        }
        $timestamps = [];
        foreach ($this->timeStampFields as $field) {
            $timestamps[$field] = new DateTime();
        }
        return $timestamps;
    }

    public function __get(string $name)
    {
        return $this->getAttributes()[$name] ?? null;
    }
}