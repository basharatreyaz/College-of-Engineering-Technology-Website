<?php
/**
 * Admin Notice Form (Create / Edit)
 */
$isEdit = !empty($notice);
$action = $isEdit ? url('/admin/notices/edit/' . $notice['id']) : url('/admin/notices');
?>

<div class="page-title-box">
  <div>
    <h1><?= $isEdit ? 'Edit Notice' : 'Post New Notice' ?></h1>
    <p class="admin-text-muted-sm">Draft or publish official announcements and circulars with PDF attachments.</p>
  </div>
  <a href="<?= url('/admin/notices') ?>" class="btn btn-outline btn-sm">&larr; Back to Notices</a>
</div>

<div class="admin-card">
  <div class="admin-card-body">
    <form action="<?= $action ?>" method="POST" enctype="multipart/form-data">
      <?= csrf_field() ?>

      <div class="form-row">
        <div class="form-group form-group--2">
          <label class="form-label" for="notice_title">Notice Title *</label>
          <input type="text" id="notice_title" name="title" value="<?= e($notice['title'] ?? '') ?>" class="form-control" required data-slug-source="#notice_slug" placeholder="e.g. Admission Notice for B.Tech Programmes 2026-27">
        </div>
        <div class="form-group form-group--1">
          <label class="form-label" for="notice_slug">Slug *</label>
          <input type="text" id="notice_slug" name="slug" value="<?= e($notice['slug'] ?? '') ?>" class="form-control" required placeholder="admission-notice-2026">
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="category">Notice Category *</label>
          <select id="category" name="category" class="form-control" required>
            <option value="admissions" <?= (($notice['category'] ?? '') === 'admissions') ? 'selected' : '' ?>>Admissions</option>
            <option value="academics" <?= (($notice['category'] ?? '') === 'academics') ? 'selected' : '' ?>>Academics</option>
            <option value="examinations" <?= (($notice['category'] ?? '') === 'examinations') ? 'selected' : '' ?>>Examinations</option>
            <option value="recruitment" <?= (($notice['category'] ?? '') === 'recruitment') ? 'selected' : '' ?>>Recruitment</option>
            <option value="general" <?= (($notice['category'] ?? 'general') === 'general') ? 'selected' : '' ?>>General</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label" for="publish_date">Publish Date *</label>
          <input type="date" id="publish_date" name="publish_date" value="<?= e($notice['publish_date'] ?? date('Y-m-d')) ?>" class="form-control" required>
        </div>

        <div class="form-group">
          <label class="form-label" for="expiry_date">Expiry Date (Optional)</label>
          <input type="date" id="expiry_date" name="expiry_date" value="<?= e($notice['expiry_date'] ?? '') ?>" class="form-control">
        </div>

        <div class="form-group">
          <label class="form-label" for="status">Publication Status</label>
          <select id="status" name="status" class="form-control">
            <option value="published" <?= (($notice['status'] ?? 'published') === 'published') ? 'selected' : '' ?>>Published</option>
            <option value="draft" <?= (($notice['status'] ?? '') === 'draft') ? 'selected' : '' ?>>Draft</option>
            <option value="archived" <?= (($notice['status'] ?? '') === 'archived') ? 'selected' : '' ?>>Archived</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="summary">Short Summary *</label>
        <textarea id="summary" name="summary" class="form-control" rows="2" required><?= e($notice['summary'] ?? '') ?></textarea>
      </div>

      <div class="form-group">
        <label class="form-label" for="content">Full Circular Content</label>
        <textarea id="content" name="content" class="form-control" rows="5"><?= e($notice['content'] ?? '') ?></textarea>
      </div>

      <div class="form-group">
        <label class="form-label" for="attachment_file">Official Document Attachment (PDF / Word)</label>
        <input type="file" id="attachment_file" name="attachment_file" class="form-control" accept=".pdf,.doc,.docx">
        <?php if (!empty($notice['attachment_file'])): ?>
          <span class="form-helper">Current file: <a href="<?= asset($notice['attachment_file']) ?>" target="_blank"><?= e($notice['attachment_file']) ?></a></span>
        <?php endif; ?>
      </div>

      <div class="form-toggle-wrap">
        <label class="form-check-label">
          <input type="checkbox" name="is_featured" value="1" <?= (!empty($notice['is_featured'])) ? 'checked' : '' ?>>
          <span class="form-check-text">Pin / Feature this Notice</span>
        </label>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Save Changes' : 'Publish Notice' ?></button>
        <a href="<?= url('/admin/notices') ?>" class="btn btn-outline">Cancel</a>
      </div>
    </form>
  </div>
</div>
