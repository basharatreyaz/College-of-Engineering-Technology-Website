<?php
/**
 * Single Event Detail View
 */
?>

<!-- Header -->
<div class="page-hero" style="background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);">
  <div class="container page-hero-inner">
    <span class="page-hero-badge">
      <?= e($event['category']) ?>
    </span>
    <h1 class="page-hero-title"><?= e($event['title']) ?></h1>
    <div class="d-flex align-items-center gap-3 text-sm text-slate-200 flex-wrap">
      <span><i class="fa-solid fa-calendar-day me-1 text-accent"></i> <strong>Date:</strong> <?= format_date($event['start_date']) ?><?php if (!empty($event['end_date']) && $event['end_date'] !== $event['start_date']): ?> &ndash; <?= format_date($event['end_date']) ?><?php endif; ?></span>
      <?php if (!empty($event['location'])): ?>
        <span>&bull;</span>
        <span><i class="fa-solid fa-location-dot me-1 text-accent"></i> <strong>Venue / Location:</strong> <?= e($event['location']) ?></span>
      <?php endif; ?>
    </div>
  </div>
</div>

<section class="section">
  <div class="container">
    <div class="detail-layout-grid">
      <div>
        <?php if (!empty($event['featured_image'])): ?>
          <div class="detail-featured-media">
            <img src="<?= asset($event['featured_image']) ?>" alt="<?= e($event['title']) ?>" class="detail-featured-img">
          </div>
        <?php endif; ?>
        <div class="detail-card-panel">
          <h2 class="text-primary font-bold text-xl mb-3">Event Overview & Details</h2>
          <div class="text-muted text-base leading-relaxed">
            <?= nl2br(e($event['content'] ?: $event['summary'])) ?>
          </div>
        </div>

        <div class="d-flex justify-content-between align-items-center">
          <a href="<?= url('/events') ?>" class="btn btn-outline"><i class="fa-solid fa-arrow-left me-1"></i> Back to Events Archive</a>
          <button type="button" class="btn btn-primary" onclick="navigator.clipboard.writeText(window.location.href); alert('Event URL copied to clipboard!');"><i class="fa-solid fa-share-nodes me-1"></i> Share Event</button>
        </div>
      </div>

      <aside>
        <?php if (!empty($recentEvents)): ?>
        <div class="sidebar-nav-card">
          <h4 class="text-primary font-bold text-base mb-3">Other Campus Stories</h4>
          <div class="d-flex flex-col gap-3">
            <?php foreach ($recentEvents as $re): ?>
            <div>
              <span class="text-secondary text-xs font-bold text-uppercase"><?= e($re['category']) ?> &bull; <?= format_date($re['start_date']) ?></span>
              <h5 class="text-sm font-bold mt-1 m-0">
                <a href="<?= url('/events/' . $re['slug']) ?>" class="text-primary no-underline"><?= e($re['title']) ?></a>
              </h5>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>
      </aside>
    </div>
  </div>
</section>
