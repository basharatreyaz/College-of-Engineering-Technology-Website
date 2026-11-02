<?php
/**
 * Dismissible Admission Announcement Modal Component
 */
$enabled = setting('admission_modal_enabled', '1');
if ($enabled !== '1') {
  return;
}

$title = setting('admission_modal_title', 'Admissions Open for Session 2026-27');
$body = setting('admission_modal_body', 'Applications are actively invited for 4-Year B.Tech and 3-Year Lateral Entry programmes in Artificial Intelligence, Computer Engineering, Civil, IT, and ECE at Kashmir College of Engineering & Technology (KCET), Srinagar.');
?>

<div id="admissionAnnouncementModal" class="modal-backdrop" role="dialog" aria-modal="true" aria-labelledby="admissionModalTitle" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-header">
      <div class="d-flex align-items-center gap-2">
        <span class="modal-notice-badge">NOTICE</span>
        <h3 id="admissionModalTitle" class="modal-title"><?= e($title) ?></h3>
      </div>
      <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close modal"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div class="modal-body">
      <p class="mb-3"><?= nl2br(e($body)) ?></p>
      
      <div class="modal-highlight-box">
        <ul class="d-flex flex-col gap-2 p-0 m-0 list-none text-sm text-dark">
          <li><i class="fa-solid fa-circle-check text-secondary me-2"></i> 4-Year B.Tech in 5 Contemporary Branches</li>
          <li><i class="fa-solid fa-circle-check text-secondary me-2"></i> Direct 3rd Semester Admission for Diploma / B.Sc (Lateral Entry)</li>
          <li><i class="fa-solid fa-circle-check text-secondary me-2"></i> Merit-based scholarships available for eligible applicants</li>
          <li><i class="fa-solid fa-circle-check text-secondary me-2"></i> Campus transport available across major regional routes</li>
        </ul>
      </div>

      <p class="text-muted text-xs m-0">
        Admissions Office: Ranbirgarh, Srinagar | Phone: +91 88994 12793
      </p>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-outline btn-sm" data-dismiss="modal">Close &amp; Browse Site</button>
      <a href="<?= url('/apply') ?>" class="btn btn-accent btn-sm">
        Proceed to Online Application <i class="fa-solid fa-arrow-right ms-1"></i>
      </a>
    </div>
  </div>
</div>
