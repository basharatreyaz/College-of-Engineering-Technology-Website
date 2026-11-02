<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Enquiry;
use App\Models\AuditLog;
use App\Services\View;

class EnquiryAdminController
{
    public function index(): void
    {
        $model = new Enquiry();
        $status = $_GET['status'] ?? null;

        $enquiries = $model->getAllWithProgrammes('e.created_at DESC');

        if ($status && $status !== 'all') {
            $enquiries = array_filter($enquiries, fn($e) => $e['status'] === $status);
        }

        View::render('admin.enquiries.index', [
            'pageTitle' => 'Admission Enquiries | Admin',
            'enquiries' => $enquiries,
            'selectedStatus' => $status
        ], 'layouts.admin');
    }

    public function show(string $id): void
    {
        $model = new Enquiry();
        $enquiry = $model->find((int)$id);
        if (!$enquiry) {
            flash('error', 'Enquiry record not found.');
            redirect('/admin/enquiries');
        }

        View::render('admin.enquiries.show', [
            'pageTitle' => 'Enquiry #' . $enquiry['id'] . ' | Admin',
            'enquiry' => $enquiry
        ], 'layouts.admin');
    }

    public function updateStatus(string $id): void
    {
        $model = new Enquiry();
        $enquiry = $model->find((int)$id);
        if (!$enquiry) {
            flash('error', 'Enquiry record not found.');
            redirect('/admin/enquiries');
        }

        $newStatus = trim($_POST['status'] ?? 'new');
        $notes = trim($_POST['internal_notes'] ?? '');

        $model->update((int)$id, [
            'status' => $newStatus,
            'internal_notes' => $notes
        ]);

        AuditLog::log('update', 'enquiry', (string)$id, "Updated enquiry status to: {$newStatus}");
        flash('success', 'Enquiry updated successfully.');
        redirect('/admin/enquiries/' . $id);
    }

    public function delete(string $id): void
    {
        $model = new Enquiry();
        $enquiry = $model->find((int)$id);
        if ($enquiry) {
            $model->delete((int)$id);
            AuditLog::log('delete', 'enquiry', (string)$id, "Deleted enquiry from: {$enquiry['full_name']}");
            flash('success', 'Enquiry record deleted.');
        }
        redirect('/admin/enquiries');
    }
}

