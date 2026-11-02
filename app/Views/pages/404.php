<?php
/**
 * 404 Not Found Page View
 */
?>

<div class="page-hero text-center py-5" style="background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);">
  <div class="container page-hero-inner">
    <span class="error-code-badge">404</span>
    <h1 class="page-hero-title">Page Not Found</h1>
    <p class="page-hero-desc mx-auto max-w-xl mb-4">
      The page or resource you are looking for may have been moved, renamed, or is temporarily unavailable.
    </p>
    <div class="d-flex justify-center gap-3 flex-wrap">
      <a href="<?= url('/') ?>" class="btn btn-accent btn-lg">Return to KCET Homepage</a>
      <a href="<?= url('/programmes') ?>" class="btn btn-white btn-lg">Browse Programmes</a>
      <button type="button" class="btn btn-outline btn-lg text-white border-white" onclick="openSearchModal()"><i class="fa-solid fa-magnifying-glass me-2"></i> Search Website</button>
    </div>
  </div>
</div>

<section class="section">
  <div class="container max-w-2xl text-center">
    <h2 class="text-primary font-bold text-xl mb-3">Looking for Something Specific?</h2>
    <div class="error-grid">
      <a href="<?= url('/admissions') ?>" class="error-quick-link">
        &bull; Admissions Guide &rarr;
      </a>
      <a href="<?= url('/departments') ?>" class="error-quick-link">
        &bull; Academic Departments &rarr;
      </a>
      <a href="<?= url('/notices') ?>" class="error-quick-link">
        &bull; Official Notices &rarr;
      </a>
      <a href="<?= url('/contact') ?>" class="error-quick-link">
        &bull; Contact Office &rarr;
      </a>
    </div>
  </div>
</section>
