<?php
declare(strict_types=1);

namespace App\Models;

class AuditLog extends BaseModel
{
    protected string $table = 'admin_audit_logs';

    public static function log(string $action, string $objectType, string|int $objectId = '', string $details = ''): void
    {
        try {
            $user = auth_user();
            $model = new self();
            $model->create([
                'user_id' => $user['id'] ?? null,
                'user_email' => $user['email'] ?? 'system',
                'action' => $action,
                'object_type' => $objectType,
                'object_id' => (string)$objectId,
                'details' => $details,
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
            ]);
        } catch (\Throwable) {
            // Silently continue so audit logging failure does not interrupt user operations
        }
    }

    public function getRecent(int $limit = 50): array
    {
        return $this->all('created_at DESC', $limit);
    }
}

