<?php
/**
 * Admin Applications Index View
 */
?>

<div class="page-title-box">
  <div>
    <h1>Student Admission Applications</h1>
    <p class="admin-text-muted-sm">Review and process online admission applications registered by candidates.</p>
  </div>
</div>

<!-- Search & Status Filter Bar -->
<div class="admin-filter-bar">
  <div class="flex-tabs">
    <a href="<?= url('/admin/applications') ?>" class="btn btn-sm <?= empty($selectedStatus) ? 'btn-primary' : 'btn-outline' ?>">All (<?= count($applications) ?>)</a>
    <a href="<?= url('/admin/applications?status=new') ?>" class="btn btn-sm <?= ($selectedStatus === 'new') ? 'btn-primary' : 'btn-outline' ?>">New</a>
    <a href="<?= url('/admin/applications?status=under_review') ?>" class="btn btn-sm <?= ($selectedStatus === 'under_review') ? 'btn-primary' : 'btn-outline' ?>">Under Review</a>
    <a href="<?= url('/admin/applications?status=accepted') ?>" class="btn btn-sm <?= ($selectedStatus === 'accepted') ? 'btn-primary' : 'btn-outline' ?>">Accepted</a>
    <a href="<?= url('/admin/applications?status=rejected') ?>" class="btn btn-sm <?= ($selectedStatus === 'rejected') ? 'btn-primary' : 'btn-outline' ?>">Rejected</a>
    <a href="<?= url('/admin/applications?status=closed') ?>" class="btn btn-sm <?= ($selectedStatus === 'closed') ? 'btn-primary' : 'btn-outline' ?>">Closed</a>
  </div>

  <form action="<?= url('/admin/applications') ?>" method="GET" class="admin-search-form">
    <input type="text" name="q" value="<?= e($searchQuery ?? '') ?>" class="form-control admin-search-input" placeholder="Ref # or candidate name...">
    <button type="submit" class="btn btn-primary btn-sm">Search</button>
    <?php if (!empty($searchQuery)): ?>
      <a href="<?= url('/admin/applications') ?>" class="btn btn-outline btn-sm">Clear</a>
    <?php endif; ?>
  </form>
</div>

<div class="admin-card">
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Reference Number</th>
          <th>Applicant Name</th>
          <th>Contact Info</th>
          <th>Programme Applied</th>
          <th>Prior Education & Marks</th>
          <th>Submitted</th>
          <th>Status</th>
          <th class="text-right">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($applications)): ?>
          <tr>
            <td colspan="8" class="admin-table-empty-td">No student applications found.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($applications as $app): ?>
          <tr>
            <td>
              <strong class="admin-cell-title font-mono"><?= e($app['application_number']) ?></strong>
            </td>
            <td>
              <strong class="d-block font-bold"><?= e($app['first_name'] . ' ' . $app['last_name']) ?></strong>
              <span class="admin-cell-subtitle">Guardian: <?= e($app['parent_name']) ?></span>
            </td>
            <td>
              <span class="d-block font-semibold text-sm"><?= e($app['phone']) ?></span>
              <span class="admin-cell-subtitle"><?= e($app['email']) ?></span>
            </td>
            <td>
              <span class="font-semibold text-sm text-primary"><?= e($app['programme_name']) ?></span>
            </td>
            <td>
              <span class="d-block text-sm"><?= truncate($app['prior_education'], 30) ?></span>
              <span class="font-bold text-secondary text-sm"><?= e($app['marks_percentage']) ?></span>
            </td>
            <td class="text-sm text-muted"><?= format_date($app['created_at']) ?></td>
            <td>
              <span class="badge badge-<?= $app['status'] === 'new' ? 'warning' : ($app['status'] === 'accepted' ? 'success' : ($app['status'] === 'rejected' ? 'danger' : 'info')) ?>">
                <?= e($app['status']) ?>
              </span>
            </td>
            <td class="text-right">
              <a href="<?= url('/admin/applications/' . $app['id']) ?>" class="btn btn-outline btn-icon">Review Profile</a>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
