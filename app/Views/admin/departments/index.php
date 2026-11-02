<?php
/**
 * Admin Departments Index View
 */
?>

<div class="page-title-box">
  <div>
    <h1>Academic Departments</h1>
    <p class="admin-text-muted-sm">Manage engineering departments, HOD profiles, laboratories, and vision.</p>
  </div>
  <a href="<?= url('/admin/departments/create') ?>" class="btn btn-primary btn-sm">+ Add Department</a>
</div>

<div class="admin-card">
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Department Name</th>
          <th>Code</th>
          <th>Head of Department (HOD)</th>
          <th>Order</th>
          <th>Status</th>
          <th class="text-right">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($departments as $dept): ?>
        <tr>
          <td>
            <strong class="admin-cell-title"><?= e($dept['name']) ?></strong>
            <span class="admin-cell-subtitle">Slug: <?= e($dept['slug']) ?></span>
          </td>
          <td><span class="badge badge-info"><?= e($dept['code']) ?></span></td>
          <td>
            <span class="font-semibold"><?= e($dept['hod_name'] ?: 'Not assigned') ?></span>
          </td>
          <td><?= e($dept['display_order']) ?></td>
          <td>
            <span class="badge badge-<?= (int)$dept['is_active'] === 1 ? 'success' : 'danger' ?>">
              <?= (int)$dept['is_active'] === 1 ? 'Active' : 'Inactive' ?>
            </span>
          </td>
          <td class="text-right">
            <div class="table-actions table-actions--right">
              <a href="<?= url('/admin/departments/edit/' . $dept['id']) ?>" class="btn btn-outline btn-icon">Edit</a>
              <form action="<?= url('/admin/departments/delete/' . $dept['id']) ?>" method="POST" class="js-delete-form d-inline">
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
