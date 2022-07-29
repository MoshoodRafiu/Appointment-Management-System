<?php

namespace App;

use App\Exceptions\Container\ContainerException;
use App\Exceptions\Container\InvalidClassException;
use App\Exceptions\Container\NotFoundException;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionNamedType;
use ReflectionUnionType;

class Container implements ContainerInterface
{
    protected array $entries = [];

    /**
     * @param string $id
     * @return object
     * @throws InvalidClassException
     * @throws NotFoundException
     * @throws ReflectionException|ContainerException
     */
    public function get(string $id): object
    {
        if (!$this->has($id)) {
            return $this->resolve($id);
        }

        $entry = $this->entries[$id];
        return $entry($this);
    }

    /**
     * Checks if a class is set
     *
     * @param string $id
     * @return bool
     */
    public function has(string $id): bool
    {
        return isset($this->entries[$id]);
    }

    /**
     * Sets a class
     *
     * @param string $id
     * @param callable $concrete
     */
    public function set(string $id, callable $concrete): void
    {
        $this->entries[$id] = $concrete;
    }

    /**
     * Resolves a class
     *
     * @param string $id
     * @return object
     * @throws InvalidClassException
     * @throws NotFoundException
     * @throws ReflectionException
     * @throws ContainerException
     */
    public function resolve(string $id): object
    {
        if (!class_exists($id)) {
            throw new NotFoundException('Class "' . $id . '" could not be resolved in container');
        }

        $reflectionClass = new ReflectionClass($id);

        if (!$reflectionClass->isInstantiable()) {
            throw new InvalidClassException('Class "' . $id . '" is not instantiable');
        }

        $constructor = $reflectionClass->getConstructor();

        $dependencies = [];
        if ($constructor) {
            $parameters = $constructor->getParameters();
            if (!empty($parameters)) {
                foreach ($parameters as $parameter) {
                    $type = $parameter->getType();
                    if (!$type) {
                        throw new ContainerException('Class "' . $id . '" has no type int');
                    }else if ($type instanceof ReflectionUnionType) {
                        throw new ContainerException('Class "' . $id . '" has union type parameter');
                    }else if ($type instanceof ReflectionNamedType && !$type->isBuiltin()) {
                        $dependencies[] = $this->get($type->getName());
                    } else {
                        throw new ContainerException('Class "' . $id . '" has invalid parameter');
                    }
                }
            }
        }

        return $reflectionClass->newInstanceArgs($dependencies);
    }
}