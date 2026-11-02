<?php
/**
 * Admin Site Settings View
 */
?>

<div class="page-title-box">
  <div>
    <h1>Site Configuration & Institutional Settings</h1>
    <p class="admin-text-muted-sm">Update campus contact numbers, emails, addresses, homepage hero headlines, and announcement tickers.</p>
  </div>
</div>

<form action="<?= url('/admin/settings') ?>" method="POST">
  <?= csrf_field() ?>

  <?php foreach ($settingsGrouped as $groupName => $items): ?>
  <div class="admin-card">
    <div class="admin-card-header">
      <h2 class="admin-card-title text-capitalize">
        <?= e($groupName) ?> Configuration
      </h2>
    </div>
    <div class="admin-card-body">
      <div class="admin-settings-grid">
        <?php foreach ($items as $s): ?>
        <div class="form-group <?= ($s['setting_type'] === 'textarea' || strlen($s['setting_value'] ?? '') > 60) ? 'grid-col-full' : '' ?>">
          <label class="form-label" for="setting_<?= e($s['setting_key']) ?>">
            <?= e($s['setting_label']) ?>
            <code class="admin-setting-key">[<?= e($s['setting_key']) ?>]</code>
          </label>

          <?php if ($s['setting_type'] === 'textarea'): ?>
            <textarea id="setting_<?= e($s['setting_key']) ?>" name="settings[<?= e($s['setting_key']) ?>]" class="form-control" rows="3"><?= e($s['setting_value'] ?? '') ?></textarea>
          <?php elseif ($s['setting_type'] === 'email'): ?>
            <input type="email" id="setting_<?= e($s['setting_key']) ?>" name="settings[<?= e($s['setting_key']) ?>]" value="<?= e($s['setting_value'] ?? '') ?>" class="form-control">
          <?php elseif ($s['setting_type'] === 'url'): ?>
            <input type="url" id="setting_<?= e($s['setting_key']) ?>" name="settings[<?= e($s['setting_key']) ?>]" value="<?= e($s['setting_value'] ?? '') ?>" class="form-control">
          <?php else: ?>
            <input type="text" id="setting_<?= e($s['setting_key']) ?>" name="settings[<?= e($s['setting_key']) ?>]" value="<?= e($s['setting_value'] ?? '') ?>" class="form-control">
          <?php endif; ?>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
  <?php endforeach; ?>

  <div class="admin-sticky-bar">
    <span class="text-sm text-muted">Settings take effect immediately across all public pages.</span>
    <button type="submit" class="btn btn-primary btn-lg">Save All Settings</button>
  </div>
</form>
