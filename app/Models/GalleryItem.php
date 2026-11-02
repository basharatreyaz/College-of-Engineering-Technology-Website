<?php
declare(strict_types=1);

namespace App\Models;

class GalleryItem extends BaseModel
{
    protected string $table = 'gallery_items';

    public function getActive(?string $category = null): array
    {
        $sql = "SELECT * FROM gallery_items WHERE is_active = 1";
        $params = [];
        if ($category !== null && $category !== 'all') {
            $sql .= " AND category = :cat";
            $params[':cat'] = $category;
        }
        $sql .= " ORDER BY display_order ASC, id DESC";
        return $this->db->query($sql, $params);
    }
}

