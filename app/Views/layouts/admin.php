<?php
$user = auth_user();
$currentUri = parse_url($_SERVER['REQUEST_URI'] ?? '/admin', PHP_URL_PATH);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($pageTitle ?? 'Admin Portal | KCET') ?></title>
  
  <!-- Official Favicon -->
  <link rel="icon" type="image/png" href="<?= asset('favicon.png') ?>">
  <link rel="alternate icon" href="<?= url('/favicon.ico') ?>">
  
  <!-- Bunny Fonts: Outfit Family -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= asset('assets/css/fontawesome.min.css') ?>">

  <link rel="stylesheet" href="<?= asset('assets/css/style.css') ?>">
  <link rel="stylesheet" href="<?= asset('assets/css/admin.css') ?>">
</head>
<body class="admin-body">

  <!-- Admin Sidebar -->
  <aside class="admin-sidebar" role="navigation">
    <div class="admin-sidebar-brand">
      <img src="<?= asset('assets/images/kcet-emblem-official.png') ?>" alt="KCET Emblem" width="40" height="40" class="admin-brand-emblem">
      <div>
        <h2>KCET Portal</h2>
        <span>College Administration</span>
      </div>
    </div>

    <ul class="admin-sidebar-menu">
      <li class="admin-menu-header">Overview</li>
      <li class="admin-menu-item <?= $currentUri === '/admin' ? 'active' : '' ?>">
        <a href="<?= url('/admin') ?>">
          <span class="admin-menu-icon"><i class="fa-solid fa-chart-line"></i></span>
          <span>Dashboard</span>
        </a>
      </li>

      <li class="admin-menu-header">Academic Modules</li>
      <li class="admin-menu-item <?= str_contains($currentUri, '/admin/programmes') ? 'active' : '' ?>">
        <a href="<?= url('/admin/programmes') ?>">
          <span class="admin-menu-icon"><i class="fa-solid fa-graduation-cap"></i></span>
          <span>Programmes</span>
        </a>
      </li>
      <li class="admin-menu-item <?= str_contains($currentUri, '/admin/departments') ? 'active' : '' ?>">
        <a href="<?= url('/admin/departments') ?>">
          <span class="admin-menu-icon"><i class="fa-solid fa-building-columns"></i></span>
          <span>Departments</span>
        </a>
      </li>
      <li class="admin-menu-item <?= str_contains($currentUri, '/admin/faculty') ? 'active' : '' ?>">
        <a href="<?= url('/admin/faculty') ?>">
          <span class="admin-menu-icon"><i class="fa-solid fa-chalkboard-user"></i></span>
          <span>Faculty &amp; Staff</span>
        </a>
      </li>
      <li class="admin-menu-item <?= str_contains($currentUri, '/admin/leadership') ? 'active' : '' ?>">
        <a href="<?= url('/admin/leadership') ?>">
          <span class="admin-menu-icon"><i class="fa-solid fa-user-tie"></i></span>
          <span>Leadership Messages</span>
        </a>
      </li>
      <li class="admin-menu-item <?= str_contains($currentUri, '/admin/facilities') ? 'active' : '' ?>">
        <a href="<?= url('/admin/facilities') ?>">
          <span class="admin-menu-icon"><i class="fa-solid fa-flask-vial"></i></span>
          <span>Facilities</span>
        </a>
      </li>
      <li class="admin-menu-item <?= str_contains($currentUri, '/admin/downloads') ? 'active' : '' ?>">
        <a href="<?= url('/admin/downloads') ?>">
          <span class="admin-menu-icon"><i class="fa-solid fa-file-arrow-down"></i></span>
          <span>Downloads / Syllabus</span>
        </a>
      </li>

      <li class="admin-menu-header">Student Submissions</li>
      <li class="admin-menu-item <?= str_contains($currentUri, '/admin/enquiries') ? 'active' : '' ?>">
        <a href="<?= url('/admin/enquiries') ?>">
          <span class="admin-menu-icon"><i class="fa-solid fa-inbox"></i></span>
          <span>Enquiries</span>
        </a>
      </li>
      <li class="admin-menu-item <?= str_contains($currentUri, '/admin/applications') ? 'active' : '' ?>">
        <a href="<?= url('/admin/applications') ?>">
          <span class="admin-menu-icon"><i class="fa-solid fa-file-signature"></i></span>
          <span>Applications</span>
        </a>
      </li>

      <li class="admin-menu-header">News & Media</li>
      <li class="admin-menu-item <?= str_contains($currentUri, '/admin/notices') ? 'active' : '' ?>">
        <a href="<?= url('/admin/notices') ?>">
          <span class="admin-menu-icon"><i class="fa-solid fa-bullhorn"></i></span>
          <span>Notices &amp; News</span>
        </a>
      </li>
      <li class="admin-menu-item <?= str_contains($currentUri, '/admin/events') ? 'active' : '' ?>">
        <a href="<?= url('/admin/events') ?>">
          <span class="admin-menu-icon"><i class="fa-solid fa-calendar-days"></i></span>
          <span>Events &amp; Stories</span>
        </a>
      </li>
      <li class="admin-menu-item <?= str_contains($currentUri, '/admin/gallery') ? 'active' : '' ?>">
        <a href="<?= url('/admin/gallery') ?>">
          <span class="admin-menu-icon"><i class="fa-solid fa-images"></i></span>
          <span>Campus Gallery</span>
        </a>
      </li>
      <li class="admin-menu-item <?= str_contains($currentUri, '/admin/faqs') ? 'active' : '' ?>">
        <a href="<?= url('/admin/faqs') ?>">
          <span class="admin-menu-icon"><i class="fa-solid fa-circle-question"></i></span>
          <span>FAQs</span>
        </a>
      </li>

      <li class="admin-menu-header">System</li>
      <li class="admin-menu-item <?= str_contains($currentUri, '/admin/settings') ? 'active' : '' ?>">
        <a href="<?= url('/admin/settings') ?>">
          <span class="admin-menu-icon"><i class="fa-solid fa-sliders"></i></span>
          <span>Site Settings</span>
        </a>
      </li>
      <li class="admin-menu-item <?= str_contains($currentUri, '/admin/audit-logs') ? 'active' : '' ?>">
        <a href="<?= url('/admin/audit-logs') ?>">
          <span class="admin-menu-icon"><i class="fa-solid fa-clock-rotate-left"></i></span>
          <span>Audit Trail</span>
        </a>
      </li>
      <?php if (has_role('superadmin')): ?>
      <li class="admin-menu-item <?= str_contains($currentUri, '/admin/users') ? 'active' : '' ?>">
        <a href="<?= url('/admin/users') ?>">
          <span class="admin-menu-icon"><i class="fa-solid fa-users-gear"></i></span>
          <span>Admin Users</span>
        </a>
      </li>
      <?php endif; ?>
    </ul>
  </aside>

  <!-- Admin Main Content Area -->
  <div class="admin-main">
    <header class="admin-topbar">
      <button type="button" class="admin-toggle-btn" aria-label="Toggle admin sidebar">
        <i class="fa-solid fa-bars"></i>
      </button>

      <div>
        <a href="<?= url('/') ?>" target="_blank" class="btn btn-outline btn-sm">
          <i class="fa-solid fa-arrow-left role-icon-mr"></i>
          <span>View Public Website</span>
        </a>
      </div>

      <div class="admin-topbar-right">
        <div class="admin-user-profile">
          <div class="admin-avatar">
            <?= strtoupper(substr($user['name'] ?? 'A', 0, 1)) ?>
          </div>
          <div class="admin-user-info">
            <span class="admin-user-name"><?= e($user['name'] ?? 'Admin') ?></span>
            <span class="admin-user-role"><?= e($user['role'] ?? 'Editor') ?></span>
          </div>
        </div>

        <a href="<?= url('/admin/logout') ?>" class="btn btn-outline btn-sm btn-delete">
          <i class="fa-solid fa-arrow-right-from-bracket role-icon-mr"></i>
          Logout
        </a>
      </div>
    </header>

    <main class="admin-content" role="main">
      <?php \App\Services\View::component('alert'); ?>
      <?= $content ?? '' ?>
    </main>
  </div>

  <script src="<?= asset('assets/js/admin.js') ?>" defer></script>
</body>
</html>
