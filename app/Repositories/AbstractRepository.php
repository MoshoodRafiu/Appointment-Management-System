<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Database\SqlDatabase;
use App\Entities\Entity;
use App\Interfaces\RepositoryInterface;
use PDO;

class AbstractRepository implements RepositoryInterface
{
    public string $tableName;
    public string $entity;
    public \PDO   $db;

    public function __construct(public SqlDatabase $sqlDatabase)
    {
        $this->db = $this->sqlDatabase->getInstance();
    }

    public function getAll(?array $conditions = []): array
    {
        $query = $this->buildSelectQuery($conditions);
        $stmt = $this->db->prepare($query);
        $stmt->execute(array_values($conditions));
        return $stmt->fetchAll(PDO::FETCH_CLASS, $this->entity);
    }

    public function getFirst(?array $conditions = []): ?Entity
    {
        return $this->getAll($conditions)[0] ?? null;
    }

    public function getById(int $id): Entity
    {
        return $this->getFirst(compact('id'));
    }

    public function save(Entity $entity): bool
    {
        $primaryKey = $entity->{$entity->primaryKey};
        $attributes = $entity->getAttributes();
        $columns = array_keys($attributes);
        if (!$primaryKey) {
            $query = $this->buildInsertQuery($columns);
        } else {
            $query = $this->buildUpdateQuery($entity, $columns, $primaryKey);
        }
        $stmt = $this->db->prepare($query);
        return $stmt->execute(array_values($attributes));
    }

    protected function buildSelectQuery($conditions): string
    {
        $query = "SELECT * FROM {$this->tableName}";
        if (!empty($conditions)) {
            $query .= " WHERE ";
            foreach ($conditions as $field => $value) {
                $query .= "{$field} = ? " . ($value !== end($conditions) ? 'AND' : ';');
            }
        }
        return $query;
    }

    protected function buildInsertQuery(array $columns): string
    {
        $query = "INSERT INTO {$this->tableName} (" . implode(" ,", $columns) . ") VALUES (";
        foreach ($columns as $column) {
            $query .= '?' . ($column !== end($columns) ? ',' : '');
        }
        $query .= ")";
        return $query;
    }

    protected function buildUpdateQuery(Entity $entity, array $columns, string $primaryKey): string
    {
        $query = "UPDATE {$this->tableName} SET ";
        foreach ($columns as $column) {
            $query .= "{$column} = ? " . ($column !== end($columns) ? ',' : '');
        }
        $query .= "WHERE {$entity->primaryKey} = {$primaryKey}";
        return $query;
    }
}
