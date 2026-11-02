<?php
declare(strict_types=1);

namespace App\Models;

class Application extends BaseModel
{
    protected string $table = 'applications';

    public function generateApplicationNumber(): string
    {
        $year = date('Y');
        $random = strtoupper(bin2hex(random_bytes(3))); // 6 hex chars
        $number = "KCET-{$year}-{$random}";

        // Ensure uniqueness
        while ($this->findBy('application_number', $number)) {
            $random = strtoupper(bin2hex(random_bytes(3)));
            $number = "KCET-{$year}-{$random}";
        }

        return $number;
    }

    public function getAllWithProgrammes(string $orderBy = 'a.created_at DESC', ?int $limit = null): array
    {
        $sql = "SELECT a.*, p.name as programme_name 
                FROM applications a 
                JOIN programmes p ON a.programme_id = p.id 
                ORDER BY {$orderBy}";
        if ($limit !== null) {
            $sql .= " LIMIT " . (int)$limit;
        }
        return $this->db->query($sql);
    }

    public function findWithProgramme(int $id): ?array
    {
        $sql = "SELECT a.*, p.name as programme_name, p.degree_type 
                FROM applications a 
                JOIN programmes p ON a.programme_id = p.id 
                WHERE a.id = :id LIMIT 1";
        return $this->db->queryOne($sql, [':id' => $id]);
    }
}

