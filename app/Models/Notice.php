<?php
declare(strict_types=1);

namespace App\Models;

class Notice extends BaseModel
{
    protected string $table = 'notices';

    public function getPublished(int $limit = 20, ?string $category = null): array
    {
        $sql = "SELECT * FROM notices WHERE status = 'published'";
        $params = [];

        if ($category !== null && $category !== 'all') {
            $sql .= " AND category = :cat";
            $params[':cat'] = $category;
        }

        $sql .= " ORDER BY is_featured DESC, publish_date DESC LIMIT " . (int)$limit;
        return $this->db->query($sql, $params);
    }

    public function getLatest(int $limit = 5): array
    {
        return $this->db->query("SELECT * FROM notices WHERE status = 'published' ORDER BY is_featured DESC, publish_date DESC LIMIT " . (int)$limit);
    }

    public function findBySlug(string $slug): ?array
    {
        return $this->findBy('slug', $slug);
    }
}

