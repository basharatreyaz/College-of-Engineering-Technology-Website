<?php
/**
 * Admin Gallery Index View
 */
?>

<div class="page-title-box">
  <div>
    <h1>Campus Gallery</h1>
    <p class="admin-text-muted-sm">Manage campus photos, laboratory equipment snapshots, and event memories.</p>
  </div>
  <a href="<?= url('/admin/gallery/create') ?>" class="btn btn-primary btn-sm">+ Upload Gallery Item</a>
</div>

<div class="admin-card">
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Title & Caption</th>
          <th>Category</th>
          <th>Order</th>
          <th>Status</th>
          <th class="text-right">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($items as $item): ?>
        <tr>
          <td>
            <strong class="admin-cell-title"><?= e($item['title']) ?></strong>
            <span class="admin-cell-subtitle"><?= e($item['caption']) ?></span>
          </td>
          <td><span class="badge badge-info"><?= strtoupper(e($item['category'])) ?></span></td>
          <td><?= e($item['display_order']) ?></td>
          <td>
            <span class="badge badge-<?= (int)$item['is_active'] === 1 ? 'success' : 'danger' ?>">
              <?= (int)$item['is_active'] === 1 ? 'Active' : 'Inactive' ?>
            </span>
          </td>
          <td class="text-right">
            <div class="table-actions table-actions--right">
              <a href="<?= url('/admin/gallery/edit/' . $item['id']) ?>" class="btn btn-outline btn-icon">Edit</a>
              <form action="<?= url('/admin/gallery/delete/' . $item['id']) ?>" method="POST" class="js-delete-form d-inline">
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
