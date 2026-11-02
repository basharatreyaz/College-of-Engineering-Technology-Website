<?php
/**
 * Notices Catalog View
 */
?>

<!-- Header -->
<div class="page-hero" style="background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);">
  <div class="container page-hero-inner">
    <span class="page-hero-badge">
      Official Communication
    </span>
    <h1 class="page-hero-title">Notices & Announcements</h1>
    <p class="page-hero-desc">
      Official administrative circulars, admission announcements, examination schedules, and recruitment updates from KCET Srinagar.
    </p>
  </div>
</div>

<section class="section">
  <div class="container">
    <!-- Search & Filter Controls -->
    <div class="card p-3 mb-4 shadow-sm">
      <form action="<?= url('/notices') ?>" method="GET" class="d-flex flex-wrap gap-3 align-items-center justify-content-between">
        <div class="filter-field-search">
          <input type="text" name="q" value="<?= e($searchQuery ?? '') ?>" class="form-control" placeholder="Search notices by title or keywords...">
        </div>
        <div class="filter-field-select">
          <select name="cat" class="form-control" onchange="this.form.submit()">
            <option value="all" <?= ($selectedCategory === 'all') ? 'selected' : '' ?>>All Categories</option>
            <option value="admissions" <?= ($selectedCategory === 'admissions') ? 'selected' : '' ?>>Admissions</option>
            <option value="academics" <?= ($selectedCategory === 'academics') ? 'selected' : '' ?>>Academics</option>
            <option value="examinations" <?= ($selectedCategory === 'examinations') ? 'selected' : '' ?>>Examinations</option>
            <option value="recruitment" <?= ($selectedCategory === 'recruitment') ? 'selected' : '' ?>>Recruitment</option>
            <option value="general" <?= ($selectedCategory === 'general') ? 'selected' : '' ?>>General Circulars</option>
          </select>
        </div>
        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary btn-sm">Filter</button>
          <?php if (!empty($searchQuery) || ($selectedCategory !== 'all' && !empty($selectedCategory))): ?>
            <a href="<?= url('/notices') ?>" class="btn btn-outline btn-sm">Clear</a>
          <?php endif; ?>
        </div>
      </form>
    </div>

    <!-- Notices List -->
    <?php if (empty($notices)): ?>
      <div class="faculty-empty-state">
        <p class="text-muted text-lg mb-3">No notices currently found matching your query.</p>
        <a href="<?= url('/notices') ?>" class="btn btn-primary">View All Notices</a>
      </div>
    <?php else: ?>
      <div class="d-flex flex-col gap-3">
        <?php foreach ($notices as $notice): ?>
        <article class="notice-archive-card">
          <div class="notice-content-col">
            <div class="d-flex align-items-center gap-2 mb-1">
              <span class="badge badge-info"><?= strtoupper(e($notice['category'])) ?></span>
              <time datetime="<?= e($notice['publish_date']) ?>" class="text-muted text-xs">
                Published on <?= format_date($notice['publish_date']) ?>
              </time>
              <?php if ((int)$notice['is_featured'] === 1): ?>
                <span class="text-accent text-xs font-bold"><i class="fa-solid fa-star"></i> Featured</span>
              <?php endif; ?>
            </div>

            <h2 class="text-primary font-bold text-lg leading-snug mb-2">
              <a href="<?= url('/notices/' . $notice['slug']) ?>" class="text-primary no-underline"><?= e($notice['title']) ?></a>
            </h2>

            <p class="text-muted text-sm leading-relaxed m-0">
              <?= e($notice['summary']) ?>
            </p>
          </div>

          <div class="d-flex align-items-center gap-2 flex-shrink-0">
            <a href="<?= url('/notices/' . $notice['slug']) ?>" class="btn btn-outline btn-sm">Read Notice</a>
            <?php if (!empty($notice['attachment_file'])): ?>
              <a href="<?= asset($notice['attachment_file']) ?>" download class="btn btn-primary btn-sm"><i class="fa-solid fa-download me-1"></i> Download Attachment</a>
            <?php endif; ?>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
