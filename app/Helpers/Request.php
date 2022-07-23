<?php

namespace App\Helpers;

class Request
{
    public function __construct(protected array $request = [])
    {
    }

    public function all(): array
    {
        return $this->request;
    }

    public function get(string $name): ?string
    {
        return $this->request[$name] ?? null;
    }

    public function has(string $name): bool
    {
        return isset($this->request[$name]);
    }

    public function only(string ...$names): array
    {
        $results = [];
        foreach ($this->request as $k => $v) {
            if (in_array($k, $names)) {
                $results[$k] = $v;
            }
        }
        return $results;
    }

    public function __get(string $name): ?string
    {
        return $this->get($name);
    }
}