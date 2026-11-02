<?php
/**
 * Departments Catalog View
 */
?>

<!-- Page Header -->
<div class="page-hero" style="background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);">
  <div class="container page-hero-inner">
    <span class="page-hero-badge">
      Academic Units
    </span>
    <h1 class="page-hero-title">Academic Departments</h1>
    <p class="page-hero-desc">
      Explore KCET's core engineering and scientific departments, fostering hands-on laboratory learning and research mentorship.
    </p>
  </div>
</div>

<section class="section">
  <div class="container">
    <div class="cards-grid">
      <?php foreach ($departments as $dept): ?>
      <article class="card">
        <div class="card-body">
          <div class="card-meta">
            <span class="text-secondary font-bold">Department Code: <?= e($dept['code']) ?></span>
          </div>

          <h2 class="card-title text-xl">
            <a href="<?= url('/departments/' . $dept['slug']) ?>"><?= e($dept['name']) ?></a>
          </h2>

          <?php if (!empty($dept['hod_name'])): ?>
          <div class="hod-mini-strip">
            <div class="hod-avatar--fallback hod-avatar--sm">
              <?= strtoupper(substr($dept['hod_name'], 0, 1)) ?>
            </div>
            <div>
              <span class="text-primary font-bold text-sm block"><?= e($dept['hod_name']) ?></span>
              <span class="text-muted text-xs block"><?= e($dept['hod_designation'] ?: 'Head of Department') ?></span>
            </div>
          </div>
          <?php endif; ?>

          <p class="card-desc"><?= truncate($dept['overview'] ?? '', 160) ?></p>

          <?php if (!empty($dept['labs_info'])): ?>
          <div class="card bg-subtle p-3 mb-3 text-muted text-xs">
            <strong>Labs:</strong> <?= truncate($dept['labs_info'], 90) ?>
          </div>
          <?php endif; ?>

          <div class="card-footer">
            <a href="<?= url('/departments/' . $dept['slug']) ?>" class="btn btn-outline btn-sm">Explore Department &rarr;</a>
          </div>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
