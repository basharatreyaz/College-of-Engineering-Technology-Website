<?php
/**
 * Admin User Form (Create / Edit)
 */
$isEdit = !empty($user);
$action = $isEdit ? url('/admin/users/edit/' . $user['id']) : url('/admin/users');
?>

<div class="page-title-box">
  <div>
    <h1><?= $isEdit ? 'Edit User Account' : 'Create Admin User' ?></h1>
    <p class="admin-text-muted-sm">Configure credentials and role permissions for staff members.</p>
  </div>
  <a href="<?= url('/admin/users') ?>" class="btn btn-outline btn-sm">&larr; Back to Users</a>
</div>

<div class="admin-card">
  <div class="admin-card-body">
    <form action="<?= $action ?>" method="POST">
      <?= csrf_field() ?>

      <div class="form-row">
        <div class="form-group form-group--1">
          <label class="form-label" for="user_name">Full Name *</label>
          <input type="text" id="user_name" name="name" value="<?= e($user['name'] ?? '') ?>" class="form-control" required placeholder="e.g. Er. Farooq Ahmad">
        </div>

        <div class="form-group form-group--1">
          <label class="form-label" for="user_email">Email Address *</label>
          <input type="email" id="user_email" name="email" value="<?= e($user['email'] ?? '') ?>" class="form-control" required placeholder="user@kcet.edu.in">
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="user_role">Role Permissions *</label>
          <select id="user_role" name="role" class="form-control" required>
            <option value="editor" <?= (($user['role'] ?? '') === 'editor') ? 'selected' : '' ?>>Content Editor (Notices, Events, Facilities, FAQs)</option>
            <option value="admissions" <?= (($user['role'] ?? '') === 'admissions') ? 'selected' : '' ?>>Admissions Staff (Review Applications & Enquiries)</option>
            <option value="superadmin" <?= (($user['role'] ?? '') === 'superadmin') ? 'selected' : '' ?>>Super Administrator (Full System Control & Settings)</option>
          </select>
        </div>

        <?php if ($isEdit): ?>
        <div class="form-group">
          <label class="form-label" for="user_status">Account Status</label>
          <select id="user_status" name="status" class="form-control">
            <option value="active" <?= (($user['status'] ?? '') === 'active') ? 'selected' : '' ?>>Active</option>
            <option value="inactive" <?= (($user['status'] ?? '') === 'inactive') ? 'selected' : '' ?>>Disabled / Inactive</option>
          </select>
        </div>
        <?php endif; ?>
      </div>

      <div class="form-group">
        <label class="form-label" for="password">Password <?= $isEdit ? '(Leave blank to keep unchanged)' : '*' ?></label>
        <input type="password" id="password" name="password" class="form-control" <?= $isEdit ? '' : 'required' ?> placeholder="••••••••••••">
      </div>

      <div class="form-actions mt-5">
        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Save Changes' : 'Create User' ?></button>
        <a href="<?= url('/admin/users') ?>" class="btn btn-outline">Cancel</a>
      </div>
    </form>
  </div>
</div>
