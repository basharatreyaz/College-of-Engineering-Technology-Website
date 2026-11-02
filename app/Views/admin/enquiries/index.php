<?php
/**
 * Admin Enquiries Index View
 */
?>

<div class="page-title-box">
  <div>
    <h1>Admission & Contact Enquiries</h1>
    <p class="admin-text-muted-sm">Review incoming enquiries from prospective students and manage counsellor follow-ups.</p>
  </div>
</div>

<!-- Status Filter Tabs -->
<div class="admin-filter-tabs">
  <a href="<?= url('/admin/enquiries') ?>" class="btn btn-sm <?= empty($selectedStatus) ? 'btn-primary' : 'btn-outline' ?>">All Enquiries</a>
  <a href="<?= url('/admin/enquiries?status=new') ?>" class="btn btn-sm <?= ($selectedStatus === 'new') ? 'btn-primary' : 'btn-outline' ?>">New / Uncontacted</a>
  <a href="<?= url('/admin/enquiries?status=contacted') ?>" class="btn btn-sm <?= ($selectedStatus === 'contacted') ? 'btn-primary' : 'btn-outline' ?>">Contacted</a>
  <a href="<?= url('/admin/enquiries?status=under_review') ?>" class="btn btn-sm <?= ($selectedStatus === 'under_review') ? 'btn-primary' : 'btn-outline' ?>">Under Review</a>
  <a href="<?= url('/admin/enquiries?status=closed') ?>" class="btn btn-sm <?= ($selectedStatus === 'closed') ? 'btn-primary' : 'btn-outline' ?>">Closed</a>
</div>

<div class="admin-card">
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Candidate</th>
          <th>Contact Info</th>
          <th>Branch Interested</th>
          <th>Subject / Message</th>
          <th>Received</th>
          <th>Status</th>
          <th class="text-right">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($enquiries)): ?>
          <tr>
            <td colspan="7" class="admin-table-empty-td">No enquiries found in this category.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($enquiries as $enq): ?>
          <tr>
            <td>
              <strong class="admin-cell-title"><?= e($enq['full_name']) ?></strong>
              <span class="admin-cell-subtitle">Src: <?= e($enq['source_page']) ?></span>
            </td>
            <td>
              <a href="tel:<?= preg_replace('/\s+/', '', $enq['phone']) ?>" class="d-block font-semibold text-sm text-primary"><?= e($enq['phone']) ?></a>
              <a href="mailto:<?= e($enq['email']) ?>" class="admin-cell-subtitle"><?= e($enq['email']) ?></a>
            </td>
            <td class="text-sm"><?= e($enq['programme_name'] ?: 'General Inquiry') ?></td>
            <td>
              <span class="d-block font-semibold text-sm"><?= e($enq['subject'] ?: 'Admissions Query') ?></span>
              <span class="admin-cell-subtitle"><?= truncate($enq['message'], 65) ?></span>
            </td>
            <td class="text-sm text-muted"><?= format_date($enq['created_at']) ?></td>
            <td>
              <span class="badge badge-<?= $enq['status'] === 'new' ? 'warning' : ($enq['status'] === 'contacted' ? 'info' : ($enq['status'] === 'closed' ? 'muted' : 'success')) ?>">
                <?= e($enq['status']) ?>
              </span>
            </td>
            <td class="text-right">
              <div class="table-actions table-actions--right">
                <a href="<?= url('/admin/enquiries/' . $enq['id']) ?>" class="btn btn-outline btn-icon">Manage</a>
                <form action="<?= url('/admin/enquiries/delete/' . $enq['id']) ?>" method="POST" class="js-delete-form d-inline">
                  <?= csrf_field() ?>
                  <button type="submit" class="btn btn-outline btn-icon btn-delete">Delete</button>
                </form>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
