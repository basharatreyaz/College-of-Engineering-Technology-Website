<?php
declare(strict_types=1);

namespace App\Models;

class Event extends BaseModel
{
    protected string $table = 'events';

    public function getPublished(int $limit = 20, ?string $timeframe = null): array
    {
        $sql = "SELECT * FROM events WHERE status = 'published'";
        $today = date('Y-m-d');

        if ($timeframe === 'upcoming') {
            $sql .= " AND start_date >= '{$today}' ORDER BY start_date ASC";
        } elseif ($timeframe === 'past') {
            $sql .= " AND start_date < '{$today}' ORDER BY start_date DESC";
        } else {
            $sql .= " ORDER BY start_date DESC";
        }

        $sql .= " LIMIT " . (int)$limit;
        return $this->db->query($sql);
    }

    public function getFeatured(int $limit = 3): array
    {
        return $this->db->query("SELECT * FROM events WHERE status = 'published' AND is_featured = 1 ORDER BY start_date DESC LIMIT " . (int)$limit);
    }

    public function findBySlug(string $slug): ?array
    {
        return $this->findBy('slug', $slug);
    }
}

