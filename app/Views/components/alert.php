<?php
/**
 * Flash Alert Component
 */
$flashes = flash();
if (!empty($flashes) && is_array($flashes)):
?>
  <div class="container flash-alerts-container">
    <?php foreach ($flashes as $type => $message):
      $alertClass = match($type) {
        'success' => 'alert-success',
        'error', 'danger' => 'alert-danger',
        'warning' => 'alert-warning',
        default => 'alert-info'
      };
      $alertIcon = match($type) {
        'success' => 'fa-circle-check',
        'error', 'danger' => 'fa-circle-exclamation',
        'warning' => 'fa-triangle-exclamation',
        default => 'fa-circle-info'
      };
    ?>
      <div class="alert <?= $alertClass ?> alert-flex" role="alert">
        <i class="fa-solid <?= $alertIcon ?> alert-icon"></i>
        <div><?= $message ?></div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
