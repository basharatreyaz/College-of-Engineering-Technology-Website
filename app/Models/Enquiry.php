<?php
declare(strict_types=1);

namespace App\Models;

class Enquiry extends BaseModel
{
    protected string $table = 'enquiries';

    public function getAllWithProgrammes(string $orderBy = 'e.created_at DESC', ?int $limit = null): array
    {
        $sql = "SELECT e.*, p.name as programme_name 
                FROM enquiries e 
                LEFT JOIN programmes p ON e.programme_id = p.id 
                ORDER BY {$orderBy}";
        if ($limit !== null) {
            $sql .= " LIMIT " . (int)$limit;
        }
        return $this->db->query($sql);
    }
}

