<?php
/**
 * Single Notice Detail View
 */
?>

<!-- Header -->
<div class="page-hero" style="background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);">
  <div class="container page-hero-inner">
    <span class="page-hero-badge">
      <?= strtoupper(e($notice['category'])) ?> NOTICE
    </span>
    <h1 class="page-hero-title"><?= e($notice['title']) ?></h1>
    <div class="text-slate-200 text-sm">
      Published on: <?= format_date($notice['publish_date']) ?>
      <?php if (!empty($notice['expiry_date'])): ?>
        | Valid Until: <?= format_date($notice['expiry_date']) ?>
      <?php endif; ?>
    </div>
  </div>
</div>

<section class="section">
  <div class="container">
    <div class="detail-layout-grid">
      <div>
        <div class="detail-card-panel">
          <div class="text-dark text-base leading-relaxed">
            <?= nl2br(e($notice['content'] ?: $notice['summary'])) ?>
          </div>

          <?php if (!empty($notice['attachment_file'])): ?>
          <div class="detail-attachment-box">
            <div>
              <strong class="text-primary text-base block mb-1">Official Notice Circular Document</strong>
              <span class="text-muted text-xs">Download the signed institutional notification document.</span>
            </div>
            <a href="<?= asset($notice['attachment_file']) ?>" download class="btn btn-primary btn-sm">Download PDF</a>
          </div>
          <?php endif; ?>
        </div>

        <a href="<?= url('/notices') ?>" class="btn btn-outline">&larr; Back to Notices & Announcements</a>
      </div>

      <aside>
        <?php if (!empty($recentNotices)): ?>
        <div class="sidebar-nav-card">
          <h4 class="text-primary font-bold text-base mb-3">Recent Circulars</h4>
          <div class="d-flex flex-col gap-3">
            <?php foreach ($recentNotices as $rn): ?>
            <div>
              <span class="text-secondary text-xs font-bold text-uppercase"><?= e($rn['category']) ?> &bull; <?= format_date($rn['publish_date']) ?></span>
              <h5 class="text-sm font-bold mt-1 m-0">
                <a href="<?= url('/notices/' . $rn['slug']) ?>" class="text-primary no-underline"><?= e($rn['title']) ?></a>
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
