<?php
/**
 * Admin Faculty Index View
 */
?>

<div class="page-title-box">
  <div>
    <h1>Faculty & Academic Staff</h1>
    <p class="admin-text-muted-sm">Manage teaching faculty, qualifications, department assignments, and biographies.</p>
  </div>
  <a href="<?= url('/admin/faculty/create') ?>" class="btn btn-primary btn-sm">+ Add Faculty Member</a>
</div>

<div class="admin-card">
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th class="table-col-avatar">Photo</th>
          <th>Name & Designation</th>
          <th>Department</th>
          <th>Qualification</th>
          <th>Email</th>
          <th>Order</th>
          <th>Status</th>
          <th class="text-right">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($faculty as $member): ?>
        <tr>
          <td>
            <?php if (!empty($member['photo']) && file_exists(ROOT_PATH . '/public/' . ltrim($member['photo'], '/'))): ?>
              <img src="<?= asset($member['photo']) ?>" alt="<?= e($member['name']) ?>" width="40" height="40" class="table-avatar-img">
            <?php else: ?>
              <div class="table-avatar-placeholder">
                <?= strtoupper(substr($member['name'], 0, 1)) ?>
              </div>
            <?php endif; ?>
          </td>
          <td>
            <strong class="admin-cell-title"><?= e($member['name']) ?></strong>
            <span class="text-xs text-secondary font-semibold"><?= e($member['designation']) ?></span>
          </td>
          <td><?= e($departments[$member['department_id']] ?? 'General') ?></td>
          <td class="text-sm"><?= e($member['qualification']) ?></td>
          <td class="text-sm text-muted"><?= e($member['email'] ?: 'N/A') ?></td>
          <td><?= e($member['display_order']) ?></td>
          <td>
            <span class="badge badge-<?= (int)$member['is_active'] === 1 ? 'success' : 'danger' ?>">
              <?= (int)$member['is_active'] === 1 ? 'Active' : 'Inactive' ?>
            </span>
          </td>
          <td class="text-right">
            <div class="table-actions table-actions--right">
              <a href="<?= url('/admin/faculty/edit/' . $member['id']) ?>" class="btn btn-outline btn-icon">Edit</a>
              <form action="<?= url('/admin/faculty/delete/' . $member['id']) ?>" method="POST" class="js-delete-form d-inline">
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
