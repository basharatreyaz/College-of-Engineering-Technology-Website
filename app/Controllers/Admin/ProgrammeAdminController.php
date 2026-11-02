<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Programme;
use App\Models\Department;
use App\Models\AuditLog;
use App\Services\View;
use App\Services\UploadService;

class ProgrammeAdminController
{
    public function index(): void
    {
        $model = new Programme();
        $programmes = $model->all('display_order ASC, name ASC');
        $deptModel = new Department();
        $departments = [];
        foreach ($deptModel->all() as $d) {
            $departments[$d['id']] = $d['name'];
        }

        View::render('admin.programmes.index', [
            'pageTitle' => 'Manage Programmes | Admin',
            'programmes' => $programmes,
            'departments' => $departments
        ], 'layouts.admin');
    }

    public function create(): void
    {
        $deptModel = new Department();
        $departments = $deptModel->all();

        View::render('admin.programmes.form', [
            'pageTitle' => 'Add Programme | Admin',
            'departments' => $departments,
            'programme' => null
        ], 'layouts.admin');
    }

    public function store(): void
    {
        $name = trim($_POST['name'] ?? '');
        $deptId = (int)($_POST['department_id'] ?? 0);
        $slug = slugify($_POST['slug'] ?? $name);

        $model = new Programme();
        if ($model->findBy('slug', $slug)) {
            $slug .= '-' . time();
        }

        $syllabusPath = null;
        if (!empty($_FILES['syllabus_file']['name'])) {
            $syllabusPath = UploadService::handleDocumentUpload($_FILES['syllabus_file'], 'syllabus');
        }

        $featuredImagePath = null;
        if (!empty($_FILES['featured_image']['name'])) {
            $featuredImagePath = UploadService::handleImageUpload($_FILES['featured_image'], 'programmes');
        }

        $id = $model->create([
            'name' => $name,
            'slug' => $slug,
            'department_id' => $deptId,
            'degree_type' => trim($_POST['degree_type'] ?? 'B.Tech'),
            'duration' => trim($_POST['duration'] ?? '4 Years (8 Semesters)'),
            'intake' => trim($_POST['intake'] ?? ''),
            'eligibility' => trim($_POST['eligibility'] ?? ''),
            'fee_info' => trim($_POST['fee_info'] ?? ''),
            'syllabus_file' => $syllabusPath,
            'featured_image' => $featuredImagePath,
            'summary' => trim($_POST['summary'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'career_prospects' => trim($_POST['career_prospects'] ?? ''),
            'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
            'is_admissions_open' => isset($_POST['is_admissions_open']) ? 1 : 0,
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
            'display_order' => (int)($_POST['display_order'] ?? 0),
        ]);

        AuditLog::log('create', 'programme', (string)$id, "Created programme: {$name}");
        flash('success', 'Programme created successfully.');
        redirect('/admin/programmes');
    }

    public function edit(string $id): void
    {
        $model = new Programme();
        $programme = $model->find((int)$id);
        if (!$programme) {
            flash('error', 'Programme not found.');
            redirect('/admin/programmes');
        }

        $deptModel = new Department();
        $departments = $deptModel->all();

        View::render('admin.programmes.form', [
            'pageTitle' => 'Edit Programme | Admin',
            'programme' => $programme,
            'departments' => $departments
        ], 'layouts.admin');
    }

    public function update(string $id): void
    {
        $model = new Programme();
        $programme = $model->find((int)$id);
        if (!$programme) {
            flash('error', 'Programme not found.');
            redirect('/admin/programmes');
        }

        $name = trim($_POST['name'] ?? '');
        $slug = slugify($_POST['slug'] ?? $name);

        $existing = $model->findBy('slug', $slug);
        if ($existing && (int)$existing['id'] !== (int)$id) {
            $slug .= '-' . time();
        }

        $syllabusPath = $programme['syllabus_file'];
        if (!empty($_FILES['syllabus_file']['name'])) {
            $newPath = UploadService::handleDocumentUpload($_FILES['syllabus_file'], 'syllabus');
            if ($newPath) {
                $syllabusPath = $newPath;
            }
        }

        $featuredImagePath = $programme['featured_image'] ?? null;
        if (!empty($_FILES['featured_image']['name'])) {
            $newImg = UploadService::handleImageUpload($_FILES['featured_image'], 'programmes');
            if ($newImg) {
                $featuredImagePath = $newImg;
            }
        }

        $model->update((int)$id, [
            'name' => $name,
            'slug' => $slug,
            'department_id' => (int)($_POST['department_id'] ?? 0),
            'degree_type' => trim($_POST['degree_type'] ?? 'B.Tech'),
            'duration' => trim($_POST['duration'] ?? '4 Years'),
            'intake' => trim($_POST['intake'] ?? ''),
            'eligibility' => trim($_POST['eligibility'] ?? ''),
            'fee_info' => trim($_POST['fee_info'] ?? ''),
            'syllabus_file' => $syllabusPath,
            'featured_image' => $featuredImagePath,
            'summary' => trim($_POST['summary'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'career_prospects' => trim($_POST['career_prospects'] ?? ''),
            'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
            'is_admissions_open' => isset($_POST['is_admissions_open']) ? 1 : 0,
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
            'display_order' => (int)($_POST['display_order'] ?? 0),
        ]);

        AuditLog::log('update', 'programme', (string)$id, "Updated programme: {$name}");
        flash('success', 'Programme updated successfully.');
        redirect('/admin/programmes');
    }

    public function delete(string $id): void
    {
        $model = new Programme();
        $programme = $model->find((int)$id);
        if ($programme) {
            $model->delete((int)$id);
            AuditLog::log('delete', 'programme', (string)$id, "Deleted programme: {$programme['name']}");
            flash('success', 'Programme deleted successfully.');
        }
        redirect('/admin/programmes');
    }
}

