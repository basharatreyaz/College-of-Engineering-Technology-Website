<?php
/**
 * Admin Facility Form (Create / Edit)
 */
$isEdit = !empty($facility);
$action = $isEdit ? url('/admin/facilities/edit/' . $facility['id']) : url('/admin/facilities');
?>

<div class="page-title-box">
  <div>
    <h1><?= $isEdit ? 'Edit Facility Card' : 'Add Facility Card' ?></h1>
    <p class="admin-text-muted-sm">Update campus facility card specifications, badge, and descriptive details.</p>
  </div>
  <a href="<?= url('/admin/facilities') ?>" class="btn btn-outline btn-sm">&larr; Back to Facilities</a>
</div>

<div class="admin-card">
  <div class="admin-card-body">
    <form action="<?= $action ?>" method="POST" enctype="multipart/form-data">
      <?= csrf_field() ?>

      <div class="form-row">
        <div class="form-group form-group--2">
          <label class="form-label" for="fac_title">Facility Title *</label>
          <input type="text" id="fac_title" name="title" value="<?= e($facility['title'] ?? '') ?>" class="form-control" required data-slug-source="#fac_slug" placeholder="e.g. Spacious Library & Digital Resource Centre">
        </div>
        <div class="form-group form-group--1">
          <label class="form-label" for="fac_slug">Slug *</label>
          <input type="text" id="fac_slug" name="slug" value="<?= e($facility['slug'] ?? '') ?>" class="form-control" required placeholder="spacious-library">
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="fac_badge">Badge / Category Label</label>
          <input type="text" id="fac_badge" name="badge" value="<?= e($facility['badge'] ?? '') ?>" class="form-control" placeholder="Academic Hub, Campus Mobility, etc.">
        </div>
        <div class="form-group">
          <label class="form-label" for="display_order">Display Order</label>
          <input type="number" id="display_order" name="display_order" value="<?= e($facility['display_order'] ?? '0') ?>" class="form-control">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="summary">Short Summary *</label>
        <textarea id="summary" name="summary" class="form-control" rows="2" required><?= e($facility['summary'] ?? '') ?></textarea>
      </div>

      <div class="form-group">
        <label class="form-label" for="description">Full Description</label>
        <textarea id="description" name="description" class="form-control" rows="4"><?= e($facility['description'] ?? '') ?></textarea>
      </div>

      <div class="form-toggle-wrap">
        <label class="form-check-label">
          <input type="checkbox" name="is_active" value="1" <?= (!isset($facility['is_active']) || (int)$facility['is_active'] === 1) ? 'checked' : '' ?>>
          <span class="form-check-text">Active / Published on Website</span>
        </label>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Save Changes' : 'Create Facility' ?></button>
        <a href="<?= url('/admin/facilities') ?>" class="btn btn-outline">Cancel</a>
      </div>
    </form>
  </div>
</div>
