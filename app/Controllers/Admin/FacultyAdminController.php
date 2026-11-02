<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Faculty;
use App\Models\Department;
use App\Models\AuditLog;
use App\Services\View;
use App\Services\UploadService;

class FacultyAdminController
{
    public function index(): void
    {
        $model = new Faculty();
        $faculty = $model->all('display_order ASC, name ASC');

        $deptModel = new Department();
        $departments = [];
        foreach ($deptModel->all() as $d) {
            $departments[$d['id']] = $d['name'];
        }

        View::render('admin.faculty.index', [
            'pageTitle' => 'Manage Faculty | Admin',
            'faculty' => $faculty,
            'departments' => $departments
        ], 'layouts.admin');
    }

    public function create(): void
    {
        $deptModel = new Department();
        $departments = $deptModel->all();

        View::render('admin.faculty.form', [
            'pageTitle' => 'Add Faculty Member | Admin',
            'facultyMember' => null,
            'departments' => $departments
        ], 'layouts.admin');
    }

    public function store(): void
    {
        $name = trim($_POST['name'] ?? '');
        $slug = slugify($_POST['slug'] ?? $name);

        $model = new Faculty();
        if ($model->findBy('slug', $slug)) {
            $slug .= '-' . time();
        }

        $photoPath = null;
        if (!empty($_FILES['photo']['name'])) {
            $photoPath = UploadService::handleImageUpload($_FILES['photo'], 'faculty');
        }

        $cvPath = null;
        if (!empty($_FILES['cv_file']['name'])) {
            $cvPath = UploadService::handleDocumentUpload($_FILES['cv_file'], 'cv');
        }

        $id = $model->create([
            'name' => $name,
            'slug' => $slug,
            'department_id' => (int)($_POST['department_id'] ?? 0),
            'designation' => trim($_POST['designation'] ?? ''),
            'qualification' => trim($_POST['qualification'] ?? ''),
            'specialization' => trim($_POST['specialization'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'bio' => trim($_POST['bio'] ?? ''),
            'photo' => $photoPath,
            'cv_file' => $cvPath,
            'display_order' => (int)($_POST['display_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ]);

        AuditLog::log('create', 'faculty', (string)$id, "Created faculty: {$name}");
        flash('success', 'Faculty member added successfully.');
        redirect('/admin/faculty');
    }

    public function edit(string $id): void
    {
        $model = new Faculty();
        $member = $model->find((int)$id);
        if (!$member) {
            flash('error', 'Faculty member not found.');
            redirect('/admin/faculty');
        }

        $deptModel = new Department();
        $departments = $deptModel->all();

        View::render('admin.faculty.form', [
            'pageTitle' => 'Edit Faculty Member | Admin',
            'facultyMember' => $member,
            'departments' => $departments
        ], 'layouts.admin');
    }

    public function update(string $id): void
    {
        $model = new Faculty();
        $member = $model->find((int)$id);
        if (!$member) {
            flash('error', 'Faculty member not found.');
            redirect('/admin/faculty');
        }

        $name = trim($_POST['name'] ?? '');
        $slug = slugify($_POST['slug'] ?? $name);

        $photoPath = $member['photo'];
        if (!empty($_POST['remove_photo'])) {
            $photoPath = null;
        }
        if (!empty($_FILES['photo']['name'])) {
            $newPhoto = UploadService::handleImageUpload($_FILES['photo'], 'faculty');
            if ($newPhoto) {
                $photoPath = $newPhoto;
            }
        }

        $cvPath = $member['cv_file'];
        if (!empty($_FILES['cv_file']['name'])) {
            $newCv = UploadService::handleDocumentUpload($_FILES['cv_file'], 'cv');
            if ($newCv) {
                $cvPath = $newCv;
            }
        }

        $model->update((int)$id, [
            'name' => $name,
            'slug' => $slug,
            'department_id' => (int)($_POST['department_id'] ?? 0),
            'designation' => trim($_POST['designation'] ?? ''),
            'qualification' => trim($_POST['qualification'] ?? ''),
            'specialization' => trim($_POST['specialization'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'bio' => trim($_POST['bio'] ?? ''),
            'photo' => $photoPath,
            'cv_file' => $cvPath,
            'display_order' => (int)($_POST['display_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ]);

        AuditLog::log('update', 'faculty', (string)$id, "Updated faculty: {$name}");
        flash('success', 'Faculty member updated successfully.');
        redirect('/admin/faculty');
    }

    public function delete(string $id): void
    {
        $model = new Faculty();
        $member = $model->find((int)$id);
        if ($member) {
            $model->delete((int)$id);
            AuditLog::log('delete', 'faculty', (string)$id, "Deleted faculty: {$member['name']}");
            flash('success', 'Faculty member removed successfully.');
        }
        redirect('/admin/faculty');
    }
}

