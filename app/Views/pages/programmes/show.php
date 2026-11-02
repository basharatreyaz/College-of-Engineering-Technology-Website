<?php
/**
 * Single Programme Detail View
 */
?>

<!-- Programme Header -->
<div class="page-hero" style="background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);">
  <div class="container page-hero-inner">
    <span class="page-hero-badge">
      <?= e($programme['degree_type']) ?> Degree
    </span>
    <h1 class="page-hero-title"><?= e($programme['name']) ?></h1>
    <p class="page-hero-desc">
      <?= e($programme['summary']) ?>
    </p>
  </div>
</div>

<section class="section">
  <div class="container">
    <div class="detail-layout-grid">
      <!-- Main Content Col -->
      <div>
        <?php if (!empty($programme['featured_image'])): ?>
          <div class="detail-featured-media">
            <img src="<?= asset($programme['featured_image']) ?>" alt="<?= e($programme['name']) ?>" class="detail-featured-img">
          </div>
        <?php endif; ?>

        <!-- Key Quick Meta Strip -->
        <div class="detail-meta-strip">
          <div>
            <span class="detail-meta-label">Course Duration</span>
            <p class="detail-meta-val"><?= e($programme['duration']) ?></p>
          </div>
          <div>
            <span class="detail-meta-label">Approved Intake</span>
            <p class="detail-meta-val"><?= e($programme['intake'] ?: 'Approved Seats') ?></p>
          </div>
          <div>
            <span class="detail-meta-label">Parent Department</span>
            <p class="detail-meta-val">
              <a href="<?= url('/departments/' . $programme['department_slug']) ?>" class="text-secondary no-underline">
                <?= e($programme['department_name']) ?> &rarr;
              </a>
            </p>
          </div>
          <div>
            <span class="detail-meta-label">Admissions</span>
            <p class="detail-meta-val text-accent">
              <?= (int)$programme['is_admissions_open'] === 1 ? 'Open for 2026-27' : 'Closed' ?>
            </p>
          </div>
        </div>

        <!-- Programme Overview & Description -->
        <div class="mb-5">
          <h2 class="text-primary font-bold text-2xl mb-3">Programme Overview</h2>
          <div class="text-muted text-base leading-relaxed">
            <?= nl2br(e($programme['description'] ?: $programme['summary'])) ?>
          </div>
        </div>

        <!-- Eligibility Criteria -->
        <div class="card p-4 mb-5 shadow-sm">
          <h3 class="text-primary font-bold text-xl mb-3">Eligibility Criteria</h3>
          <p class="text-muted leading-relaxed mb-3">
            <?= nl2br(e($programme['eligibility'])) ?>
          </p>
          <div class="lateral-entry-box">
            <strong>Lateral Entry Provision:</strong> Candidates possessing a 3-year Engineering Diploma in an allied branch with at least 45% aggregate marks (40% for reserved category) are eligible for direct admission to the 3rd semester (2nd Year).
          </div>
        </div>

        <!-- Career Prospects -->
        <?php if (!empty($programme['career_prospects'])): ?>
        <div class="mb-5">
          <h3 class="text-primary font-bold text-xl mb-3">Career Pathways & Industry Outcomes</h3>
          <div class="career-outcomes-box">
            <?= nl2br(e($programme['career_prospects'])) ?>
          </div>
        </div>
        <?php endif; ?>

        <!-- Fee Structure Note -->
        <div class="fee-schedule-box">
          <h4 class="text-primary font-bold text-base mb-2">Fee Schedule & Scholarships</h4>
          <p class="text-muted text-sm leading-relaxed mb-2">
            <?= e($programme['fee_info'] ?: 'KCET adheres to the transparent fee schedule approved by regional higher-education authorities. Installment assistance and merit scholarships are available.') ?>
          </p>
          <p class="text-muted text-xs m-0">
            To obtain an exact session fee breakdown or scholarship eligibility check, please consult the Admissions Counter or submit an enquiry.
          </p>
        </div>

        <!-- Syllabus Document Download -->
        <div class="syllabus-download-bar mb-4">
          <div class="d-flex align-items-center gap-3">
            <div class="pdf-icon-badge">
              PDF
            </div>
            <div>
              <h4 class="text-primary font-bold text-base mb-1">Complete Curriculum & Syllabus</h4>
              <span class="text-muted text-sm">Official semester-wise course topics, lab credits, and examination marks scheme.</span>
            </div>
          </div>
          <?php if (!empty($programme['syllabus_file'])): ?>
            <a href="<?= asset($programme['syllabus_file']) ?>" download class="btn btn-outline btn-sm">Download PDF</a>
          <?php else: ?>
            <a href="<?= url('/syllabus/' . $programme['slug']) ?>" class="btn btn-outline btn-sm">View Curriculum Syllabus</a>
          <?php endif; ?>
        </div>
      </div>

      <!-- Sidebar Col -->
      <aside class="programme-sidebar">
        <!-- Quick Apply Card -->
        <div class="sidebar-action-card">
          <h3 class="text-primary font-bold text-xl mb-2">Admissions Open</h3>
          <p class="text-muted text-sm leading-relaxed mb-4">
            Secure your seat for the academic session 2026-27 at KCET Srinagar.
          </p>
          <a href="<?= url('/apply?branch=' . urlencode($programme['slug'])) ?>" class="btn btn-accent btn-lg w-full mb-2">Apply Online Now &rarr;</a>
          <button type="button" class="btn btn-outline w-full" data-open-enquiry-modal data-programme-id="<?= $programme['id'] ?>">Request Enquiry</button>
        </div>

        <!-- Related Programmes -->
        <?php if (!empty($relatedProgrammes)): ?>
        <div class="sidebar-nav-card">
          <h4 class="text-primary font-bold text-base mb-3">Other B.Tech Disciplines</h4>
          <div class="d-flex flex-col gap-2">
            <?php foreach ($relatedProgrammes as $rp): ?>
              <a href="<?= url('/programmes/' . $rp['slug']) ?>" class="sidebar-nav-item">
                <?= e($rp['name']) ?> &rarr;
              </a>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>
      </aside>
    </div>
  </div>
</section>
