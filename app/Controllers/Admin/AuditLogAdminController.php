<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\AuditLog;
use App\Services\View;

class AuditLogAdminController
{
    public function index(): void
    {
        $model = new AuditLog();
        $logs = $model->getRecent(100);

        View::render('admin.audit_logs.index', [
            'pageTitle' => 'Admin Audit Trail | KCET',
            'logs' => $logs
        ], 'layouts.admin');
    }
}

