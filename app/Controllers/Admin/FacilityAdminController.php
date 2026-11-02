<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Facility;
use App\Models\AuditLog;
use App\Services\View;
use App\Services\UploadService;

class FacilityAdminController
{
    public function index(): void
    {
        $model = new Facility();
        $facilities = $model->all('display_order ASC, title ASC');

        View::render('admin.facilities.index', [
            'pageTitle' => 'Manage Facilities | Admin',
            'facilities' => $facilities
        ], 'layouts.admin');
    }

    public function create(): void
    {
        View::render('admin.facilities.form', [
            'pageTitle' => 'Add Facility | Admin',
            'facility' => null
        ], 'layouts.admin');
    }

    public function store(): void
    {
        $title = trim($_POST['title'] ?? '');
        $slug = slugify($_POST['slug'] ?? $title);

        $model = new Facility();
        if ($model->findBy('slug', $slug)) {
            $slug .= '-' . time();
        }

        $imagePath = null;
        if (!empty($_FILES['image']['name'])) {
            $imagePath = UploadService::handleImageUpload($_FILES['image'], 'facilities');
        }

        $id = $model->create([
            'title' => $title,
            'slug' => $slug,
            'badge' => trim($_POST['badge'] ?? ''),
            'summary' => trim($_POST['summary'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'image' => $imagePath,
            'display_order' => (int)($_POST['display_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ]);

        AuditLog::log('create', 'facility', (string)$id, "Created facility: {$title}");
        flash('success', 'Facility card added successfully.');
        redirect('/admin/facilities');
    }

    public function edit(string $id): void
    {
        $model = new Facility();
        $facility = $model->find((int)$id);
        if (!$facility) {
            flash('error', 'Facility not found.');
            redirect('/admin/facilities');
        }

        View::render('admin.facilities.form', [
            'pageTitle' => 'Edit Facility | Admin',
            'facility' => $facility
        ], 'layouts.admin');
    }

    public function update(string $id): void
    {
        $model = new Facility();
        $facility = $model->find((int)$id);
        if (!$facility) {
            flash('error', 'Facility not found.');
            redirect('/admin/facilities');
        }

        $title = trim($_POST['title'] ?? '');
        $slug = slugify($_POST['slug'] ?? $title);

        $imagePath = $facility['image'];
        if (!empty($_FILES['image']['name'])) {
            $newImage = UploadService::handleImageUpload($_FILES['image'], 'facilities');
            if ($newImage) {
                $imagePath = $newImage;
            }
        }

        $model->update((int)$id, [
            'title' => $title,
            'slug' => $slug,
            'badge' => trim($_POST['badge'] ?? ''),
            'summary' => trim($_POST['summary'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'image' => $imagePath,
            'display_order' => (int)($_POST['display_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ]);

        AuditLog::log('update', 'facility', (string)$id, "Updated facility: {$title}");
        flash('success', 'Facility updated successfully.');
        redirect('/admin/facilities');
    }

    public function delete(string $id): void
    {
        $model = new Facility();
        $facility = $model->find((int)$id);
        if ($facility) {
            $model->delete((int)$id);
            AuditLog::log('delete', 'facility', (string)$id, "Deleted facility: {$facility['title']}");
            flash('success', 'Facility deleted successfully.');
        }
        redirect('/admin/facilities');
    }
}

