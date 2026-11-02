<?php
/**
 * Programmes Catalog View
 */
?>

<!-- Page Header -->
<div class="page-hero" style="background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);">
  <div class="container page-hero-inner">
    <span class="page-hero-badge">
      Academics & Curricula
    </span>
    <h1 class="page-hero-title">Undergraduate Engineering Programmes</h1>
    <p class="page-hero-desc">
      Four-year B.Tech degree courses designed to provide rigorous analytical theory, extensive laboratory practice, and high-growth technical careers.
    </p>
  </div>
</div>

<section class="section">
  <div class="container">
    <!-- Department Filter Bar -->
    <div class="dept-filter-bar">
      <span class="text-primary font-bold text-sm me-2">Filter by Branch:</span>
      <a href="<?= url('/programmes') ?>" class="btn btn-sm <?= empty($selectedDept) ? 'btn-primary' : 'btn-outline' ?>">
        All Programmes
      </a>
      <?php foreach ($departments as $dept): ?>
      <a href="<?= url('/programmes?dept=' . $dept['id']) ?>" class="btn btn-sm <?= ($selectedDept === (int)$dept['id']) ? 'btn-primary' : 'btn-outline' ?>">
        <?= e($dept['name']) ?>
      </a>
      <?php endforeach; ?>
    </div>

    <!-- Programmes List -->
    <?php if (empty($programmes)): ?>
      <div class="faculty-empty-state">
        <p class="text-muted text-lg mb-3">No engineering programmes match your current filter.</p>
        <a href="<?= url('/programmes') ?>" class="btn btn-primary">View All Programmes</a>
      </div>
    <?php else: ?>
      <div class="cards-grid">
        <?php foreach ($programmes as $prog): ?>
        <article class="card">
          <?php if (!empty($prog['featured_image'])): ?>
            <div class="card-image-wrapper">
              <a href="<?= url('/programmes/' . $prog['slug']) ?>" tabindex="-1" aria-hidden="true">
                <img src="<?= asset($prog['featured_image']) ?>" alt="<?= e($prog['name']) ?>" loading="lazy" class="h-48 w-full object-cover block">
              </a>
            </div>
          <?php endif; ?>
          <div class="card-body">
            <div class="card-meta">
              <span class="text-secondary font-bold"><?= e($prog['degree_type']) ?></span>
              <span>&bull;</span>
              <span><?= e($prog['duration']) ?></span>
            </div>

            <h2 class="card-title text-xl">
              <a href="<?= url('/programmes/' . $prog['slug']) ?>"><?= e($prog['name']) ?></a>
            </h2>

            <div class="programme-card-meta">
              <div class="programme-meta-item">
                <i class="fa-solid fa-users text-secondary text-sm"></i>
                <span>Intake: <?= e($prog['intake'] ?: 'Approved Seats') ?></span>
              </div>
              <div class="programme-meta-item">
                <i class="fa-solid fa-calendar-check text-secondary text-sm"></i>
                <span>Admissions: <?= (int)$prog['is_admissions_open'] === 1 ? 'Open (2026-27)' : 'Inquire' ?></span>
              </div>
            </div>

            <p class="card-desc"><?= e($prog['summary']) ?></p>

            <div class="card bg-subtle p-3 mb-3 text-muted text-xs">
              <strong>Eligibility:</strong> <?= truncate($prog['eligibility'] ?? '10+2 with PCM', 100) ?>
            </div>

            <div class="card-footer">
              <a href="<?= url('/programmes/' . $prog['slug']) ?>" class="btn btn-outline btn-sm">Explore Syllabus & Details</a>
              <button type="button" class="btn btn-accent btn-sm" data-open-enquiry-modal data-programme-id="<?= $prog['id'] ?>">Enquire</button>
            </div>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <!-- Admissions Prompt Banner -->
    <div class="admissions-cta-banner">
      <div>
        <h3 class="text-2xl font-bold mb-1">Interested in Joining KCET?</h3>
        <p class="text-slate-200 text-base max-w-xl m-0">Applications for both regular 1st year (4 Years) and Lateral Entry into 3rd semester (3 Years) are open.</p>
      </div>
      <div class="d-flex gap-3 flex-wrap">
        <a href="<?= url('/apply') ?>" class="btn btn-accent btn-lg">Apply Online Now</a>
        <a href="<?= url('/admissions') ?>" class="btn btn-white btn-lg">Admissions Guide</a>
      </div>
    </div>
  </div>
</section>
