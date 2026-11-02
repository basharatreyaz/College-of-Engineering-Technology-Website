<?php
/**
 * Admin Event Form (Create / Edit)
 */
$isEdit = !empty($event);
$action = $isEdit ? url('/admin/events/edit/' . $event['id']) : url('/admin/events');
?>

<div class="page-title-box">
  <div>
    <h1><?= $isEdit ? 'Edit Event' : 'Create New Event' ?></h1>
    <p class="admin-text-muted-sm">Update campus event stories, technical boot camps, or field visits.</p>
  </div>
  <a href="<?= url('/admin/events') ?>" class="btn btn-outline btn-sm">&larr; Back to Events</a>
</div>

<div class="admin-card">
  <div class="admin-card-body">
    <form action="<?= $action ?>" method="POST" enctype="multipart/form-data">
      <?= csrf_field() ?>

      <div class="form-row">
        <div class="form-group form-group--2">
          <label class="form-label" for="event_title">Event Title *</label>
          <input type="text" id="event_title" name="title" value="<?= e($event['title'] ?? '') ?>" class="form-control" required data-slug-source="#event_slug" placeholder="e.g. Annual Technical Boot Camp 2026">
        </div>
        <div class="form-group form-group--1">
          <label class="form-label" for="event_slug">Slug *</label>
          <input type="text" id="event_slug" name="slug" value="<?= e($event['slug'] ?? '') ?>" class="form-control" required placeholder="annual-technical-boot-camp">
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="event_category">Category *</label>
          <input type="text" id="event_category" name="category" value="<?= e($event['category'] ?? 'Academic') ?>" class="form-control" required placeholder="Technical Fest, Field Visit, Workshop">
        </div>

        <div class="form-group">
          <label class="form-label" for="start_date">Start Date *</label>
          <input type="date" id="start_date" name="start_date" value="<?= e($event['start_date'] ?? date('Y-m-d')) ?>" class="form-control" required>
        </div>

        <div class="form-group">
          <label class="form-label" for="end_date">End Date</label>
          <input type="date" id="end_date" name="end_date" value="<?= e($event['end_date'] ?? '') ?>" class="form-control">
        </div>

        <div class="form-group">
          <label class="form-label" for="location">Location / Venue</label>
          <input type="text" id="location" name="location" value="<?= e($event['location'] ?? '') ?>" class="form-control" placeholder="e.g. Multipurpose Hall / Peer Ki Gali">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="summary">Short Summary *</label>
        <textarea id="summary" name="summary" class="form-control" rows="2" required><?= e($event['summary'] ?? '') ?></textarea>
      </div>

      <div class="form-group">
        <label class="form-label" for="content">Full Article / Event Body</label>
        <textarea id="content" name="content" class="form-control" rows="5"><?= e($event['content'] ?? '') ?></textarea>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="status">Status</label>
          <select id="status" name="status" class="form-control">
            <option value="published" <?= (($event['status'] ?? 'published') === 'published') ? 'selected' : '' ?>>Published</option>
            <option value="draft" <?= (($event['status'] ?? '') === 'draft') ? 'selected' : '' ?>>Draft</option>
          </select>
        </div>
      </div>

      <div class="form-toggle-wrap">
        <label class="form-check-label">
          <input type="checkbox" name="is_featured" value="1" <?= (!empty($event['is_featured'])) ? 'checked' : '' ?>>
          <span class="form-check-text">Feature on Homepage</span>
        </label>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Save Changes' : 'Create Event' ?></button>
        <a href="<?= url('/admin/events') ?>" class="btn btn-outline">Cancel</a>
      </div>
    </form>
  </div>
</div>
