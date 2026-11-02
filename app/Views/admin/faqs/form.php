<?php
/**
 * Admin FAQ Form (Create / Edit)
 */
$isEdit = !empty($faq);
$action = $isEdit ? url('/admin/faqs/edit/' . $faq['id']) : url('/admin/faqs');
?>

<div class="page-title-box">
  <div>
    <h1><?= $isEdit ? 'Edit FAQ' : 'Add New FAQ' ?></h1>
    <p class="admin-text-muted-sm">Update accordion question, answer, and category placement.</p>
  </div>
  <a href="<?= url('/admin/faqs') ?>" class="btn btn-outline btn-sm">&larr; Back to FAQs</a>
</div>

<div class="admin-card">
  <div class="admin-card-body">
    <form action="<?= $action ?>" method="POST">
      <?= csrf_field() ?>

      <div class="form-row">
        <div class="form-group form-group--2">
          <label class="form-label" for="faq_cat">Category *</label>
          <select id="faq_cat" name="category" class="form-control" required>
            <option value="admissions" <?= (($faq['category'] ?? '') === 'admissions') ? 'selected' : '' ?>>Admissions</option>
            <option value="academics" <?= (($faq['category'] ?? '') === 'academics') ? 'selected' : '' ?>>Academics</option>
            <option value="facilities" <?= (($faq['category'] ?? '') === 'facilities') ? 'selected' : '' ?>>Facilities & Transport</option>
            <option value="general" <?= (($faq['category'] ?? 'general') === 'general') ? 'selected' : '' ?>>General</option>
          </select>
        </div>

        <div class="form-group form-group--1">
          <label class="form-label" for="display_order">Display Order</label>
          <input type="number" id="display_order" name="display_order" value="<?= e($faq['display_order'] ?? '0') ?>" class="form-control">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="question">Question *</label>
        <input type="text" id="question" name="question" value="<?= e($faq['question'] ?? '') ?>" class="form-control" required placeholder="e.g. What is the eligibility for Lateral Entry into B.Tech?">
      </div>

      <div class="form-group">
        <label class="form-label" for="answer">Answer *</label>
        <textarea id="answer" name="answer" class="form-control" rows="4" required><?= e($faq['answer'] ?? '') ?></textarea>
      </div>

      <div class="form-toggle-wrap">
        <label class="form-check-label">
          <input type="checkbox" name="is_active" value="1" <?= (!isset($faq['is_active']) || (int)$faq['is_active'] === 1) ? 'checked' : '' ?>>
          <span class="form-check-text">Active / Published in FAQ Accordion</span>
        </label>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Save Changes' : 'Create FAQ' ?></button>
        <a href="<?= url('/admin/faqs') ?>" class="btn btn-outline">Cancel</a>
      </div>
    </form>
  </div>
</div>
