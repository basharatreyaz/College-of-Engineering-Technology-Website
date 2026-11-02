<?php
declare(strict_types=1);

namespace App\Models;

use App\Services\Database;

abstract class BaseModel
{
    protected string $table;
    protected string $primaryKey = 'id';
    protected Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function all(string $orderBy = 'id ASC', ?int $limit = null): array
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY {$orderBy}";
        if ($limit !== null) {
            $sql .= " LIMIT " . (int)$limit;
        }
        return $this->db->query($sql);
    }

    public function find(int $id): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id LIMIT 1";
        return $this->db->queryOne($sql, [':id' => $id]);
    }

    public function findBy(string $column, mixed $value): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$column} = :val LIMIT 1";
        return $this->db->queryOne($sql, [':val' => $value]);
    }

    public function where(string $column, mixed $value, string $orderBy = 'id ASC', ?int $limit = null): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$column} = :val ORDER BY {$orderBy}";
        if ($limit !== null) {
            $sql .= " LIMIT " . (int)$limit;
        }
        return $this->db->query($sql, [':val' => $value]);
    }

    public function count(string $where = '', array $params = []): int
    {
        $sql = "SELECT COUNT(*) as cnt FROM {$this->table}";
        if (!empty($where)) {
            $sql .= " WHERE {$where}";
        }
        $res = $this->db->queryOne($sql, $params);
        return (int)($res['cnt'] ?? 0);
    }

    public function create(array $data): int
    {
        $columns = array_keys($data);
        $fields = implode(', ', $columns);
        $placeholders = ':' . implode(', :', $columns);

        $params = [];
        foreach ($data as $key => $val) {
            $params[':' . $key] = $val;
        }

        $sql = "INSERT INTO {$this->table} ({$fields}) VALUES ({$placeholders})";
        $this->db->execute($sql, $params);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): int
    {
        $setClauses = [];
        $params = [':id' => $id];

        foreach ($data as $key => $val) {
            $setClauses[] = "{$key} = :{$key}";
            $params[':' . $key] = $val;
        }

        $sql = "UPDATE {$this->table} SET " . implode(', ', $setClauses) . " WHERE {$this->primaryKey} = :id";
        return $this->db->execute($sql, $params);
    }

    public function delete(int $id): int
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
        return $this->db->execute($sql, [':id' => $id]);
    }
}

