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
     * @return Entity|null
     */
    public function getFirst(?array $conditions = []): ?Entity;

    /**
     * Retrieves data by id
     *
     * @param integer $id
     * @return Entity|null
     */
    public function getById(int $id): ?Entity;

    /**
     * Persists data to storage
     *
     * @param Entity $entity
     * @return bool
     */
    public function save(Entity $entity): bool;
}
