<?php

namespace App;

use App\Exceptions\Container\NotFoundException;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    protected array $entries = [];

    public function get(string $id)
    {
        if (!$this->has($id)) {
            throw new NotFoundException('Unable to resolve '. $id);
        }

        $entry = $this->entries[$id];
        return $entry($this);
    }

    public function has(string $id): bool
    {
        return isset($this->entries[$id]);
    }

    public function set(string $id, callable $concrete)
    {
        $this->entries[$id] = $concrete;
    }

    public function resolve(string $id)
    {
    }
}