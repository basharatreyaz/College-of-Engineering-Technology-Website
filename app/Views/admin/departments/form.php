<?php
/**
 * Admin Department Form (Create / Edit)
 */
$isEdit = !empty($department);
$action = $isEdit ? url('/admin/departments/edit/' . $department['id']) : url('/admin/departments');
?>

<div class="page-title-box">
  <div>
    <h1><?= $isEdit ? 'Edit Department' : 'Add Department' ?></h1>
    <p class="admin-text-muted-sm">Configure department details, laboratories, vision, mission, and HOD message.</p>
  </div>
  <a href="<?= url('/admin/departments') ?>" class="btn btn-outline btn-sm">&larr; Back to Departments</a>
</div>

<div class="admin-card">
  <div class="admin-card-body">
    <form action="<?= $action ?>" method="POST" enctype="multipart/form-data">
      <?= csrf_field() ?>

      <div class="form-row">
        <div class="form-group form-group--2">
          <label class="form-label" for="dept_name">Department Name *</label>
          <input type="text" id="dept_name" name="name" value="<?= e($department['name'] ?? '') ?>" class="form-control" required data-slug-source="#dept_slug" placeholder="e.g. Department of Computer Engineering">
        </div>
        <div class="form-group form-group--1">
          <label class="form-label" for="dept_slug">URL Slug *</label>
          <input type="text" id="dept_slug" name="slug" value="<?= e($department['slug'] ?? '') ?>" class="form-control" required placeholder="computer-engineering">
        </div>
        <div class="form-group form-group--1">
          <label class="form-label" for="dept_code">Branch Code *</label>
          <input type="text" id="dept_code" name="code" value="<?= e($department['code'] ?? '') ?>" class="form-control" required placeholder="CE, AIE, etc.">
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="hod_name">HOD Name</label>
          <input type="text" id="hod_name" name="hod_name" value="<?= e($department['hod_name'] ?? '') ?>" class="form-control" placeholder="e.g. Dr. Shabir Hussain">
        </div>
        <div class="form-group">
          <label class="form-label" for="hod_designation">HOD Designation</label>
          <input type="text" id="hod_designation" name="hod_designation" value="<?= e($department['hod_designation'] ?? 'Professor & HOD') ?>" class="form-control">
        </div>
        <div class="form-group">
          <label class="form-label" for="display_order">Display Order</label>
          <input type="number" id="display_order" name="display_order" value="<?= e($department['display_order'] ?? '0') ?>" class="form-control">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="hod_message">HOD Welcome Message</label>
        <textarea id="hod_message" name="hod_message" class="form-control" rows="3" placeholder="Welcome message from HOD to prospective and enrolled students..."><?= e($department['hod_message'] ?? '') ?></textarea>
      </div>

      <div class="form-group">
        <label class="form-label" for="overview">Department Overview</label>
        <textarea id="overview" name="overview" class="form-control" rows="4"><?= e($department['overview'] ?? '') ?></textarea>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="vision">Department Vision</label>
          <textarea id="vision" name="vision" class="form-control" rows="3"><?= e($department['vision'] ?? '') ?></textarea>
        </div>
        <div class="form-group">
          <label class="form-label" for="mission">Department Mission</label>
          <textarea id="mission" name="mission" class="form-control" rows="3"><?= e($department['mission'] ?? '') ?></textarea>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="labs_info">Laboratories & Research Equipment Description</label>
        <textarea id="labs_info" name="labs_info" class="form-control" rows="3"><?= e($department['labs_info'] ?? '') ?></textarea>
      </div>

      <div class="form-toggle-wrap">
        <label class="form-check-label">
          <input type="checkbox" name="is_active" value="1" <?= (!isset($department['is_active']) || (int)$department['is_active'] === 1) ? 'checked' : '' ?>>
          <span class="form-check-text">Active / Published on Website</span>
        </label>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Save Department' : 'Create Department' ?></button>
        <a href="<?= url('/admin/departments') ?>" class="btn btn-outline">Cancel</a>
      </div>
    </form>
  </div>
</div>
