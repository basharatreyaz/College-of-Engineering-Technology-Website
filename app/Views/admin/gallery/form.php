<?php
/**
 * Admin Gallery Form (Create / Edit)
 */
$isEdit = !empty($item);
$action = $isEdit ? url('/admin/gallery/edit/' . $item['id']) : url('/admin/gallery');
?>

<div class="page-title-box">
  <div>
    <h1><?= $isEdit ? 'Edit Gallery Item' : 'Upload Gallery Image' ?></h1>
    <p class="admin-text-muted-sm">Upload real campus photos with meaningful captions and alt text.</p>
  </div>
  <a href="<?= url('/admin/gallery') ?>" class="btn btn-outline btn-sm">&larr; Back to Gallery</a>
</div>

<div class="admin-card">
  <div class="admin-card-body">
    <form action="<?= $action ?>" method="POST" enctype="multipart/form-data">
      <?= csrf_field() ?>

      <div class="form-row">
        <div class="form-group form-group--2">
          <label class="form-label" for="gal_title">Image Title *</label>
          <input type="text" id="gal_title" name="title" value="<?= e($item['title'] ?? '') ?>" class="form-control" required placeholder="e.g. Computer Science Laboratory Workstation">
        </div>

        <div class="form-group form-group--1">
          <label class="form-label" for="category">Category *</label>
          <select id="category" name="category" class="form-control" required>
            <option value="campus" <?= (($item['category'] ?? '') === 'campus') ? 'selected' : '' ?>>Campus Estate</option>
            <option value="labs" <?= (($item['category'] ?? '') === 'labs') ? 'selected' : '' ?>>Laboratories</option>
            <option value="events" <?= (($item['category'] ?? '') === 'events') ? 'selected' : '' ?>>Events & Fests</option>
            <option value="sports" <?= (($item['category'] ?? '') === 'sports') ? 'selected' : '' ?>>Sports & Recreation</option>
          </select>
        </div>

        <div class="form-group form-group--1">
          <label class="form-label" for="display_order">Display Order</label>
          <input type="number" id="display_order" name="display_order" value="<?= e($item['display_order'] ?? '0') ?>" class="form-control">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="caption">Descriptive Caption</label>
        <textarea id="caption" name="caption" class="form-control" rows="2" placeholder="Brief context or description..."><?= e($item['caption'] ?? '') ?></textarea>
      </div>

      <div class="form-group">
        <label class="form-label" for="image">Choose Image File (JPG, PNG, WEBP) <?= $isEdit ? '' : '*' ?></label>
        <input type="file" id="image" name="image" class="form-control" accept="image/*" <?= $isEdit ? '' : 'required' ?>>
        <?php if (!empty($item['image_url'])): ?>
          <span class="form-helper">Current file path: <?= e($item['image_url']) ?></span>
        <?php endif; ?>
      </div>

      <div class="form-toggle-wrap">
        <label class="form-check-label">
          <input type="checkbox" name="is_active" value="1" <?= (!isset($item['is_active']) || (int)$item['is_active'] === 1) ? 'checked' : '' ?>>
          <span class="form-check-text">Active in Public Gallery</span>
        </label>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Save Changes' : 'Upload Image' ?></button>
        <a href="<?= url('/admin/gallery') ?>" class="btn btn-outline">Cancel</a>
      </div>
    </form>
  </div>
</div>
