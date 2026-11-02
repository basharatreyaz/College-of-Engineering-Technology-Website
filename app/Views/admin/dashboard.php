<?php
/**
 * Admin Dashboard View
 */
?>

<div class="page-title-box">
  <div>
    <h1>Institutional Dashboard</h1>
    <p class="admin-meta-text">
      Real-time overview of academic programmes, student submissions, and institutional notices.
    </p>
  </div>
  <div class="d-flex gap-2">
    <a href="<?= url('/admin/applications') ?>" class="btn btn-accent btn-sm">Review Applications</a>
    <a href="<?= url('/admin/notices/create') ?>" class="btn btn-primary btn-sm">+ Post New Notice</a>
  </div>
</div>

<!-- Dynamic Stat Metric Cards -->
<div class="admin-stats-grid">
  <div class="admin-stat-card">
    <div>
      <div class="admin-stat-number"><?= $stats['applications_total'] ?></div>
      <div class="admin-stat-label">Student Applications</div>
      <span class="text-accent font-bold text-xs">
        <?= $stats['applications_new'] ?> New / Pending
      </span>
    </div>
    <div class="admin-stat-icon"><i class="fa-solid fa-file-signature"></i></div>
  </div>

  <div class="admin-stat-card">
    <div>
      <div class="admin-stat-number"><?= $stats['enquiries_new'] ?></div>
      <div class="admin-stat-label">New Enquiries</div>
      <span class="text-secondary font-semibold text-xs">
        Requires Follow-up
      </span>
    </div>
    <div class="admin-stat-icon"><i class="fa-solid fa-envelope-open-text"></i></div>
  </div>

  <div class="admin-stat-card">
    <div>
      <div class="admin-stat-number"><?= $stats['programmes'] ?></div>
      <div class="admin-stat-label">Active Programmes</div>
      <span class="admin-meta-text text-xs">
        Across <?= $stats['departments'] ?> Departments
      </span>
    </div>
    <div class="admin-stat-icon"><i class="fa-solid fa-graduation-cap"></i></div>
  </div>

  <div class="admin-stat-card">
    <div>
      <div class="admin-stat-number"><?= $stats['faculty'] ?></div>
      <div class="admin-stat-label">Faculty &amp; Mentors</div>
      <span class="admin-meta-text text-xs">
        Active Directory
      </span>
    </div>
    <div class="admin-stat-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
  </div>
</div>

<!-- Split Tables Section -->
<div class="admin-split-tables">
  <!-- Recent Applications -->
  <div class="admin-card">
    <div class="admin-card-header">
      <h2 class="admin-card-title">Recent Admission Applications</h2>
      <a href="<?= url('/admin/applications') ?>" class="text-primary font-semibold text-sm no-underline">View All &rarr;</a>
    </div>
    <div class="table-responsive">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Ref Number</th>
            <th>Applicant</th>
            <th>Programme</th>
            <th>Status</th>
            <th class="text-right">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($recentApplications)): ?>
            <tr>
              <td colspan="5" class="admin-table-empty">No applications submitted yet.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($recentApplications as $app): ?>
            <tr>
              <td>
                <strong class="text-primary font-mono"><?= e($app['application_number']) ?></strong>
              </td>
              <td>
                <span class="font-semibold block"><?= e($app['first_name'] . ' ' . $app['last_name']) ?></span>
                <span class="admin-meta-text"><?= e($app['phone']) ?></span>
              </td>
              <td class="text-sm"><?= e($app['programme_name']) ?></td>
              <td>
                <span class="badge badge-<?= $app['status'] === 'new' ? 'warning' : ($app['status'] === 'accepted' ? 'success' : 'info') ?>">
                  <?= e($app['status']) ?>
                </span>
              </td>
              <td class="text-right">
                <a href="<?= url('/admin/applications/' . $app['id']) ?>" class="btn btn-outline btn-sm">Review</a>
              </td>
            </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Recent Enquiries -->
  <div class="admin-card">
    <div class="admin-card-header">
      <h2 class="admin-card-title">Latest Admission Enquiries</h2>
      <a href="<?= url('/admin/enquiries') ?>" class="text-primary font-semibold text-sm no-underline">View All &rarr;</a>
    </div>
    <div class="table-responsive">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Candidate</th>
            <th>Subject / Query</th>
            <th>Status</th>
            <th class="text-right">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($recentEnquiries)): ?>
            <tr>
              <td colspan="4" class="admin-table-empty">No enquiries recorded yet.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($recentEnquiries as $enq): ?>
            <tr>
              <td>
                <span class="font-semibold block"><?= e($enq['full_name']) ?></span>
                <span class="admin-meta-text"><?= e($enq['phone']) ?></span>
              </td>
              <td>
                <span class="text-primary font-semibold text-sm block"><?= e($enq['subject'] ?: 'General Enquiry') ?></span>
                <span class="admin-meta-text"><?= truncate($enq['message'], 60) ?></span>
              </td>
              <td>
                <span class="badge badge-<?= $enq['status'] === 'new' ? 'warning' : 'success' ?>">
                  <?= e($enq['status']) ?>
                </span>
              </td>
              <td class="text-right">
                <a href="<?= url('/admin/enquiries/' . $enq['id']) ?>" class="btn btn-outline btn-sm">View</a>
              </td>
            </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
