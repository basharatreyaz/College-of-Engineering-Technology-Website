<?php
/**
 * Single Department Detail View
 */
?>

<!-- Header -->
<div class="page-hero" style="background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);">
  <div class="container page-hero-inner">
    <span class="page-hero-badge">
      Department Code: <?= e($department['code']) ?>
    </span>
    <h1 class="page-hero-title"><?= e($department['name']) ?></h1>
    <p class="page-hero-desc">
      <?= truncate($department['overview'] ?? '', 180) ?>
    </p>
  </div>
</div>

<section class="section">
  <div class="container">
    <div class="detail-layout-grid">
      <!-- Main Content -->
      <div>
        <!-- Overview -->
        <div class="mb-5">
          <h2 class="text-primary font-bold text-2xl mb-3">About the Department</h2>
          <div class="text-muted text-base leading-relaxed">
            <?= nl2br(e($department['overview'])) ?>
          </div>
        </div>

        <!-- Vision & Mission -->
        <div class="dept-pillars-grid">
          <div class="card p-4 shadow-sm border-top-primary">
            <h3 class="text-primary font-bold text-lg mb-2">Department Vision</h3>
            <p class="text-muted text-sm leading-relaxed m-0">
              <?= nl2br(e($department['vision'] ?? 'To lead in engineering education and research.')) ?>
            </p>
          </div>
          <div class="card p-4 shadow-sm border-top-secondary">
            <h3 class="text-primary font-bold text-lg mb-2">Department Mission</h3>
            <p class="text-muted text-sm leading-relaxed m-0">
              <?= nl2br(e($department['mission'] ?? 'To empower students through practical knowledge and ethics.')) ?>
            </p>
          </div>
        </div>

        <!-- Labs & Research Infrastructure -->
        <?php if (!empty($department['labs_info'])): ?>
        <div class="card bg-subtle p-4 mb-5">
          <h3 class="text-primary font-bold text-xl mb-2">Laboratories & Research Infrastructure</h3>
          <p class="text-muted text-base leading-relaxed m-0">
            <?= nl2br(e($department['labs_info'])) ?>
          </p>
        </div>
        <?php endif; ?>

        <!-- Associated Programmes -->
        <?php if (!empty($programmes)): ?>
        <div class="mb-5">
          <h3 class="text-primary font-bold text-xl mb-3">Programmes Offered by Department</h3>
          <div class="d-flex flex-col gap-3">
            <?php foreach ($programmes as $prog): ?>
            <div class="dept-prog-card">
              <div>
                <span class="text-secondary text-xs font-bold text-uppercase"><?= e($prog['degree_type']) ?> &bull; <?= e($prog['duration']) ?></span>
                <h4 class="text-primary font-bold text-lg mt-1 m-0"><?= e($prog['name']) ?></h4>
              </div>
              <div class="d-flex gap-2">
                <a href="<?= url('/programmes/' . $prog['slug']) ?>" class="btn btn-outline btn-sm">View Details</a>
                <a href="<?= url('/apply') ?>" class="btn btn-accent btn-sm">Apply</a>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>

        <!-- Department Faculty -->
        <?php if (!empty($facultyMembers)): ?>
        <div>
          <h3 class="text-primary font-bold text-xl mb-3">Department Faculty</h3>
          <div class="dept-faculty-grid">
            <?php foreach ($facultyMembers as $f): ?>
            <div class="dept-faculty-card">
              <?php if (!empty($f['photo']) && file_exists(ROOT_PATH . '/public/' . ltrim($f['photo'], '/'))): ?>
                <img src="<?= asset($f['photo']) ?>" alt="<?= e($f['name']) ?>" width="48" height="48" class="dept-faculty-avatar">
              <?php else: ?>
                <div class="dept-faculty-avatar--fallback">
                  <?= strtoupper(substr($f['name'], 0, 1)) ?>
                </div>
              <?php endif; ?>
              <div>
                <h4 class="text-primary font-bold text-base mb-1"><?= e($f['name']) ?></h4>
                <p class="text-secondary font-semibold text-sm mb-1"><?= e($f['designation']) ?></p>
                <p class="text-muted text-xs m-0"><?= e($f['qualification']) ?></p>
                <?php if (!empty($f['specialization'])): ?>
                  <p class="text-muted text-xs mt-1 m-0">Spec: <?= e($f['specialization']) ?></p>
                <?php endif; ?>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>
      </div>

      <!-- Sidebar -->
      <aside>
        <!-- HOD Message Card -->
        <?php if (!empty($department['hod_name'])): ?>
        <div class="hod-card">
          <div class="d-flex align-items-center gap-3 mb-3">
            <?php if (!empty($department['hod_photo']) && file_exists(ROOT_PATH . '/public/' . ltrim($department['hod_photo'], '/'))): ?>
              <img src="<?= asset($department['hod_photo']) ?>" alt="<?= e($department['hod_name']) ?>" width="52" height="52" class="hod-avatar">
            <?php else: ?>
              <div class="hod-avatar--fallback">
                <?= strtoupper(substr($department['hod_name'], 0, 1)) ?>
              </div>
            <?php endif; ?>
            <div>
              <h4 class="text-primary font-bold text-base mb-0"><?= e($department['hod_name']) ?></h4>
              <span class="text-secondary font-semibold text-xs"><?= e($department['hod_designation'] ?: 'Head of Department') ?></span>
            </div>
          </div>
          <?php if (!empty($department['hod_message'])): ?>
          <blockquote class="hod-quote">
            "<?= e($department['hod_message']) ?>"
          </blockquote>
          <?php endif; ?>
          <button type="button" class="btn btn-outline btn-sm w-full" data-open-enquiry-modal>Connect with Department</button>
        </div>
        <?php endif; ?>

        <!-- Quick Links Card -->
        <div class="sidebar-nav-card">
          <h4 class="text-primary font-bold text-base mb-3">Quick Resources</h4>
          <ul class="d-flex flex-col gap-2 p-0 m-0 list-none text-sm">
            <li><a href="<?= url('/syllabus/' . $department['slug']) ?>" class="text-primary font-semibold no-underline">&bull; Department Syllabus &amp; Curricula</a></li>
            <li><a href="<?= url('/faculty?dept=' . $department['id']) ?>" class="text-primary font-semibold no-underline">&bull; View All Department Faculty</a></li>
            <li><a href="<?= url('/apply') ?>" class="text-primary font-semibold no-underline">&bull; Apply for Admission</a></li>
            <li><a href="<?= url('/facilities') ?>" class="text-primary font-semibold no-underline">&bull; Campus Laboratories Tour</a></li>
          </ul>
        </div>
      </aside>
    </div>
  </div>
</section>
