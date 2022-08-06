<?php

namespace App\Interfaces;

use App\Entities\Entity;

interface RepositoryInterface
{
    /**
     * Retrieves all data by condition
     *
     * @param array|null $conditions
     * @return array
     */
    public function getAll(?array $conditions = []): array;

    /**
     * Retrieves the first data by conditions
     *
     * @param array|null $conditions
     * @return object
     */
    public function getFirst(?array $conditions = []): ?object;

    /**
     * Retrieves data by id
     *
     * @param integer $id
     * @return object
     */
    public function getById(int $id): object;

    /**
     * Persists data to storage
     *
     * @param Entity $entity
     * @return object
     */
    public function save(Entity $entity): bool;
}
