<?php
/**
 * Admin Audit Log View
 */
?>

<div class="page-title-box">
  <div>
    <h1>Admin Audit Trail</h1>
    <p class="admin-text-muted-sm">Immutable security log tracking administrator actions, updates, and logins.</p>
  </div>
</div>

<div class="admin-card">
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Timestamp</th>
          <th>Actor / User</th>
          <th>Action</th>
          <th>Target Object</th>
          <th>Details</th>
          <th>IP Address</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($logs)): ?>
          <tr>
            <td colspan="6" class="admin-table-empty-td">No audit events recorded yet.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($logs as $log): ?>
          <tr>
            <td class="text-sm text-muted nowrap">
              <?= format_date($log['created_at'], 'd M, Y - h:i A') ?>
            </td>
            <td>
              <strong class="text-primary text-sm font-bold"><?= e($log['user_email'] ?: 'System') ?></strong>
            </td>
            <td>
              <span class="badge badge-info"><?= strtoupper(e($log['action'])) ?></span>
            </td>
            <td>
              <span class="font-semibold text-sm"><?= e($log['object_type']) ?></span>
              <?php if (!empty($log['object_id'])): ?>
                <span class="admin-cell-subtitle d-inline">#<?= e($log['object_id']) ?></span>
              <?php endif; ?>
            </td>
            <td class="text-sm text-muted">
              <?= e($log['details']) ?>
            </td>
            <td class="text-xs font-mono text-muted">
              <?= e($log['ip_address'] ?: '127.0.0.1') ?>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
