<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Application;
use App\Models\Programme;
use App\Models\AuditLog;
use App\Services\View;

class ApplicationAdminController
{
    public function index(): void
    {
        $model = new Application();
        $status = $_GET['status'] ?? null;
        $search = $_GET['q'] ?? null;

        $applications = $model->getAllWithProgrammes('a.created_at DESC');

        if ($status && $status !== 'all') {
            $applications = array_filter($applications, fn($a) => $a['status'] === $status);
        }

        if ($search) {
            $q = mb_strtolower(trim($search));
            $applications = array_filter($applications, function($a) use ($q) {
                return str_contains(mb_strtolower($a['application_number']), $q) ||
                       str_contains(mb_strtolower($a['first_name'] . ' ' . $a['last_name']), $q) ||
                       str_contains(mb_strtolower($a['email']), $q) ||
                       str_contains(mb_strtolower($a['phone']), $q);
            });
        }

        View::render('admin.applications.index', [
            'pageTitle' => 'Student Applications | Admin',
            'applications' => $applications,
            'selectedStatus' => $status,
            'searchQuery' => $search
        ], 'layouts.admin');
    }

    public function show(string $id): void
    {
        $model = new Application();
        $application = $model->findWithProgramme((int)$id);
        if (!$application) {
            flash('error', 'Application not found.');
            redirect('/admin/applications');
        }

        $db = \App\Services\Database::getInstance();
        $history = $db->query(
            "SELECT h.*, u.name as user_name 
             FROM application_status_history h 
             LEFT JOIN users u ON h.changed_by_user_id = u.id 
             WHERE h.application_id = :id 
             ORDER BY h.created_at DESC",
            [':id' => $id]
        );

        View::render('admin.applications.show', [
            'pageTitle' => 'Application ' . $application['application_number'] . ' | Admin',
            'application' => $application,
            'history' => $history
        ], 'layouts.admin');
    }

    public function updateStatus(string $id): void
    {
        $model = new Application();
        $application = $model->find((int)$id);
        if (!$application) {
            flash('error', 'Application not found.');
            redirect('/admin/applications');
        }

        $newStatus = trim($_POST['status'] ?? 'new');
        $remarks = trim($_POST['remarks'] ?? '');
        $user = auth_user();

        $model->update((int)$id, [
            'status' => $newStatus,
            'notes' => $remarks
        ]);

        $db = \App\Services\Database::getInstance();
        $db->execute(
            "INSERT INTO application_status_history (application_id, status, remarks, changed_by_user_id) 
             VALUES (:app_id, :status, :remarks, :user_id)",
            [
                ':app_id' => $id,
                ':status' => $newStatus,
                ':remarks' => $remarks,
                ':user_id' => $user['id'] ?? null
            ]
        );

        AuditLog::log('status_change', 'application', (string)$id, "Status changed to {$newStatus}. Remarks: {$remarks}");
        flash('success', 'Application status updated.');
        redirect('/admin/applications/' . $id);
    }
}

