<?php
declare(strict_types=1);

namespace App\Models;

class Download extends BaseModel
{
    protected string $table = 'downloads';

    public function getActive(?string $category = null, ?string $branch = null, ?int $semester = null): array
    {
        $sql = "SELECT * FROM downloads WHERE is_active = 1";
        $params = [];
        if ($category !== null && $category !== 'all') {
            $sql .= " AND category = :cat";
            $params[':cat'] = $category;
        }
        if ($branch !== null && $branch !== 'all') {
            $sql .= " AND branch = :branch";
            $params[':branch'] = $branch;
        }
        if ($semester !== null && $semester > 0) {
            $sql .= " AND semester = :sem";
            $params[':sem'] = $semester;
        }
        $sql .= " ORDER BY CASE WHEN category = 'syllabus' THEN 0 ELSE 1 END, semester ASC, publication_date DESC, id ASC";
        return $this->db->query($sql, $params);
    }

    public function getSyllabi(?string $branch = null, ?int $semester = null): array
    {
        return $this->getActive('syllabus', $branch, $semester);
    }

    public function getByCategory(string $category): array
    {
        return $this->getActive($category);
    }
}
