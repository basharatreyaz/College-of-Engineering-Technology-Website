<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Department;
use App\Models\AuditLog;
use App\Services\View;
use App\Services\UploadService;

class DepartmentAdminController
{
    public function index(): void
    {
        $model = new Department();
        $departments = $model->all('display_order ASC, name ASC');

        View::render('admin.departments.index', [
            'pageTitle' => 'Manage Departments | Admin',
            'departments' => $departments
        ], 'layouts.admin');
    }

    public function create(): void
    {
        View::render('admin.departments.form', [
            'pageTitle' => 'Add Department | Admin',
            'department' => null
        ], 'layouts.admin');
    }

    public function store(): void
    {
        $name = trim($_POST['name'] ?? '');
        $code = trim($_POST['code'] ?? '');
        $slug = slugify($_POST['slug'] ?? $name);

        $model = new Department();
        if ($model->findBy('slug', $slug)) {
            $slug .= '-' . time();
        }

        $photoPath = null;
        if (!empty($_FILES['hod_photo']['name'])) {
            $photoPath = UploadService::handleImageUpload($_FILES['hod_photo'], 'faculty');
        }

        $id = $model->create([
            'name' => $name,
            'slug' => $slug,
            'code' => $code,
            'hod_name' => trim($_POST['hod_name'] ?? ''),
            'hod_designation' => trim($_POST['hod_designation'] ?? ''),
            'hod_photo' => $photoPath,
            'hod_message' => trim($_POST['hod_message'] ?? ''),
            'vision' => trim($_POST['vision'] ?? ''),
            'mission' => trim($_POST['mission'] ?? ''),
            'overview' => trim($_POST['overview'] ?? ''),
            'labs_info' => trim($_POST['labs_info'] ?? ''),
            'display_order' => (int)($_POST['display_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ]);

        AuditLog::log('create', 'department', (string)$id, "Created department: {$name}");
        flash('success', 'Department created successfully.');
        redirect('/admin/departments');
    }

    public function edit(string $id): void
    {
        $model = new Department();
        $department = $model->find((int)$id);
        if (!$department) {
            flash('error', 'Department not found.');
            redirect('/admin/departments');
        }

        View::render('admin.departments.form', [
            'pageTitle' => 'Edit Department | Admin',
            'department' => $department
        ], 'layouts.admin');
    }

    public function update(string $id): void
    {
        $model = new Department();
        $department = $model->find((int)$id);
        if (!$department) {
            flash('error', 'Department not found.');
            redirect('/admin/departments');
        }

        $name = trim($_POST['name'] ?? '');
        $slug = slugify($_POST['slug'] ?? $name);

        $photoPath = $department['hod_photo'];
        if (!empty($_FILES['hod_photo']['name'])) {
            $newPhoto = UploadService::handleImageUpload($_FILES['hod_photo'], 'faculty');
            if ($newPhoto) {
                $photoPath = $newPhoto;
            }
        }

        $model->update((int)$id, [
            'name' => $name,
            'slug' => $slug,
            'code' => trim($_POST['code'] ?? ''),
            'hod_name' => trim($_POST['hod_name'] ?? ''),
            'hod_designation' => trim($_POST['hod_designation'] ?? ''),
            'hod_photo' => $photoPath,
            'hod_message' => trim($_POST['hod_message'] ?? ''),
            'vision' => trim($_POST['vision'] ?? ''),
            'mission' => trim($_POST['mission'] ?? ''),
            'overview' => trim($_POST['overview'] ?? ''),
            'labs_info' => trim($_POST['labs_info'] ?? ''),
            'display_order' => (int)($_POST['display_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ]);

        AuditLog::log('update', 'department', (string)$id, "Updated department: {$name}");
        flash('success', 'Department updated successfully.');
        redirect('/admin/departments');
    }

    public function delete(string $id): void
    {
        $model = new Department();
        $dept = $model->find((int)$id);
        if ($dept) {
            $model->delete((int)$id);
            AuditLog::log('delete', 'department', (string)$id, "Deleted department: {$dept['name']}");
            flash('success', 'Department deleted successfully.');
        }
        redirect('/admin/departments');
    }
}

