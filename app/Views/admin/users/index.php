<?php
/**
 * Admin Users Index View
 */
?>

<div class="page-title-box">
  <div>
    <h1>Admin Accounts & Roles</h1>
    <p class="admin-text-muted-sm">Manage administrator, admissions staff, and editor accounts with role-based access.</p>
  </div>
  <a href="<?= url('/admin/users/create') ?>" class="btn btn-primary btn-sm">+ Create Admin User</a>
</div>

<div class="admin-card">
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>User Name</th>
          <th>Email Address</th>
          <th>Role</th>
          <th>Status</th>
          <th>Last Login</th>
          <th class="text-right">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $u): ?>
        <tr>
          <td>
            <strong class="text-primary admin-card-title-sm font-bold"><?= e($u['name']) ?></strong>
          </td>
          <td><?= e($u['email']) ?></td>
          <td>
            <span class="badge badge-<?= $u['role'] === 'superadmin' ? 'danger' : ($u['role'] === 'admissions' ? 'warning' : 'info') ?>">
              <?= e($u['role']) ?>
            </span>
          </td>
          <td>
            <span class="badge badge-<?= $u['status'] === 'active' ? 'success' : 'muted' ?>">
              <?= e($u['status']) ?>
            </span>
          </td>
          <td class="text-sm text-muted">
            <?= !empty($u['last_login_at']) ? format_date($u['last_login_at'], 'd M, Y - h:i A') : 'Never' ?>
          </td>
          <td class="text-right">
            <div class="table-actions table-actions--right">
              <a href="<?= url('/admin/users/edit/' . $u['id']) ?>" class="btn btn-outline btn-icon">Edit</a>
              <?php if ((int)$u['id'] !== (int)auth_user()['id']): ?>
              <form action="<?= url('/admin/users/delete/' . $u['id']) ?>" method="POST" class="js-delete-form d-inline">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-outline btn-icon btn-delete">Delete</button>
              </form>
              <?php endif; ?>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
