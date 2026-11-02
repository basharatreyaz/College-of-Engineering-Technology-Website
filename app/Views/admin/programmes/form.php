<?php
/**
 * Admin Programme Form (Create / Edit)
 */
$isEdit = !empty($programme);
$action = $isEdit ? url('/admin/programmes/edit/' . $programme['id']) : url('/admin/programmes');
?>

<div class="page-title-box">
  <div>
    <h1><?= $isEdit ? 'Edit Programme' : 'Add New Programme' ?></h1>
    <p class="admin-text-muted-sm">Configure programme details, syllabus, eligibility, and admission controls.</p>
  </div>
  <a href="<?= url('/admin/programmes') ?>" class="btn btn-outline btn-sm">&larr; Back to Catalog</a>
</div>

<div class="admin-card">
  <div class="admin-card-body">
    <form action="<?= $action ?>" method="POST" enctype="multipart/form-data">
      <?= csrf_field() ?>

      <div class="form-row">
        <div class="form-group form-group--2">
          <label class="form-label" for="prog_name">Programme Title *</label>
          <input type="text" id="prog_name" name="name" value="<?= e($programme['name'] ?? '') ?>" class="form-control" required data-slug-source="#prog_slug" placeholder="e.g. B.Tech in Artificial Intelligence Engineering">
        </div>
        <div class="form-group form-group--1">
          <label class="form-label" for="prog_slug">URL Slug *</label>
          <input type="text" id="prog_slug" name="slug" value="<?= e($programme['slug'] ?? '') ?>" class="form-control" required placeholder="b-tech-artificial-intelligence">
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="dept_id">Department *</label>
          <select id="dept_id" name="department_id" class="form-control" required>
            <option value="">-- Select Academic Department --</option>
            <?php foreach ($departments as $d): ?>
              <option value="<?= $d['id'] ?>" <?= (($programme['department_id'] ?? 0) == $d['id']) ? 'selected' : '' ?>>
                <?= e($d['name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label" for="degree_type">Degree Awarded</label>
          <input type="text" id="degree_type" name="degree_type" value="<?= e($programme['degree_type'] ?? 'B.Tech') ?>" class="form-control">
        </div>

        <div class="form-group">
          <label class="form-label" for="duration">Duration</label>
          <input type="text" id="duration" name="duration" value="<?= e($programme['duration'] ?? '4 Years (8 Semesters)') ?>" class="form-control">
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="intake">Approved Intake (Seats)</label>
          <input type="text" id="intake" name="intake" value="<?= e($programme['intake'] ?? '') ?>" class="form-control" placeholder="e.g. 60 Seats">
        </div>

        <div class="form-group">
          <label class="form-label" for="display_order">Display Order</label>
          <input type="number" id="display_order" name="display_order" value="<?= e($programme['display_order'] ?? '0') ?>" class="form-control">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="summary">Short Summary *</label>
        <textarea id="summary" name="summary" class="form-control" rows="2" required placeholder="Brief introductory synopsis for cards and search..."><?= e($programme['summary'] ?? '') ?></textarea>
      </div>

      <div class="form-group">
        <label class="form-label" for="description">Full Description & Curriculum Scope</label>
        <textarea id="description" name="description" class="form-control" rows="5" placeholder="Comprehensive course overview, lab projects, core subjects..."><?= e($programme['description'] ?? '') ?></textarea>
      </div>

      <div class="form-group">
        <label class="form-label" for="eligibility">Eligibility Criteria</label>
        <textarea id="eligibility" name="eligibility" class="form-control" rows="3"><?= e($programme['eligibility'] ?? '') ?></textarea>
      </div>

      <div class="form-group">
        <label class="form-label" for="career_prospects">Career Prospects & Job Roles</label>
        <textarea id="career_prospects" name="career_prospects" class="form-control" rows="2"><?= e($programme['career_prospects'] ?? '') ?></textarea>
      </div>

      <div class="form-group">
        <label class="form-label" for="fee_info">Fee Information & Scholarship Note</label>
        <textarea id="fee_info" name="fee_info" class="form-control" rows="2"><?= e($programme['fee_info'] ?? '') ?></textarea>
      </div>

      <div class="form-row">
        <div class="form-group form-group--1">
          <label class="form-label" for="featured_image">Course Featured Image (JPG, PNG, WebP)</label>
          <input type="file" id="featured_image" name="featured_image" class="form-control" accept="image/jpeg,image/png,image/webp">
          <?php if (!empty($programme['featured_image'])): ?>
            <div class="admin-photo-card">
              <img src="<?= asset($programme['featured_image']) ?>" alt="Current featured image" class="admin-preview-img">
              <div>
                <span class="form-helper d-block font-semibold text-primary"><?= e($programme['featured_image']) ?></span>
                <span class="admin-cell-subtitle">Upload a new image to replace current</span>
              </div>
            </div>
          <?php endif; ?>
        </div>

        <div class="form-group form-group--1">
          <label class="form-label" for="syllabus_file">Curriculum / Syllabus PDF Document</label>
          <input type="file" id="syllabus_file" name="syllabus_file" class="form-control" accept=".pdf,.doc,.docx">
          <?php if (!empty($programme['syllabus_file'])): ?>
            <span class="form-helper d-block">Current file: <a href="<?= asset($programme['syllabus_file']) ?>" target="_blank" class="text-primary font-semibold"><?= e($programme['syllabus_file']) ?></a></span>
          <?php endif; ?>
        </div>
      </div>

      <div class="form-toggle-wrap">
        <label class="form-check-label">
          <input type="checkbox" name="is_featured" value="1" <?= (!empty($programme['is_featured'])) ? 'checked' : '' ?>>
          <span class="form-check-text">Featured on Homepage</span>
        </label>
        <label class="form-check-label">
          <input type="checkbox" name="is_admissions_open" value="1" <?= (!isset($programme['is_admissions_open']) || (int)$programme['is_admissions_open'] === 1) ? 'checked' : '' ?>>
          <span class="form-check-text">Admissions Open</span>
        </label>
        <label class="form-check-label">
          <input type="checkbox" name="is_active" value="1" <?= (!isset($programme['is_active']) || (int)$programme['is_active'] === 1) ? 'checked' : '' ?>>
          <span class="form-check-text">Published / Active</span>
        </label>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Save Changes' : 'Create Programme' ?></button>
        <a href="<?= url('/admin/programmes') ?>" class="btn btn-outline">Cancel</a>
      </div>
    </form>
  </div>
</div>
