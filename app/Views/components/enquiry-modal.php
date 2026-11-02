<?php
/**
 * Quick Admission Enquiry Modal Component
 */
$db = \App\Services\Database::getInstance();
$programmes = $db->query("SELECT id, name FROM programmes WHERE is_active = 1 ORDER BY display_order ASC");
?>

<div id="quickEnquiryModal" class="modal-backdrop" role="dialog" aria-modal="true" aria-labelledby="enquiryModalTitle" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-header">
      <h3 id="enquiryModalTitle" class="modal-title">Admission Enquiry</h3>
      <button type="button" class="modal-close" data-dismiss="enquiry-modal" onclick="closeQuickEnquiryModal()" aria-label="Close enquiry modal"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <form action="<?= url('/enquire') ?>" method="POST" class="js-enquiry-form">
      <?= csrf_field() ?>
      <input type="text" name="enquiry_hp" class="form-hp" tabindex="-1" autocomplete="off">
      <input type="hidden" name="source_page" value="<?= e($_SERVER['REQUEST_URI'] ?? 'modal') ?>">

      <div class="modal-body">
        <div class="js-form-feedback"></div>
        <p class="modal-intro-text">
          Have questions regarding B.Tech eligibility, admissions, or transport? Fill out this quick form and an admissions counsellor will connect with you.
        </p>

        <div class="form-group">
          <label class="form-label" for="eq_full_name">Full Name *</label>
          <input type="text" id="eq_full_name" name="full_name" class="form-control" required placeholder="e.g. Suhail Ahmad">
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label" for="eq_email">Email Address *</label>
            <input type="email" id="eq_email" name="email" class="form-control" required placeholder="suhail@example.com">
          </div>
          <div class="form-group">
            <label class="form-label" for="eq_phone">Phone / WhatsApp *</label>
            <input type="tel" id="eq_phone" name="phone" class="form-control" required placeholder="+91 9906X XXXXX">
          </div>
        </div>

        <div class="form-group">
          <label class="form-label" for="eq_programme">Programme of Interest</label>
          <select id="eq_programme" name="programme_id" class="form-control">
            <option value="">-- Select B.Tech Programme --</option>
            <?php foreach ($programmes as $p): ?>
              <option value="<?= $p['id'] ?>"><?= e($p['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label" for="eq_message">Your Query / Message (Optional)</label>
          <textarea id="eq_message" name="message" class="form-control" rows="3" placeholder="Tell us about your questions regarding branch preference, fee, or transport (optional)..."></textarea>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline btn-sm" data-dismiss="enquiry-modal" onclick="closeQuickEnquiryModal()">Cancel</button>
        <button type="submit" class="btn btn-accent btn-sm"><i class="fa-solid fa-paper-plane me-1"></i> Send Admission Enquiry</button>
      </div>
    </form>
  </div>
</div>
