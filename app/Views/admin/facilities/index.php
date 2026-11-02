<?php
/**
 * Admin Facilities Index View
 */
?>

<div class="page-title-box">
  <div>
    <h1>Campus Facilities</h1>
    <p class="admin-text-muted-sm">Manage the 12 campus facilities, descriptions, badges, and display orders.</p>
  </div>
  <a href="<?= url('/admin/facilities/create') ?>" class="btn btn-primary btn-sm">+ Add Facility</a>
</div>

<div class="admin-card">
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Facility Title</th>
          <th>Badge</th>
          <th>Summary</th>
          <th>Order</th>
          <th>Status</th>
          <th class="text-right">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($facilities as $facility): ?>
        <tr>
          <td>
            <strong class="admin-cell-title"><?= e($facility['title']) ?></strong>
            <span class="admin-cell-subtitle">Slug: <?= e($facility['slug']) ?></span>
          </td>
          <td>
            <?php if (!empty($facility['badge'])): ?>
              <span class="badge badge-success"><?= e($facility['badge']) ?></span>
            <?php endif; ?>
          </td>
          <td class="text-sm text-muted"><?= truncate($facility['summary'], 70) ?></td>
          <td><?= e($facility['display_order']) ?></td>
          <td>
            <span class="badge badge-<?= (int)$facility['is_active'] === 1 ? 'success' : 'danger' ?>">
              <?= (int)$facility['is_active'] === 1 ? 'Active' : 'Inactive' ?>
            </span>
          </td>
          <td class="text-right">
            <div class="table-actions table-actions--right">
              <a href="<?= url('/admin/facilities/edit/' . $facility['id']) ?>" class="btn btn-outline btn-icon">Edit</a>
              <form action="<?= url('/admin/facilities/delete/' . $facility['id']) ?>" method="POST" class="js-delete-form d-inline">
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
