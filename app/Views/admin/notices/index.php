<?php
/**
 * Admin Notices Index View
 */
?>

<div class="page-title-box">
  <div>
    <h1>Notices & Announcements</h1>
    <p class="admin-text-muted-sm">Publish and manage college circulars, admission notices, and examination orders.</p>
  </div>
  <a href="<?= url('/admin/notices/create') ?>" class="btn btn-primary btn-sm">+ Post Notice</a>
</div>

<div class="admin-card">
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Notice Title</th>
          <th>Category</th>
          <th>Publish Date</th>
          <th>Expiry Date</th>
          <th>Featured</th>
          <th>Status</th>
          <th class="text-right">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($notices as $notice): ?>
        <tr>
          <td>
            <strong class="admin-cell-title"><?= e($notice['title']) ?></strong>
            <span class="admin-cell-subtitle">Slug: <?= e($notice['slug']) ?></span>
          </td>
          <td><span class="badge badge-info"><?= strtoupper(e($notice['category'])) ?></span></td>
          <td><?= format_date($notice['publish_date']) ?></td>
          <td><?= !empty($notice['expiry_date']) ? format_date($notice['expiry_date']) : 'Indefinite' ?></td>
          <td>
            <?= (int)$notice['is_featured'] === 1 ? '<span class="text-accent font-bold"><i class="fa-solid fa-star"></i> Yes</span>' : 'No' ?>
          </td>
          <td>
            <span class="badge badge-<?= $notice['status'] === 'published' ? 'success' : 'muted' ?>">
              <?= e($notice['status']) ?>
            </span>
          </td>
          <td class="text-right">
            <div class="table-actions table-actions--right">
              <a href="<?= url('/admin/notices/edit/' . $notice['id']) ?>" class="btn btn-outline btn-icon">Edit</a>
              <form action="<?= url('/admin/notices/delete/' . $notice['id']) ?>" method="POST" class="js-delete-form d-inline">
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
