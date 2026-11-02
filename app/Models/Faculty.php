<?php
declare(strict_types=1);

namespace App\Models;

class Faculty extends BaseModel
{
    protected string $table = 'faculty';

    public function getActive(): array
    {
        $sql = "SELECT f.*, d.name as department_name, d.slug as department_slug 
                FROM faculty f 
                JOIN departments d ON f.department_id = d.id 
                WHERE f.is_active = 1 
                ORDER BY f.display_order ASC, f.name ASC";
        return $this->db->query($sql);
    }

    public function getByDepartment(int $deptId): array
    {
        $sql = "SELECT f.*, d.name as department_name 
                FROM faculty f 
                JOIN departments d ON f.department_id = d.id 
                WHERE f.department_id = :deptId AND f.is_active = 1 
                ORDER BY f.display_order ASC";
        return $this->db->query($sql, [':deptId' => $deptId]);
    }

    public function findBySlug(string $slug): ?array
    {
        $sql = "SELECT f.*, d.name as department_name 
                FROM faculty f 
                JOIN departments d ON f.department_id = d.id 
                WHERE f.slug = :slug LIMIT 1";
        return $this->db->queryOne($sql, [':slug' => $slug]);
    }
}

