<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Event;
use App\Models\AuditLog;
use App\Services\View;
use App\Services\UploadService;

class EventAdminController
{
    public function index(): void
    {
        $model = new Event();
        $events = $model->all('start_date DESC');

        View::render('admin.events.index', [
            'pageTitle' => 'Manage Events | Admin',
            'events' => $events
        ], 'layouts.admin');
    }

    public function create(): void
    {
        View::render('admin.events.form', [
            'pageTitle' => 'Add Event | Admin',
            'event' => null
        ], 'layouts.admin');
    }

    public function store(): void
    {
        $title = trim($_POST['title'] ?? '');
        $slug = slugify($_POST['slug'] ?? $title);

        $model = new Event();
        if ($model->findBy('slug', $slug)) {
            $slug .= '-' . time();
        }

        $imagePath = null;
        if (!empty($_FILES['featured_image']['name'])) {
            $imagePath = UploadService::handleImageUpload($_FILES['featured_image'], 'events');
        }

        $id = $model->create([
            'title' => $title,
            'slug' => $slug,
            'category' => trim($_POST['category'] ?? 'Academic'),
            'start_date' => $_POST['start_date'] ?? date('Y-m-d'),
            'end_date' => !empty($_POST['end_date']) ? $_POST['end_date'] : null,
            'location' => trim($_POST['location'] ?? ''),
            'summary' => trim($_POST['summary'] ?? ''),
            'content' => trim($_POST['content'] ?? ''),
            'featured_image' => $imagePath,
            'status' => trim($_POST['status'] ?? 'published'),
            'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
        ]);

        AuditLog::log('create', 'event', (string)$id, "Created event: {$title}");
        flash('success', 'Event published successfully.');
        redirect('/admin/events');
    }

    public function edit(string $id): void
    {
        $model = new Event();
        $event = $model->find((int)$id);
        if (!$event) {
            flash('error', 'Event not found.');
            redirect('/admin/events');
        }

        View::render('admin.events.form', [
            'pageTitle' => 'Edit Event | Admin',
            'event' => $event
        ], 'layouts.admin');
    }

    public function update(string $id): void
    {
        $model = new Event();
        $event = $model->find((int)$id);
        if (!$event) {
            flash('error', 'Event not found.');
            redirect('/admin/events');
        }

        $title = trim($_POST['title'] ?? '');
        $slug = slugify($_POST['slug'] ?? $title);

        $imagePath = $event['featured_image'];
        if (!empty($_FILES['featured_image']['name'])) {
            $newImage = UploadService::handleImageUpload($_FILES['featured_image'], 'events');
            if ($newImage) {
                $imagePath = $newImage;
            }
        }

        $model->update((int)$id, [
            'title' => $title,
            'slug' => $slug,
            'category' => trim($_POST['category'] ?? 'Academic'),
            'start_date' => $_POST['start_date'] ?? date('Y-m-d'),
            'end_date' => !empty($_POST['end_date']) ? $_POST['end_date'] : null,
            'location' => trim($_POST['location'] ?? ''),
            'summary' => trim($_POST['summary'] ?? ''),
            'content' => trim($_POST['content'] ?? ''),
            'featured_image' => $imagePath,
            'status' => trim($_POST['status'] ?? 'published'),
            'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
        ]);

        AuditLog::log('update', 'event', (string)$id, "Updated event: {$title}");
        flash('success', 'Event updated successfully.');
        redirect('/admin/events');
    }

    public function delete(string $id): void
    {
        $model = new Event();
        $event = $model->find((int)$id);
        if ($event) {
            $model->delete((int)$id);
            AuditLog::log('delete', 'event', (string)$id, "Deleted event: {$event['title']}");
            flash('success', 'Event deleted successfully.');
        }
        redirect('/admin/events');
    }
}

