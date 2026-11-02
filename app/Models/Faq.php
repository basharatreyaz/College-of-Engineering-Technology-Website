<?php
declare(strict_types=1);

namespace App\Models;

class Faq extends BaseModel
{
    protected string $table = 'faqs';

    public function getActive(?string $category = null): array
    {
        $sql = "SELECT * FROM faqs WHERE is_active = 1";
        $params = [];
        if ($category !== null && $category !== 'all') {
            $sql .= " AND category = :cat";
            $params[':cat'] = $category;
        }
        $sql .= " ORDER BY display_order ASC";
        return $this->db->query($sql, $params);
    }
}

