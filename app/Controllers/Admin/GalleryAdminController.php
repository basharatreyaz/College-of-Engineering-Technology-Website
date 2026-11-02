<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\GalleryItem;
use App\Models\AuditLog;
use App\Services\View;
use App\Services\UploadService;

class GalleryAdminController
{
    public function index(): void
    {
        $model = new GalleryItem();
        $items = $model->all('category ASC, display_order ASC');

        View::render('admin.gallery.index', [
            'pageTitle' => 'Manage Campus Gallery | Admin',
            'items' => $items
        ], 'layouts.admin');
    }

    public function create(): void
    {
        View::render('admin.gallery.form', [
            'pageTitle' => 'Add Gallery Image | Admin',
            'item' => null
        ], 'layouts.admin');
    }

    public function store(): void
    {
        $title = trim($_POST['title'] ?? '');
        $imagePath = null;
        if (!empty($_FILES['image']['name'])) {
            $imagePath = UploadService::handleImageUpload($_FILES['image'], 'gallery');
        }

        if (!$imagePath) {
            flash('error', 'Please choose an image file to upload.');
            redirect('/admin/gallery/create');
        }

        $model = new GalleryItem();
        $id = $model->create([
            'title' => $title,
            'caption' => trim($_POST['caption'] ?? ''),
            'category' => trim($_POST['category'] ?? 'campus'),
            'image_url' => $imagePath,
            'display_order' => (int)($_POST['display_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ]);

        AuditLog::log('create', 'gallery', (string)$id, "Added gallery image: {$title}");
        flash('success', 'Gallery image added successfully.');
        redirect('/admin/gallery');
    }

    public function edit(string $id): void
    {
        $model = new GalleryItem();
        $item = $model->find((int)$id);
        if (!$item) {
            flash('error', 'Gallery item not found.');
            redirect('/admin/gallery');
        }

        View::render('admin.gallery.form', [
            'pageTitle' => 'Edit Gallery Item | Admin',
            'item' => $item
        ], 'layouts.admin');
    }

    public function update(string $id): void
    {
        $model = new GalleryItem();
        $item = $model->find((int)$id);
        if (!$item) {
            flash('error', 'Gallery item not found.');
            redirect('/admin/gallery');
        }

        $title = trim($_POST['title'] ?? '');
        $imagePath = $item['image_url'];
        if (!empty($_FILES['image']['name'])) {
            $newImage = UploadService::handleImageUpload($_FILES['image'], 'gallery');
            if ($newImage) {
                $imagePath = $newImage;
            }
        }

        $model->update((int)$id, [
            'title' => $title,
            'caption' => trim($_POST['caption'] ?? ''),
            'category' => trim($_POST['category'] ?? 'campus'),
            'image_url' => $imagePath,
            'display_order' => (int)($_POST['display_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ]);

        AuditLog::log('update', 'gallery', (string)$id, "Updated gallery item: {$title}");
        flash('success', 'Gallery image updated successfully.');
        redirect('/admin/gallery');
    }

    public function delete(string $id): void
    {
        $model = new GalleryItem();
        $item = $model->find((int)$id);
        if ($item) {
            $model->delete((int)$id);
            AuditLog::log('delete', 'gallery', (string)$id, "Deleted gallery image: {$item['title']}");
            flash('success', 'Gallery image removed successfully.');
        }
        redirect('/admin/gallery');
    }
}

