<?php
declare(strict_types=1);

namespace App\Models;

class Facility extends BaseModel
{
    protected string $table = 'facilities';

    public function getActive(): array
    {
        return $this->db->query("SELECT * FROM facilities WHERE is_active = 1 ORDER BY display_order ASC, title ASC");
    }

    public function findBySlug(string $slug): ?array
    {
        return $this->findBy('slug', $slug);
    }
}

