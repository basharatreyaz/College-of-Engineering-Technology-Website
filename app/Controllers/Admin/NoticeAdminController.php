<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Notice;
use App\Models\AuditLog;
use App\Services\View;
use App\Services\UploadService;

class NoticeAdminController
{
    public function index(): void
    {
        $model = new Notice();
        $notices = $model->all('publish_date DESC');

        View::render('admin.notices.index', [
            'pageTitle' => 'Manage Notices | Admin',
            'notices' => $notices
        ], 'layouts.admin');
    }

    public function create(): void
    {
        View::render('admin.notices.form', [
            'pageTitle' => 'Add Notice | Admin',
            'notice' => null
        ], 'layouts.admin');
    }

    public function store(): void
    {
        $title = trim($_POST['title'] ?? '');
        $slug = slugify($_POST['slug'] ?? $title);

        $model = new Notice();
        if ($model->findBy('slug', $slug)) {
            $slug .= '-' . time();
        }

        $filePath = null;
        if (!empty($_FILES['attachment_file']['name'])) {
            $filePath = UploadService::handleDocumentUpload($_FILES['attachment_file'], 'notices');
        }

        $id = $model->create([
            'title' => $title,
            'slug' => $slug,
            'category' => trim($_POST['category'] ?? 'general'),
            'summary' => trim($_POST['summary'] ?? ''),
            'content' => trim($_POST['content'] ?? ''),
            'attachment_file' => $filePath,
            'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
            'publish_date' => $_POST['publish_date'] ?? date('Y-m-d'),
            'expiry_date' => !empty($_POST['expiry_date']) ? $_POST['expiry_date'] : null,
            'status' => trim($_POST['status'] ?? 'published'),
        ]);

        AuditLog::log('create', 'notice', (string)$id, "Created notice: {$title}");
        flash('success', 'Notice published successfully.');
        redirect('/admin/notices');
    }

    public function edit(string $id): void
    {
        $model = new Notice();
        $notice = $model->find((int)$id);
        if (!$notice) {
            flash('error', 'Notice not found.');
            redirect('/admin/notices');
        }

        View::render('admin.notices.form', [
            'pageTitle' => 'Edit Notice | Admin',
            'notice' => $notice
        ], 'layouts.admin');
    }

    public function update(string $id): void
    {
        $model = new Notice();
        $notice = $model->find((int)$id);
        if (!$notice) {
            flash('error', 'Notice not found.');
            redirect('/admin/notices');
        }

        $title = trim($_POST['title'] ?? '');
        $slug = slugify($_POST['slug'] ?? $title);

        $filePath = $notice['attachment_file'];
        if (!empty($_FILES['attachment_file']['name'])) {
            $newFile = UploadService::handleDocumentUpload($_FILES['attachment_file'], 'notices');
            if ($newFile) {
                $filePath = $newFile;
            }
        }

        $model->update((int)$id, [
            'title' => $title,
            'slug' => $slug,
            'category' => trim($_POST['category'] ?? 'general'),
            'summary' => trim($_POST['summary'] ?? ''),
            'content' => trim($_POST['content'] ?? ''),
            'attachment_file' => $filePath,
            'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
            'publish_date' => $_POST['publish_date'] ?? date('Y-m-d'),
            'expiry_date' => !empty($_POST['expiry_date']) ? $_POST['expiry_date'] : null,
            'status' => trim($_POST['status'] ?? 'published'),
        ]);

        AuditLog::log('update', 'notice', (string)$id, "Updated notice: {$title}");
        flash('success', 'Notice updated successfully.');
        redirect('/admin/notices');
    }

    public function delete(string $id): void
    {
        $model = new Notice();
        $notice = $model->find((int)$id);
        if ($notice) {
            $model->delete((int)$id);
            AuditLog::log('delete', 'notice', (string)$id, "Deleted notice: {$notice['title']}");
            flash('success', 'Notice deleted successfully.');
        }
        redirect('/admin/notices');
    }
}

