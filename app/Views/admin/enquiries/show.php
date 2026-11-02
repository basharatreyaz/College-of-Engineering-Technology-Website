<?php
/**
 * Admin Enquiry Detail View
 */
?>

<div class="page-title-box">
  <div>
    <h1>Enquiry Details</h1>
    <p class="admin-text-muted-sm">Review inquiry content, candidate phone, and record counselling status.</p>
  </div>
  <a href="<?= url('/admin/enquiries') ?>" class="btn btn-outline btn-sm">&larr; Back to Enquiries</a>
</div>

<div class="admin-dossier-grid">
  <!-- Details Col -->
  <div class="admin-card">
    <div class="admin-card-header">
      <h2 class="admin-card-title">Enquiry #<?= e($enquiry['id']) ?> from <?= e($enquiry['full_name']) ?></h2>
      <span class="badge badge-<?= $enquiry['status'] === 'new' ? 'warning' : 'success' ?>"><?= e($enquiry['status']) ?></span>
    </div>
    <div class="admin-card-body">
      <div class="admin-details-grid">
        <div>
          <span class="admin-field-label">Candidate Name</span>
          <p class="admin-field-val text-primary"><?= e($enquiry['full_name']) ?></p>
        </div>
        <div>
          <span class="admin-field-label">Submission Date</span>
          <p class="admin-field-val"><?= format_date($enquiry['created_at'], 'd M, Y - h:i A') ?></p>
        </div>
        <div>
          <span class="admin-field-label">Contact Phone</span>
          <p class="admin-field-val">
            <a href="tel:<?= preg_replace('/\s+/', '', $enquiry['phone']) ?>" class="text-primary"><?= e($enquiry['phone']) ?></a>
          </p>
        </div>
        <div>
          <span class="admin-field-label">Email Address</span>
          <p class="admin-field-val">
            <a href="mailto:<?= e($enquiry['email']) ?>"><?= e($enquiry['email']) ?></a>
          </p>
        </div>
      </div>

      <div class="form-group">
        <span class="admin-field-label">Subject</span>
        <p class="admin-field-val text-primary font-bold"><?= e($enquiry['subject'] ?: 'General Inquiry') ?></p>
      </div>

      <div>
        <span class="admin-field-label">Candidate Message</span>
        <div class="admin-message-box">
          <?= nl2br(e($enquiry['message'])) ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Status & Notes Col -->
  <div class="admin-card">
    <div class="admin-card-header">
      <h3 class="admin-card-title admin-card-title-sm">Admissions Follow-Up</h3>
    </div>
    <div class="admin-card-body">
      <form action="<?= url('/admin/enquiries/' . $enquiry['id']) ?>" method="POST">
        <?= csrf_field() ?>

        <div class="form-group">
          <label class="form-label" for="enq_status">Status</label>
          <select id="enq_status" name="status" class="form-control">
            <option value="new" <?= $enquiry['status'] === 'new' ? 'selected' : '' ?>>New / Uncontacted</option>
            <option value="contacted" <?= $enquiry['status'] === 'contacted' ? 'selected' : '' ?>>Contacted via Phone</option>
            <option value="under_review" <?= $enquiry['status'] === 'under_review' ? 'selected' : '' ?>>Under Review / Campus Visit Scheduled</option>
            <option value="closed" <?= $enquiry['status'] === 'closed' ? 'selected' : '' ?>>Closed / Resolved</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label" for="internal_notes">Internal Counsellor Notes</label>
          <textarea id="internal_notes" name="internal_notes" class="form-control" rows="4" placeholder="Record date contacted, applicant intent, scheduled campus visits..."><?= e($enquiry['internal_notes'] ?? '') ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100">Update Status & Notes</button>
      </form>
    </div>
  </div>
</div>
