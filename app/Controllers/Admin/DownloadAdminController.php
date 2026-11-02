<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Download;
use App\Models\AuditLog;
use App\Services\View;
use App\Services\UploadService;

class DownloadAdminController
{
    public function index(): void
    {
        $model = new Download();
        $downloads = $model->all('category ASC, branch ASC, semester ASC, publication_date DESC');

        View::render('admin.downloads.index', [
            'pageTitle' => 'Manage Downloads & Syllabi | Admin',
            'downloads' => $downloads
        ], 'layouts.admin');
    }

    public function create(): void
    {
        View::render('admin.downloads.form', [
            'pageTitle' => 'Add Document / Syllabus | Admin',
            'download' => null
        ], 'layouts.admin');
    }

    public function store(): void
    {
        $title = trim($_POST['title'] ?? '');
        $filePath = null;
        $fileSize = null;

        if (!empty($_FILES['file']['name'])) {
            $filePath = UploadService::handleDocumentUpload($_FILES['file'], 'downloads');
            $bytes = $_FILES['file']['size'] ?? 0;
            $fileSize = $bytes > 1048576 ? round($bytes / 1048576, 1) . ' MB' : round($bytes / 1024, 1) . ' KB';
        }

        if (!$filePath) {
            flash('error', 'Please choose a document to upload.');
            redirect('/admin/downloads/create');
        }

        $model = new Download();
        $id = $model->create([
            'title' => $title,
            'category' => trim($_POST['category'] ?? 'syllabus'),
            'branch' => trim($_POST['branch'] ?? 'all'),
            'semester' => (int)($_POST['semester'] ?? 0),
            'file_path' => $filePath,
            'file_type' => strtoupper(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION)),
            'file_size' => $fileSize,
            'publication_date' => $_POST['publication_date'] ?? date('Y-m-d'),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ]);

        AuditLog::log('create', 'download', (string)$id, "Uploaded document: {$title}");
        flash('success', 'Document uploaded successfully.');
        redirect('/admin/downloads');
    }

    public function edit(string $id): void
    {
        $model = new Download();
        $download = $model->find((int)$id);
        if (!$download) {
            flash('error', 'Document not found.');
            redirect('/admin/downloads');
        }

        View::render('admin.downloads.form', [
            'pageTitle' => 'Edit Document | Admin',
            'download' => $download
        ], 'layouts.admin');
    }

    public function update(string $id): void
    {
        $model = new Download();
        $download = $model->find((int)$id);
        if (!$download) {
            flash('error', 'Document not found.');
            redirect('/admin/downloads');
        }

        $title = trim($_POST['title'] ?? '');
        $filePath = $download['file_path'];
        $fileType = $download['file_type'];
        $fileSize = $download['file_size'];

        if (!empty($_FILES['file']['name'])) {
            $newPath = UploadService::handleDocumentUpload($_FILES['file'], 'downloads');
            if ($newPath) {
                $filePath = $newPath;
                $fileType = strtoupper(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
                $bytes = $_FILES['file']['size'] ?? 0;
                $fileSize = $bytes > 1048576 ? round($bytes / 1048576, 1) . ' MB' : round($bytes / 1024, 1) . ' KB';
            }
        }

        $model->update((int)$id, [
            'title' => $title,
            'category' => trim($_POST['category'] ?? 'syllabus'),
            'branch' => trim($_POST['branch'] ?? 'all'),
            'semester' => (int)($_POST['semester'] ?? 0),
            'file_path' => $filePath,
            'file_type' => $fileType,
            'file_size' => $fileSize,
            'publication_date' => $_POST['publication_date'] ?? date('Y-m-d'),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ]);

        AuditLog::log('update', 'download', (string)$id, "Updated document: {$title}");
        flash('success', 'Document record updated successfully.');
        redirect('/admin/downloads');
    }

    public function delete(string $id): void
    {
        $model = new Download();
        $download = $model->find((int)$id);
        if ($download) {
            $model->delete((int)$id);
            AuditLog::log('delete', 'download', (string)$id, "Deleted document: {$download['title']}");
            flash('success', 'Document deleted.');
        }
        redirect('/admin/downloads');
    }
}
