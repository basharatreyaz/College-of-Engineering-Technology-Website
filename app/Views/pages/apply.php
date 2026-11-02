<?php
/**
 * Application / Registration Form View
 */
?>

<!-- Header -->
<div class="page-hero" style="background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);">
  <div class="container page-hero-inner">
    <span class="page-hero-badge">
      Online Registration
    </span>
    <h1 class="page-hero-title">B.Tech Admission Application 2026-27</h1>
    <p class="page-hero-desc">
      Please complete the applicant details below. A unique application reference number will be generated upon submission for verification and counselling.
    </p>
  </div>
</div>

<section class="section">
  <div class="container max-w-4xl">
    <div id="appFormFeedback"></div>

    <form id="admissionsApplicationForm" action="<?= url('/apply') ?>" method="POST" class="apply-form-card">
      <?= csrf_field() ?>
      <input type="text" name="website_hp" class="form-hp" tabindex="-1" autocomplete="off">

      <!-- Section 1: Candidate Personal Details -->
      <div class="mb-5">
        <h2 class="apply-section-heading">
          1. Candidate Information
        </h2>

        <div class="form-row">
          <div class="form-group flex-1">
            <label class="form-label" for="first_name">First Name *</label>
            <input type="text" id="first_name" name="first_name" value="<?= e(old('first_name')) ?>" class="form-control" required placeholder="e.g. Suhail">
          </div>
          <div class="form-group flex-1">
            <label class="form-label" for="last_name">Last Name *</label>
            <input type="text" id="last_name" name="last_name" value="<?= e(old('last_name')) ?>" class="form-control" required placeholder="e.g. Ahmad">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group flex-1">
            <label class="form-label" for="email">Email Address *</label>
            <input type="email" id="email" name="email" value="<?= e(old('email')) ?>" class="form-control" required placeholder="suhail@example.com">
            <span class="form-helper">Official confirmation and reference number will be sent here.</span>
          </div>
          <div class="form-group flex-1">
            <label class="form-label" for="phone">Phone Number (10 Digits) *</label>
            <input type="tel" id="phone" name="phone" value="<?= e(old('phone')) ?>" class="form-control" required placeholder="9906123456" pattern="[0-9+ -]{10,15}">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group flex-1">
            <label class="form-label" for="whatsapp_number">WhatsApp Number (Optional)</label>
            <input type="tel" id="whatsapp_number" name="whatsapp_number" value="<?= e(old('whatsapp_number')) ?>" class="form-control" placeholder="Leave blank if same as phone">
          </div>
          <div class="form-group flex-1">
            <label class="form-label" for="dob">Date of Birth</label>
            <input type="date" id="dob" name="dob" value="<?= e(old('dob')) ?>" class="form-control">
          </div>
          <div class="form-group flex-1">
            <label class="form-label" for="gender">Gender</label>
            <select id="gender" name="gender" class="form-control">
              <option value="Male" <?= old('gender') === 'Male' ? 'selected' : '' ?>>Male</option>
              <option value="Female" <?= old('gender') === 'Female' ? 'selected' : '' ?>>Female</option>
              <option value="Other" <?= old('gender') === 'Other' ? 'selected' : '' ?>>Other</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Section 2: Programme Selection -->
      <div class="mb-5">
        <h2 class="apply-section-heading">
          2. Programme Preference
        </h2>

        <div class="form-group">
          <label class="form-label" for="programme_id">Select Engineering Programme *</label>
          <?php
            $reqBranch = strtolower(trim((string)($_GET['branch'] ?? $_GET['programme_id'] ?? $_GET['prog'] ?? '')));
            $selectedProgId = (int)old('programme_id', 0);
          ?>
          <select id="programme_id" name="programme_id" class="form-control" required>
            <option value="">-- Choose B.Tech Branch --</option>
            <?php foreach ($programmes as $p): ?>
              <?php
                $isMatch = ($selectedProgId > 0 && (int)$p['id'] === $selectedProgId) ||
                           ($selectedProgId === 0 && !empty($reqBranch) && (str_contains(strtolower($p['slug']), $reqBranch) || str_contains(strtolower($p['name']), $reqBranch) || (string)$p['id'] === $reqBranch));
              ?>
              <option value="<?= $p['id'] ?>" <?= $isMatch ? 'selected' : '' ?>>
                <?= e($p['name']) ?> (<?= e($p['duration']) ?>)
              </option>
            <?php endforeach; ?>
          </select>
          <span class="form-helper">Both 4-Year B.Tech and Lateral Entry (3rd Semester) applicants apply under their preferred branch.</span>
        </div>
      </div>

      <!-- Section 3: Family & Residence -->
      <div class="mb-5">
        <h2 class="apply-section-heading">
          3. Parent / Guardian & Address
        </h2>

        <div class="form-group">
          <label class="form-label" for="parent_name">Parent / Guardian Name *</label>
          <input type="text" id="parent_name" name="parent_name" value="<?= e(old('parent_name')) ?>" class="form-control" required placeholder="Full name of Father / Mother / Guardian">
        </div>

        <div class="form-group">
          <label class="form-label" for="address">Permanent Street Address *</label>
          <textarea id="address" name="address" class="form-control" rows="2" required placeholder="House No, Village / Mohalla, Landmark"><?= e(old('address')) ?></textarea>
        </div>

        <div class="form-row">
          <div class="form-group flex-1">
            <label class="form-label" for="city">City / District *</label>
            <input type="text" id="city" name="city" value="<?= e(old('city')) ?>" class="form-control" required placeholder="e.g. Srinagar, Budgam, Baramulla">
          </div>
          <div class="form-group flex-1">
            <label class="form-label" for="state">State / UT *</label>
            <input type="text" id="state" name="state" value="<?= e(old('state', 'Jammu and Kashmir')) ?>" class="form-control" required>
          </div>
          <div class="form-group flex-1">
            <label class="form-label" for="pincode">Postal Pincode *</label>
            <input type="text" id="pincode" name="pincode" value="<?= e(old('pincode')) ?>" class="form-control" required placeholder="190001">
          </div>
        </div>
      </div>

      <!-- Section 4: Academic Background -->
      <div class="mb-5">
        <h2 class="apply-section-heading">
          4. Academic Qualifications
        </h2>

        <div class="form-row">
          <div class="form-group flex-2">
            <label class="form-label" for="prior_education">Prior Education / School / Board *</label>
            <input type="text" id="prior_education" name="prior_education" value="<?= e(old('prior_education')) ?>" class="form-control" required placeholder="e.g. 10+2 Non-Medical (JKBOSE / CBSE) or 3-Yr Diploma in CSE">
          </div>
          <div class="form-group flex-1">
            <label class="form-label" for="marks_percentage">Marks Percentage (%) *</label>
            <input type="text" id="marks_percentage" name="marks_percentage" value="<?= e(old('marks_percentage')) ?>" class="form-control" required placeholder="e.g. 82.4%">
          </div>
        </div>

        <div class="form-group">
          <label class="form-label" for="current_status">Current Status (Optional)</label>
          <input type="text" id="current_status" name="current_status" value="<?= e(old('current_status')) ?>" class="form-control" placeholder="e.g. Passed in 2026 / Appearing in final term exam">
        </div>
      </div>

      <!-- Consent & Declaration -->
      <div class="apply-declaration-box">
        <label class="d-flex align-items-start gap-2 cursor-pointer">
          <input type="checkbox" name="consent" value="1" required class="mt-1">
          <span class="text-sm text-dark leading-relaxed">
            I hereby declare that all particulars entered above are true, complete, and verifiable against official certificates. I understand that online registration generates an application for counselling and does not constitute guaranteed final admission until document verification and fee clearance are completed.
          </span>
        </label>
      </div>

      <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <span class="text-muted text-xs">
          * Required fields. Your data is processed securely under institutional policy.
        </span>
        <button type="submit" class="btn btn-accent btn-lg">Submit Application &rarr;</button>
      </div>
    </form>
  </div>
</section>
