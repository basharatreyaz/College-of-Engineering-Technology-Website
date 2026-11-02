<?php
/**
 * Single Facility Detail View
 */
?>

<!-- Header -->
<div class="page-hero" style="background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);">
  <div class="container page-hero-inner">
    <span class="page-hero-badge">
      <?= e($facility['badge'] ?? 'Campus Infrastructure') ?>
    </span>
    <h1 class="page-hero-title"><?= e($facility['title']) ?></h1>
    <p class="page-hero-desc">
      <?= e($facility['summary']) ?>
    </p>
  </div>
</div>

<section class="section">
  <div class="container">
    <div class="detail-layout-grid">
      <div>
        <?php if (!empty($facility['image'])): ?>
          <div class="detail-featured-media">
            <img src="<?= asset($facility['image']) ?>" alt="<?= e($facility['title']) ?>" class="detail-featured-img">
          </div>
        <?php endif; ?>
        <div class="detail-card-panel">
          <h2 class="text-primary font-bold text-2xl mb-3">Facility Highlights & Overview</h2>
          <div class="text-muted text-base leading-relaxed">
            <?= nl2br(e($facility['description'] ?: $facility['summary'])) ?>
          </div>
        </div>

        <div class="card bg-subtle p-4 mb-4">
          <h3 class="text-primary font-bold text-lg mb-2">Campus Infrastructure Standards</h3>
          <p class="text-muted text-sm leading-relaxed m-0">
            Maintained under standard college operational procedures. For special facility reservations, seminar hall bookings, or route information, please contact the administrative registrar.
          </p>
        </div>
      </div>

      <aside>
        <div class="sidebar-action-card">
          <h3 class="text-primary font-bold text-lg mb-2">Campus Visit & Tour</h3>
          <p class="text-muted text-sm leading-relaxed mb-4">
            Experience the KCET campus in Ranbirgarh, Srinagar in person. Prospective students and parents are welcome for campus orientation visits.
          </p>
          <button type="button" class="btn btn-accent btn-sm w-full mb-2" data-open-enquiry-modal>Schedule Campus Visit</button>
          <a href="<?= url('/contact') ?>" class="btn btn-outline btn-sm w-full text-center">Contact Admissions Desk</a>
        </div>

        <?php if (!empty($otherFacilities)): ?>
        <div class="sidebar-nav-card">
          <h4 class="text-primary font-bold text-base mb-3">Other Campus Facilities</h4>
          <div class="d-flex flex-col gap-2">
            <?php foreach ($otherFacilities as $of): ?>
              <a href="<?= url('/facilities/' . $of['slug']) ?>" class="sidebar-nav-item">
                <?= e($of['title']) ?> <i class="fa-solid fa-arrow-right ms-1 text-xs"></i>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>
      </aside>
    </div>
  </div>
</section>
