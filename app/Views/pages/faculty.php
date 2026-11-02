<?php
/**
 * Faculty Directory View
 */
?>

<!-- Header -->
<div class="page-hero" style="background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);">
  <div class="container page-hero-inner">
    <span class="page-hero-badge">
      Academic Mentors
    </span>
    <h1 class="page-hero-title">Faculty & Academic Staff</h1>
    <p class="page-hero-desc">
      Meet the distinguished professors, researchers, and technical instructors guiding engineering cohorts at KCET Srinagar.
    </p>
  </div>
</div>

<section class="section">
  <div class="container">
    <!-- Search & Filter Controls -->
    <div class="faculty-filter-box">
      <form action="<?= url('/faculty') ?>" method="GET" class="faculty-filter-form">
        <div class="filter-field-search">
          <input type="text" name="q" value="<?= e($searchQuery ?? '') ?>" class="form-control" placeholder="Search faculty by name, qualification, or specialization...">
        </div>
        <div class="filter-field-select">
          <select name="dept" class="form-control" onchange="this.form.submit()">
            <option value="">-- All Departments --</option>
            <?php foreach ($departments as $d): ?>
              <option value="<?= $d['id'] ?>" <?= ($selectedDept === (int)$d['id']) ? 'selected' : '' ?>>
                <?= e($d['name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary btn-sm">Search</button>
          <?php if (!empty($searchQuery) || !empty($selectedDept)): ?>
            <a href="<?= url('/faculty') ?>" class="btn btn-outline btn-sm">Clear</a>
          <?php endif; ?>
        </div>
      </form>
    </div>

    <!-- Faculty Cards -->
    <?php if (empty($faculty)): ?>
      <div class="faculty-empty-state">
        <p class="text-muted text-lg mb-3">No faculty members matched your criteria.</p>
        <a href="<?= url('/faculty') ?>" class="btn btn-primary">Reset Filters</a>
      </div>
    <?php else: ?>
      <div class="cards-grid">
        <?php foreach ($faculty as $member): ?>
        <article class="card">
          <div class="card-body">
            <div class="d-flex align-items-start gap-3 mb-3">
              <?php if (!empty($member['photo']) && file_exists(ROOT_PATH . '/public/' . ltrim($member['photo'], '/'))): ?>
                <img src="<?= asset($member['photo']) ?>" alt="<?= e($member['name']) ?>" width="58" height="58" class="faculty-avatar">
              <?php else: ?>
                <div class="faculty-avatar--fallback">
                  <?= strtoupper(substr($member['name'], 0, 1)) ?>
                </div>
              <?php endif; ?>
              <div>
                <h3 class="text-primary font-bold text-lg leading-snug mb-1">
                  <?= e($member['name']) ?>
                </h3>
                <span class="text-secondary font-semibold text-sm block">
                  <?= e($member['designation']) ?>
                </span>
                <span class="text-muted text-xs">
                  <?= e($member['department_name'] ?? 'Engineering Department') ?>
                </span>
              </div>
            </div>

            <div class="faculty-meta-box">
              <div class="mb-1">
                <strong class="text-dark">Qualification:</strong> <?= e($member['qualification']) ?>
              </div>
              <?php if (!empty($member['specialization'])): ?>
              <div>
                <strong class="text-dark">Area of Specialization:</strong> <?= e($member['specialization']) ?>
              </div>
              <?php endif; ?>
            </div>

            <?php if (!empty($member['bio'])): ?>
            <p class="card-desc text-sm leading-relaxed mb-3">
              <?= e($member['bio']) ?>
            </p>
            <?php endif; ?>

            <div class="card-footer pt-3">
              <?php if (!empty($member['email'])): ?>
                <a href="mailto:<?= e($member['email']) ?>" class="text-primary font-semibold text-xs inline-flex align-items-center gap-1 no-underline">
                  <i class="fa-solid fa-envelope text-sm"></i>
                  <?= e($member['email']) ?>
                </a>
              <?php else: ?>
                <span class="text-muted text-xs">Ranbirgarh Campus</span>
              <?php endif; ?>
            </div>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
