<?php
/**
 * Dedicated Leadership Message View
 * Supports Chairman, Director, and Principal official communiqués
 */

$photo = $leader['photo'];
$resolvedPhoto = (!empty($photo) && file_exists(ROOT_PATH . '/public/' . ltrim($photo, '/')))
  ? $photo
  : $leader['default_photo'];
?>

<!-- Dedicated Page Hero Header -->
<div class="page-hero page-hero--bordered" style="background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);">
  <div class="page-hero-overlay"></div>
  
  <div class="container page-hero-inner">
    <span class="page-hero-badge-pill">
      <?= e($leader['badge']) ?>
    </span>

    <h1 class="page-hero-title">
      <?= e($leader['title']) ?>
    </h1>

    <p class="page-hero-desc">
      Official Communiqué &bull; <?= e($leader['name']) ?>, <?= e($leader['designation']) ?>
    </p>
  </div>
</div>

<!-- Main Section: Profile Sidebar + Communiqué Body -->
<section class="section">
  <div class="container">
    <div class="leadership-grid" style="--leader-theme: <?= $leader['theme_color'] ?>;">
      
      <!-- Left Profile & Context Sidebar -->
      <aside class="leader-sidebar">
        <!-- Portrait Card -->
        <div class="leader-portrait-card">
          <div class="leader-portrait-wrap">
            <img src="<?= asset($resolvedPhoto) ?>" alt="<?= e($leader['name']) ?>" class="leader-portrait-img leader-theme-border">
            <div class="leader-cert-badge leader-theme-color">
              <i class="fa-solid fa-certificate"></i>
            </div>
          </div>

          <h2 class="leader-name">
            <?= e($leader['name']) ?>
          </h2>
          <div class="leader-designation">
            <?= e($leader['designation']) ?>
          </div>
          <?php if (!empty($leader['qualifications'])): ?>
            <div class="leader-qualifications">
              <?= e($leader['qualifications']) ?>
            </div>
          <?php endif; ?>

          <div class="leader-meta-list">
            <div class="leader-meta-item">
              <i class="fa-solid fa-building-flag leader-theme-color"></i>
              <span><?= e($leader['office']) ?></span>
            </div>
            <div class="leader-meta-item">
              <i class="fa-solid fa-envelope leader-theme-color"></i>
              <a href="mailto:<?= e($leader['email']) ?>" class="text-primary font-semibold no-underline"><?= e($leader['email']) ?></a>
            </div>
            <div class="leader-meta-item">
              <i class="fa-solid fa-phone leader-theme-color"></i>
              <span><?= e($leader['phone']) ?></span>
            </div>
            <div class="leader-meta-item">
              <i class="fa-solid fa-location-dot leader-theme-color"></i>
              <span>Ranbirgarh Campus, Srinagar</span>
            </div>
          </div>

          <a href="<?= url('/contact') ?>" class="btn btn-outline w-full justify-center text-sm">
            <i class="fa-solid fa-paper-plane me-1"></i> Contact Office Desk
          </a>
        </div>
      </aside>

      <!-- Right Main Communiqué Column -->
      <main>
        <div class="letterhead-box">
          
          <!-- Official Letterhead Banner -->
          <div class="letterhead-banner">
            <div class="letterhead-brand">
              <img src="<?= asset('assets/images/kcet-emblem-official.png') ?>" alt="KCET Official Emblem" width="48" height="48" class="letterhead-emblem">
              <div>
                <strong class="letterhead-title">KASHMIR COLLEGE OF ENGINEERING &amp; TECHNOLOGY</strong>
                <span class="letterhead-subtitle">Approved by AICTE, New Delhi &bull; Affiliated to University of Kashmir &bull; Estd. 2002</span>
              </div>
            </div>
            <div class="text-right">
              <span class="badge communique-record-badge">
                Official Institutional Record
              </span>
            </div>
          </div>

          <!-- Inspiring Quote Blockquote -->
          <?php if (!empty($leader['quote'])): ?>
            <div class="communique-quote-wrap leader-theme-border">
              <i class="fa-solid fa-quote-left communique-quote-icon leader-theme-color"></i>
              <blockquote class="communique-quote-text">
                "<?= e($leader['quote']) ?>"
              </blockquote>
            </div>
          <?php endif; ?>

          <!-- Address Body Content -->
          <div class="communique-body">
            <?php
              $paragraphs = array_filter(array_map('trim', explode("\n", $leader['message'])));
              if (empty($paragraphs)) {
                $paragraphs = [$leader['message']];
              }
            ?>
            <?php foreach ($paragraphs as $para): ?>
              <p>
                <?= e($para) ?>
              </p>
            <?php endforeach; ?>
          </div>

          <!-- Strategic Focus Pillars -->
          <?php if (!empty($leader['focus_pillars'])): ?>
            <div class="focus-pillars-box">
              <h3 class="text-primary font-bold text-base mb-3 d-flex align-items-center gap-2">
                <i class="fa-solid fa-compass leader-theme-color"></i>
                Strategic Priorities &amp; Leadership Directives
              </h3>
              <div class="focus-pillars-grid">
                <?php foreach ($leader['focus_pillars'] as $pillar): ?>
                  <div class="focus-pillar-item">
                    <i class="fa-solid fa-circle-check mt-1 flex-shrink-0 leader-theme-color"></i>
                    <span><?= e($pillar) ?></span>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endif; ?>

          <!-- Formal Institutional Sign-off -->
          <div class="communique-signoff">
            <div>
              <div class="text-muted italic text-sm mb-2">
                Yours in Academic Excellence &amp; Engineering Innovation,
              </div>
              <strong class="text-primary font-bold text-lg block">
                <?= e($leader['name']) ?>
              </strong>
              <span class="text-accent font-bold text-sm block">
                <?= e($leader['designation']) ?>
              </span>
              <span class="text-muted text-xs block">
                Kashmir College of Engineering &amp; Technology, Srinagar
              </span>
            </div>

            <div class="d-flex gap-2">
              <a href="javascript:window.print()" class="btn btn-outline text-xs py-2 px-3">
                <i class="fa-solid fa-print me-1"></i> Print Communiqué
              </a>
            </div>
          </div>
        </div>

        <!-- Next Actions Row -->
        <div class="leader-action-grid">
          <div class="leader-action-card">
            <h4 class="text-primary font-bold text-base mb-2">
              B.Tech Degree Catalog
            </h4>
            <p class="text-muted text-sm leading-relaxed mb-3">
              Explore the five approved 4-Year B.Tech disciplines offered at KCET.
            </p>
            <a href="<?= url('/programmes') ?>" class="text-primary font-bold text-sm no-underline">
              View Programmes &rarr;
            </a>
          </div>

          <div class="leader-action-card">
            <h4 class="text-primary font-bold text-base mb-2">
              Campus Infrastructure
            </h4>
            <p class="text-muted text-sm leading-relaxed mb-3">
              Discover our 18+ laboratory suites, NVIDIA AI lab, library, and 100+ kanal green campus.
            </p>
            <a href="<?= url('/facilities') ?>" class="text-primary font-bold text-sm no-underline">
              Explore Facilities &rarr;
            </a>
          </div>

          <div class="leader-action-card">
            <h4 class="text-primary font-bold text-base mb-2">
              Faculty Directory
            </h4>
            <p class="text-muted text-sm leading-relaxed mb-3">
              Meet our professors, assistant professors, and lab engineers across all departments.
            </p>
            <a href="<?= url('/faculty') ?>" class="text-primary font-bold text-sm no-underline">
              Meet Our Faculty &rarr;
            </a>
          </div>
        </div>

      </main>
    </div>
  </div>
</section>