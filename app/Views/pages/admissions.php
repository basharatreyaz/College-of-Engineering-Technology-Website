<?php
/**
 * Admissions Guide View
 */
?>

<!-- Header -->
<div class="page-hero" style="background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);">
  <div class="container page-hero-inner">
    <span class="page-hero-badge">
      Join KCET Batch 2026-27
    </span>
    <h1 class="page-hero-title">Admission Guide & Procedures</h1>
    <p class="page-hero-desc">
      Everything you need to know about applying for 4-Year B.Tech and 3-Year Lateral Entry engineering degrees at KCET Srinagar.
    </p>
  </div>
</div>

<section class="section">
  <div class="container">
    <!-- Step-by-Step Procedure -->
    <div id="procedure" class="mb-5">
      <div class="section-header">
        <span class="section-badge">How to Apply</span>
        <h2 class="section-title">Admission Process in 4 Simple Steps</h2>
        <p class="section-subtitle">A straightforward, transparent pathway to securing your engineering admission.</p>
      </div>

      <div class="admissions-steps-grid">
        <div class="admission-step-card">
          <span class="admission-step-num admission-step-num--1">1</span>
          <h3 class="admission-step-title">Online Registration</h3>
          <p class="admission-step-body">
            Fill out the digital admission form with your personal, contact, and prior 10+2 / diploma academic details.
          </p>
        </div>

        <div class="admission-step-card">
          <span class="admission-step-num admission-step-num--2">2</span>
          <h3 class="admission-step-title">Receive Reference ID</h3>
          <p class="admission-step-body">
            Upon submission, receive a unique KCET reference number (e.g. <code>KCET-2026-XXXX</code>) via on-screen receipt and email.
          </p>
        </div>

        <div class="admission-step-card">
          <span class="admission-step-num admission-step-num--3">3</span>
          <h3 class="admission-step-title">Document Verification</h3>
          <p class="admission-step-body">
            Visit the campus counselling desk or verify original 10+2 marks card, provisional certificates, and identity credentials.
          </p>
        </div>

        <div class="admission-step-card">
          <span class="admission-step-num admission-step-num--4">4</span>
          <h3 class="admission-step-title">Seat Allotment</h3>
          <p class="admission-step-body">
            Complete semester enrollment dues, select your desired engineering branch, and receive your official college roll number.
          </p>
        </div>
      </div>
    </div>

    <!-- Eligibility & Required Documents -->
    <div id="eligibility" class="admissions-docs-grid">
      <div class="admissions-docs-card">
        <h3 class="admissions-docs-title">Eligibility Guidelines</h3>
        <ul class="admissions-docs-list">
          <li><strong>4-Year B.Tech (Regular):</strong> Passed 10+2 examination with Physics and Mathematics as compulsory subjects alongside Chemistry, Computer Science, or Electronics, securing at least 45% marks (40% for reserved category).</li>
          <li><strong>3-Year B.Tech (Lateral Entry):</strong> Passed 3-Year recognized Engineering Diploma in relevant discipline or B.Sc with Mathematics, securing minimum 45% marks (40% for reserved category).</li>
          <li><strong>Age Criteria:</strong> As per University of Kashmir / State higher education council regulations.</li>
        </ul>
      </div>

      <div class="admissions-docs-card">
        <h3 class="admissions-docs-title">Documents Required at Verification</h3>
        <ul class="admissions-docs-list">
          <li>Original 10+2 Marks Card and Passing Certificate</li>
          <li>10th (Matriculation) Certificate for Date of Birth verification</li>
          <li>Provisional / Character Certificate from previous institution</li>
          <li>Domicile Certificate (for J&K resident applicants)</li>
          <li>Diploma Marksheet & Certificate (for Lateral Entry applicants)</li>
          <li>Recent passport-size colour photographs (6 copies)</li>
          <li>Category Certificate (if claiming reservation quota)</li>
        </ul>
      </div>
    </div>

    <!-- Interactive Eligibility & Merit Scholarship Estimator -->
    <div id="calculator" class="estimator-card">
      <div class="estimator-header">
        <div>
          <span class="section-badge text-accent"><i class="fa-solid fa-calculator me-1"></i> Instant Self-Assessment Tool</span>
          <h2 class="text-primary font-bold text-2xl my-1">B.Tech Eligibility &amp; Merit Scholarship Estimator</h2>
          <p class="text-muted text-sm m-0">
            Check your admission qualification criteria and calculate estimated merit scholarship tiers for the 2026-27 academic session.
          </p>
        </div>
        <span class="estimator-session-badge">
          Session 2026-27
        </span>
      </div>

      <div class="estimator-form-grid">
        <div class="form-group m-0">
          <label class="form-label" for="calc_mode">Admission Pathway</label>
          <select id="calc_mode" class="form-control" onchange="calculateAdmission()">
            <option value="regular">4-Year B.Tech (After 10+2 / Higher Secondary)</option>
            <option value="lateral">3-Year B.Tech Lateral Entry (Direct 3rd Sem for Diploma)</option>
          </select>
        </div>

        <div class="form-group m-0">
          <label class="form-label" for="calc_percentage">Aggregate / PCM Percentage (%)</label>
          <input type="number" id="calc_percentage" class="form-control" min="35" max="100" step="0.1" value="78.5" oninput="calculateAdmission()" placeholder="e.g. 78.5">
        </div>

        <div class="form-group m-0">
          <label class="form-label" for="calc_category">Applicant Category</label>
          <select id="calc_category" class="form-control" onchange="calculateAdmission()">
            <option value="general">Open Merit / General Category (Min. 45%)</option>
            <option value="reserved">Reserved (RBA / SC / ST / OBC / EWS - Min. 40%)</option>
          </select>
        </div>

        <div class="form-group m-0">
          <label class="form-label" for="calc_branch">Preferred Discipline</label>
          <select id="calc_branch" class="form-control" onchange="calculateAdmission()">
            <option value="AI">B.Tech Artificial Intelligence (Intake: 60)</option>
            <option value="CSE" selected>B.Tech Computer Engineering (Intake: 60)</option>
            <option value="Civil">B.Tech Civil Engineering (Intake: 60)</option>
            <option value="IT">B.Tech Information Technology (Intake: 60)</option>
            <option value="ECE">B.Tech Electronics &amp; Communication (Intake: 60)</option>
          </select>
        </div>
      </div>

      <!-- Result Card -->
      <div id="calc_result" class="estimator-result-card">
        <div class="estimator-result-flex">
          <div>
            <div class="d-flex align-items-center gap-2 mb-1">
              <span id="calc_status_badge" class="badge badge-success py-1 px-3 text-sm">ELIGIBLE FOR ADMISSION</span>
              <span id="calc_path_label" class="text-primary font-bold text-sm">4-Year B.Tech Degree</span>
            </div>
            <div id="calc_message" class="text-dark font-semibold text-sm">
              Your 78.5% score qualifies you for direct admission counselling under Open Merit.
            </div>
            <div id="calc_scholarship" class="font-bold text-sm mt-1 scholarship-notice">
              <i class="fa-solid fa-gift me-1"></i> Merit Achiever Tier: Eligible for 15% Tuition Fee Concession!
            </div>
          </div>
          <div>
            <a href="<?= url('/apply') ?>" id="calc_apply_btn" class="btn btn-accent text-nowrap">
              Apply for This Branch &rarr;
            </a>
          </div>
        </div>
      </div>
    </div>

    <script>
      function calculateAdmission() {
        const mode = document.getElementById('calc_mode').value;
        const pct = parseFloat(document.getElementById('calc_percentage').value) || 0;
        const category = document.getElementById('calc_category').value;
        const branch = document.getElementById('calc_branch').value;

        const minReq = (category === 'reserved') ? 40 : 45;
        const isEligible = pct >= minReq;

        const badge = document.getElementById('calc_status_badge');
        const pathLabel = document.getElementById('calc_path_label');
        const msg = document.getElementById('calc_message');
        const sch = document.getElementById('calc_scholarship');
        const applyBtn = document.getElementById('calc_apply_btn');

        pathLabel.textContent = (mode === 'lateral') ? '3-Year Lateral Entry B.Tech (Direct 3rd Semester)' : '4-Year B.Tech Degree Programme';

        if (!isEligible) {
          badge.className = 'badge badge-warning';
          badge.textContent = 'CRITERIA NOT MET (' + minReq + '% REQUIRED)';
          msg.textContent = 'Your current score of ' + pct.toFixed(1) + '% is below the regulatory ' + minReq + '% threshold for ' + (category === 'reserved' ? 'reserved' : 'general') + ' category.';
          sch.innerHTML = '<span class="text-muted">Please connect with our academic counseling desk for remedial eligibility advice.</span>';
          applyBtn.textContent = 'Speak with Counsellor';
          applyBtn.setAttribute('data-open-enquiry-modal', 'true');
          applyBtn.href = '#';
          applyBtn.onclick = function(e) { e.preventDefault(); window.openQuickEnquiryModal(); };
        } else {
          badge.className = 'badge badge-success';
          badge.textContent = 'ELIGIBLE FOR DIRECT ADMISSION';
          msg.textContent = 'Congratulations! Your score of ' + pct.toFixed(1) + '% qualifies you for admission into B.Tech ' + branch + ' at KCET.';
          
          if (pct >= 85) {
            sch.innerHTML = '<i class="fa-solid fa-trophy text-accent me-1"></i> <strong>Presidential Academic Merit Tier:</strong> Eligible for <strong>25% Tuition Fee Waiver</strong> for Year 1!';
          } else if (pct >= 75) {
            sch.innerHTML = '<i class="fa-solid fa-award text-accent me-1"></i> <strong>Merit Achiever Concession:</strong> Eligible for <strong>15% Tuition Fee Waiver</strong>!';
          } else if (pct >= 60) {
            sch.innerHTML = '<i class="fa-solid fa-circle-check text-secondary me-1"></i> Approved standard state fee structure with semester installment payment facility available.';
          } else {
            sch.innerHTML = '<i class="fa-solid fa-circle-check text-secondary me-1"></i> Qualifies for standard enrollment under AICTE / University of Kashmir guidelines.';
          }

          applyBtn.textContent = 'Apply for ' + branch + ' &rarr;';
          applyBtn.removeAttribute('data-open-enquiry-modal');
          applyBtn.onclick = null;
          applyBtn.href = '<?= url('/apply') ?>';
        }
      }
      document.addEventListener('DOMContentLoaded', calculateAdmission);
    </script>

    <!-- Transparent Fee Note -->
    <div class="admissions-fee-alert">
      <h3 class="admissions-fee-title">Institutional Fee Schedule Notice</h3>
      <p class="admissions-fee-desc">
        KCET adheres to the approved annual fee structure designated by the state fee regulatory committee for technical institutions. In order to avoid misrepresentation of stale historical fee figures, the college publishes verified fee schedules directly through the accounts counter and admissions counselling desk.
      </p>
      <p class="admissions-fee-sub m-0">
        Tuition fee payment plans, merit concessions, and state welfare scholarship processing are actively facilitated for eligible students.
      </p>
    </div>

    <!-- Admissions FAQs -->
    <?php if (!empty($faqs)): ?>
    <div class="mb-5">
      <div class="section-header">
        <span class="section-badge">Common Questions</span>
        <h2 class="section-title">Admissions FAQ</h2>
      </div>

      <div class="accordion">
        <?php foreach ($faqs as $faq): ?>
        <div class="accordion-item">
          <button type="button" class="accordion-header" aria-expanded="false">
            <span><?= e($faq['question']) ?></span>
            <span class="accordion-icon">+</span>
          </button>
          <div class="accordion-content">
            <p><?= nl2br(e($faq['answer'])) ?></p>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <!-- Ready to apply banner -->
    <div class="cta-banner">
      <div class="cta-banner-text">
        <h2>Submit Your Admission Application</h2>
        <p>Complete your registration online in a few minutes. Generate your reference number and secure your seat for 2026-27.</p>
      </div>
      <div class="cta-banner-actions">
        <a href="<?= url('/apply') ?>" class="btn btn-accent btn-lg">Apply Online Now &rarr;</a>
        <button type="button" class="btn btn-white btn-lg" data-open-enquiry-modal>Speak with a Counsellor</button>
      </div>
    </div>
  </div>
</section>
