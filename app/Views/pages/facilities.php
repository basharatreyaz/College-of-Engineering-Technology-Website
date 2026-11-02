<?php
/**
 * Campus Facilities View
 */
?>

<!-- Header -->
<div class="page-hero" style="background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);">
  <div class="container page-hero-inner">
    <span class="page-hero-badge">
      Campus Infrastructure
    </span>
    <h1 class="page-hero-title">Campus Facilities & Amenities</h1>
    <p class="page-hero-desc">
      Spread across 100+ kanals in Ranbirgarh, Srinagar, KCET provides world-class academic, technical, transit, and security facilities.
    </p>
  </div>
</div>

<section class="section">
  <div class="container">
    <div class="cards-grid">
      <?php foreach ($facilities as $facility): ?>
      <article class="card">
        <?php if (!empty($facility['image'])): ?>
          <div class="card-image-wrapper">
            <img src="<?= asset($facility['image']) ?>" alt="<?= e($facility['title']) ?>" loading="lazy" class="h-48 w-full object-cover">
          </div>
        <?php endif; ?>
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start mb-2">
            <?php if (!empty($facility['badge'])): ?>
              <span class="badge badge-success"><?= e($facility['badge']) ?></span>
            <?php endif; ?>
          </div>

          <h2 class="card-title text-xl">
            <a href="<?= url('/facilities/' . $facility['slug']) ?>"><?= e($facility['title']) ?></a>
          </h2>

          <p class="card-desc"><?= e($facility['summary']) ?></p>

          <div class="card-footer">
            <a href="<?= url('/facilities/' . $facility['slug']) ?>" class="btn btn-outline btn-sm">Read Details <i class="fa-solid fa-arrow-right ms-1"></i></a>
          </div>
        </div>
      </article>
      <?php endforeach; ?>
    </div>

    <!-- Campus Transit & Safety Notice Banner -->
    <div class="transit-safety-grid">
      <div>
        <h3 class="text-primary font-bold text-lg mb-2">Daily Student Transport Fleet</h3>
        <p class="text-muted text-sm leading-relaxed m-0">
          KCET operates dedicated college buses connecting major hubs in Srinagar city, Budgam, Ganderbal, and adjoining areas, providing reliable daily transit.
        </p>
      </div>
      <div>
        <h3 class="text-primary font-bold text-lg mb-2">Comprehensive Campus Safety</h3>
        <p class="text-muted text-sm leading-relaxed m-0">
          Round-the-clock 24/7 CCTV surveillance, active security personnel, certified fire detection systems, and dedicated health room attendants.
        </p>
      </div>
      <div>
        <h3 class="text-primary font-bold text-lg mb-2">Barrier-Free Access</h3>
        <p class="text-muted text-sm leading-relaxed m-0">
          Corridors, laboratory entries, ramps, and elevators are engineered to support universal accessibility for all students and staff.
        </p>
      </div>
    </div>
  </div>
</section>
