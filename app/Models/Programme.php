<?php
declare(strict_types=1);

namespace App\Models;

class Programme extends BaseModel
{
    protected string $table = 'programmes';

    public function getActive(): array
    {
        $sql = "SELECT p.*, d.name as department_name, d.slug as department_slug 
                FROM programmes p 
                JOIN departments d ON p.department_id = d.id 
                WHERE p.is_active = 1 
                ORDER BY p.display_order ASC, p.name ASC";
        return $this->db->query($sql);
    }

    public function getFeatured(): array
    {
        $sql = "SELECT p.*, d.name as department_name, d.slug as department_slug 
                FROM programmes p 
                JOIN departments d ON p.department_id = d.id 
                WHERE p.is_active = 1 AND p.is_featured = 1 
                ORDER BY p.display_order ASC";
        return $this->db->query($sql);
    }

    public function findBySlug(string $slug): ?array
    {
        $sql = "SELECT p.*, d.name as department_name, d.slug as department_slug, d.hod_name 
                FROM programmes p 
                JOIN departments d ON p.department_id = d.id 
                WHERE p.slug = :slug LIMIT 1";
        return $this->db->queryOne($sql, [':slug' => $slug]);
    }

    public function getByDepartment(int $deptId): array
    {
        $sql = "SELECT * FROM programmes WHERE department_id = :deptId AND is_active = 1 ORDER BY display_order ASC";
        return $this->db->query($sql, [':deptId' => $deptId]);
    }
}

