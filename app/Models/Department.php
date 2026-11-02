<?php
declare(strict_types=1);

namespace App\Models;

class Department extends BaseModel
{
    protected string $table = 'departments';

    public function getActive(): array
    {
        return $this->db->query("SELECT * FROM departments WHERE is_active = 1 ORDER BY display_order ASC, name ASC");
    }

    public function findBySlug(string $slug): ?array
    {
        return $this->findBy('slug', $slug);
    }
}

