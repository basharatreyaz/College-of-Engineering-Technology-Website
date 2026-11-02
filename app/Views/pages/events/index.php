<?php
/**
 * Events Catalog View
 */
?>

<!-- Header -->
<div class="page-hero" style="background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);">
  <div class="container page-hero-inner">
    <span class="page-hero-badge">
      Happenings & Achievements
    </span>
    <h1 class="page-hero-title">Campus Events & Stories</h1>
    <p class="page-hero-desc">
      Stay connected with academic workshops, student field visits, technical hackathons, and guest lectures hosted at KCET.
    </p>
  </div>
</div>

<section class="section">
  <div class="container">
    <!-- Filter Tabs -->
    <div class="timeframe-filter-bar">
      <span class="text-primary font-bold text-sm me-2">Timeframe:</span>
      <a href="<?= url('/events') ?>" class="btn btn-sm <?= empty($selectedTimeframe) ? 'btn-primary' : 'btn-outline' ?>">
        All Events
      </a>
      <a href="<?= url('/events?time=upcoming') ?>" class="btn btn-sm <?= ($selectedTimeframe === 'upcoming') ? 'btn-primary' : 'btn-outline' ?>">
        Upcoming Events
      </a>
      <a href="<?= url('/events?time=past') ?>" class="btn btn-sm <?= ($selectedTimeframe === 'past') ? 'btn-primary' : 'btn-outline' ?>">
        Past Events & Archives
      </a>
    </div>

    <?php if (empty($events)): ?>
      <div class="faculty-empty-state">
        <p class="text-muted text-lg mb-3">No events match your current filter.</p>
        <a href="<?= url('/events') ?>" class="btn btn-primary">Reset Filter</a>
      </div>
    <?php else: ?>
      <div class="cards-grid">
        <?php foreach ($events as $event): ?>
        <article class="card">
          <?php if (!empty($event['featured_image'])): ?>
            <div class="card-image-wrapper">
              <img src="<?= asset($event['featured_image']) ?>" alt="<?= e($event['title']) ?>" loading="lazy" class="h-48 w-full object-cover">
            </div>
          <?php endif; ?>
          <div class="card-body">
            <div class="card-meta">
              <span class="text-secondary font-bold"><?= e($event['category']) ?></span>
              <span>&bull;</span>
              <time datetime="<?= e($event['start_date']) ?>"><?= format_date($event['start_date']) ?></time>
              <?php if (!empty($event['location'])): ?>
                <span>&bull;</span>
                <span><?= e($event['location']) ?></span>
              <?php endif; ?>
            </div>

            <h2 class="card-title text-xl">
              <a href="<?= url('/events/' . $event['slug']) ?>"><?= e($event['title']) ?></a>
            </h2>

            <p class="card-desc"><?= e($event['summary']) ?></p>

            <div class="card-footer">
              <a href="<?= url('/events/' . $event['slug']) ?>" class="btn btn-outline btn-sm">Read Full Story <i class="fa-solid fa-arrow-right ms-1"></i></a>
            </div>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
