<?php
/**
 * Admin Events Index View
 */
?>

<div class="page-title-box">
  <div>
    <h1>Events & Stories</h1>
    <p class="admin-text-muted-sm">Manage campus symposiums, hackathons, guest lectures, and student tours.</p>
  </div>
  <a href="<?= url('/admin/events/create') ?>" class="btn btn-primary btn-sm">+ Add Event</a>
</div>

<div class="admin-card">
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Event Title</th>
          <th>Category</th>
          <th>Start Date</th>
          <th>Location</th>
          <th>Featured</th>
          <th>Status</th>
          <th class="text-right">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($events as $event): ?>
        <tr>
          <td>
            <strong class="admin-cell-title"><?= e($event['title']) ?></strong>
            <span class="admin-cell-subtitle">Slug: <?= e($event['slug']) ?></span>
          </td>
          <td><span class="badge badge-info"><?= e($event['category']) ?></span></td>
          <td><?= format_date($event['start_date']) ?></td>
          <td class="text-sm"><?= e($event['location'] ?: 'Campus') ?></td>
          <td>
            <?= (int)$event['is_featured'] === 1 ? '<span class="text-accent font-bold"><i class="fa-solid fa-star"></i> Yes</span>' : 'No' ?>
          </td>
          <td>
            <span class="badge badge-<?= $event['status'] === 'published' ? 'success' : 'muted' ?>">
              <?= e($event['status']) ?>
            </span>
          </td>
          <td class="text-right">
            <div class="table-actions table-actions--right">
              <a href="<?= url('/admin/events/edit/' . $event['id']) ?>" class="btn btn-outline btn-icon">Edit</a>
              <form action="<?= url('/admin/events/delete/' . $event['id']) ?>" method="POST" class="js-delete-form d-inline">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-outline btn-icon btn-delete">Delete</button>
              </form>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
