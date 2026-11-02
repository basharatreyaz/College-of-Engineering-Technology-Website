<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Faq;
use App\Models\AuditLog;
use App\Services\View;

class FaqAdminController
{
    public function index(): void
    {
        $model = new Faq();
        $faqs = $model->all('category ASC, display_order ASC');

        View::render('admin.faqs.index', [
            'pageTitle' => 'Manage FAQs | Admin',
            'faqs' => $faqs
        ], 'layouts.admin');
    }

    public function create(): void
    {
        View::render('admin.faqs.form', [
            'pageTitle' => 'Add FAQ | Admin',
            'faq' => null
        ], 'layouts.admin');
    }

    public function store(): void
    {
        $question = trim($_POST['question'] ?? '');
        $model = new Faq();

        $id = $model->create([
            'category' => trim($_POST['category'] ?? 'general'),
            'question' => $question,
            'answer' => trim($_POST['answer'] ?? ''),
            'display_order' => (int)($_POST['display_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ]);

        AuditLog::log('create', 'faq', (string)$id, "Created FAQ: {$question}");
        flash('success', 'FAQ added successfully.');
        redirect('/admin/faqs');
    }

    public function edit(string $id): void
    {
        $model = new Faq();
        $faq = $model->find((int)$id);
        if (!$faq) {
            flash('error', 'FAQ not found.');
            redirect('/admin/faqs');
        }

        View::render('admin.faqs.form', [
            'pageTitle' => 'Edit FAQ | Admin',
            'faq' => $faq
        ], 'layouts.admin');
    }

    public function update(string $id): void
    {
        $model = new Faq();
        $faq = $model->find((int)$id);
        if (!$faq) {
            flash('error', 'FAQ not found.');
            redirect('/admin/faqs');
        }

        $question = trim($_POST['question'] ?? '');
        $model->update((int)$id, [
            'category' => trim($_POST['category'] ?? 'general'),
            'question' => $question,
            'answer' => trim($_POST['answer'] ?? ''),
            'display_order' => (int)($_POST['display_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ]);

        AuditLog::log('update', 'faq', (string)$id, "Updated FAQ: {$question}");
        flash('success', 'FAQ updated successfully.');
        redirect('/admin/faqs');
    }

    public function delete(string $id): void
    {
        $model = new Faq();
        $faq = $model->find((int)$id);
        if ($faq) {
            $model->delete((int)$id);
            AuditLog::log('delete', 'faq', (string)$id, "Deleted FAQ: {$faq['question']}");
            flash('success', 'FAQ deleted successfully.');
        }
        redirect('/admin/faqs');
    }
}

