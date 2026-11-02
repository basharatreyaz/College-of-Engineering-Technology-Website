<?php
/**
 * Admin Application Detail View
 */
?>

<div class="page-title-box">
  <div>
    <h1>Applicant Profile & Verification</h1>
    <p class="admin-meta-text">Application Ref: <strong class="font-mono text-primary"><?= e($application['application_number']) ?></strong></p>
  </div>
  <div class="d-flex gap-2">
    <button type="button" class="btn btn-outline btn-sm" onclick="window.print()">Print Dossier</button>
    <a href="<?= url('/admin/applications') ?>" class="btn btn-outline btn-sm">&larr; Back to Applications</a>
  </div>
</div>

<div class="admin-dossier-grid">
  <!-- Main Application Profile -->
  <div class="admin-card">
    <div class="admin-card-header">
      <h2 class="admin-card-title"><?= e($application['first_name'] . ' ' . $application['last_name']) ?></h2>
      <span class="badge badge-<?= $application['status'] === 'new' ? 'warning' : ($application['status'] === 'accepted' ? 'success' : 'info') ?>">
        Status: <?= e($application['status']) ?>
      </span>
    </div>
    <div class="admin-card-body">
      <!-- Section 1 -->
      <h3 class="admin-section-heading">
        1. Personal & Contact Profile
      </h3>
      <div class="admin-fields-grid">
        <div>
          <span class="admin-field-label">Full Name</span>
          <p class="admin-field-val"><?= e($application['first_name'] . ' ' . $application['last_name']) ?></p>
        </div>
        <div>
          <span class="admin-field-label">Email Address</span>
          <p class="admin-field-val"><a href="mailto:<?= e($application['email']) ?>"><?= e($application['email']) ?></a></p>
        </div>
        <div>
          <span class="admin-field-label">Contact Phone</span>
          <p class="admin-field-val"><a href="tel:<?= preg_replace('/\s+/', '', $application['phone']) ?>"><?= e($application['phone']) ?></a></p>
        </div>
        <div>
          <span class="admin-field-label">WhatsApp Number</span>
          <p class="admin-field-val"><?= e($application['whatsapp_number'] ?: 'Same as phone') ?></p>
        </div>
        <div>
          <span class="admin-field-label">Date of Birth</span>
          <p class="admin-field-val"><?= !empty($application['dob']) ? format_date($application['dob']) : 'Not provided' ?></p>
        </div>
        <div>
          <span class="admin-field-label">Gender</span>
          <p class="admin-field-val"><?= e($application['gender'] ?: 'Not specified') ?></p>
        </div>
      </div>

      <!-- Section 2 -->
      <h3 class="admin-section-heading">
        2. Programme & Guardian Details
      </h3>
      <div class="admin-fields-grid">
        <div>
          <span class="admin-field-label">Programme Applied</span>
          <p class="admin-field-val text-primary"><?= e($application['programme_name']) ?></p>
        </div>
        <div>
          <span class="admin-field-label">Parent / Guardian Name</span>
          <p class="admin-field-val"><?= e($application['parent_name']) ?></p>
        </div>
        <div>
          <span class="admin-field-label">City / District</span>
          <p class="admin-field-val"><?= e($application['city']) ?>, <?= e($application['state']) ?></p>
        </div>
        <div>
          <span class="admin-field-label">Pincode</span>
          <p class="admin-field-val"><?= e($application['pincode']) ?></p>
        </div>
        <div class="col-span-full">
          <span class="admin-field-label">Permanent Address</span>
          <p class="admin-field-val"><?= nl2br(e($application['address'])) ?></p>
        </div>
      </div>

      <!-- Section 3 -->
      <h3 class="admin-section-heading">
        3. Prior Academic Record
      </h3>
      <div class="admin-fields-grid mb-2">
        <div class="col-span-full">
          <span class="admin-field-label">Prior School / Board / Institute</span>
          <p class="admin-field-val"><?= e($application['prior_education']) ?></p>
        </div>
        <div>
          <span class="admin-field-label">Marks Percentage (%)</span>
          <p class="admin-field-val text-secondary text-lg"><?= e($application['marks_percentage']) ?></p>
        </div>
        <div>
          <span class="admin-field-label">Current Status</span>
          <p class="admin-field-val"><?= e($application['current_status'] ?: 'Submitted online') ?></p>
        </div>
      </div>
    </div>
  </div>

  <!-- Status Transition & Audit History -->
  <div>
    <!-- Status Update Form -->
    <div class="admin-card mb-4">
      <div class="admin-card-header">
        <h3 class="admin-card-title text-base">Admissions Action</h3>
      </div>
      <div class="admin-card-body">
        <form action="<?= url('/admin/applications/' . $application['id']) ?>" method="POST">
          <?= csrf_field() ?>

          <div class="form-group">
            <label class="form-label" for="app_status">Application Status *</label>
            <select id="app_status" name="status" class="form-control" required>
              <option value="new" <?= $application['status'] === 'new' ? 'selected' : '' ?>>New / Pending Review</option>
              <option value="under_review" <?= $application['status'] === 'under_review' ? 'selected' : '' ?>>Under Review / Documents Awaited</option>
              <option value="accepted" <?= $application['status'] === 'accepted' ? 'selected' : '' ?>>Accepted / Verified for Admission</option>
              <option value="rejected" <?= $application['status'] === 'rejected' ? 'selected' : '' ?>>Rejected / Ineligible</option>
              <option value="closed" <?= $application['status'] === 'closed' ? 'selected' : '' ?>>Closed / Archived</option>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label" for="remarks">Staff Remarks / Verification Note</label>
            <textarea id="remarks" name="remarks" class="form-control" rows="3" placeholder="Notes on certificate verification, provisional allotment..."><?= e($application['notes'] ?? '') ?></textarea>
          </div>

          <button type="submit" class="btn btn-primary w-full">Record Status Change</button>
        </form>
      </div>
    </div>

    <!-- Status History Trail -->
    <div class="admin-card">
      <div class="admin-card-header">
        <h3 class="admin-card-title text-base">Status History</h3>
      </div>
      <div class="admin-card-body">
        <?php if (empty($history)): ?>
          <p class="admin-meta-text">No status updates recorded yet.</p>
        <?php else: ?>
          <ul class="admin-timeline-list">
            <?php foreach ($history as $h): ?>
            <li class="admin-timeline-item">
              <span class="badge badge-info text-xs"><?= e($h['status']) ?></span>
              <span class="admin-meta-text block mt-1">
                <?= format_date($h['created_at'], 'd M, Y - h:i A') ?>
              </span>
              <?php if (!empty($h['remarks'])): ?>
                <p class="text-sm text-dark mt-1 mb-0"><?= e($h['remarks']) ?></p>
              <?php endif; ?>
            </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
