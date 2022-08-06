<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Database\SqlDatabase;
use App\Entities\Entity;
use App\Interfaces\RepositoryInterface;

class AbstractRepository implements RepositoryInterface
{
    public string $tableName;
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
        return $stmt->fetch();
    }

    public function getFirst(?array $conditions = []): ?object
    {
        return $this->getAll($conditions)[0] ?? null;
    }

    public function getById(int $id): object
    {
        return $this->getFirst(compact('id'));
    }

    public function save(Entity $entity): bool
    {
        // TODO: Implement save() method.
    }

    protected function buildSelectQuery($conditions): string
    {
        $query = "SELECT * FROM {$this->tableName}";
        if (!empty($conditions)) {
            $query .= " WHERE ";
            foreach ($conditions as $field => $value) {
                $query .= "{$field} = ?";
            }
        }
        return $query;
    }
}
