<?php

namespace App\Entities;

use App\Exceptions\EntityException;
use DateTime;

abstract class Entity
{
    /**
     * @var array
     */
    public array $attributes = [];

    /**
     * @var array
     */
    protected array $fields = [];

    /**
     * @var bool
     */
    protected bool $withTimestamps = true;

    protected array $timeStampFields = ['created_at', 'updated_at'];

    /**
     * @param string $name
     * @param $value
     * @throws EntityException
     */
    public function __set(string $name, $value): void
    {
        if (!in_array($name, $this->fields)) {
            throw new EntityException("The specified field wasn't found");
        }
        $this->attributes[$name] = $value;
    }

    /**
     * @param string $name
     * @return string|null
     */
    public function __get(string $name): ?string
    {
        return $this->attributes[$name] ?? null;
    }

    public function getAttributes(): array
    {
        return array_merge($this->attributes, $this->getTimestamps());
    }

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
}