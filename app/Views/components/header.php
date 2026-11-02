<?php
/**
 * Kashmir College of Engineering & Technology (KCET)
 * Premier Collegiate Academic Header Component (Streamlined)
 */
$collegeName = setting('college_name', 'Kashmir College of Engineering & Technology');
$shortName = setting('college_short_name', 'KCET');
$phonePrimary = setting('phone_primary', '+91 88994 12793');
$emailPrimary = setting('email_primary', 'info@kcet.edu.in');
$currentUri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
?>

<!-- Tier 1: Top Statutory & Affiliation Bar -->
<div class="top-bar" role="region" aria-label="Official Affiliation & Statutory Helpline">
  <div class="container top-bar-content">
    <div class="top-bar-affiliation">
      <span class="affiliation-badge">AICTE Approved</span>
      <span>Affiliated to University of Kashmir</span>
      <span class="top-sep">|</span>
      <span>College Code: <strong>KCET</strong></span>
      <span class="top-sep">|</span>
      <span>Ranbirgarh, Srinagar</span>
    </div>
    <div class="top-bar-links">
      <a href="tel:18001805522" class="top-link-helpline" title="National Anti-Ragging Toll-Free Helpline">
        <i class="fa-solid fa-shield-halved"></i>
        <span>Anti-Ragging Helpline: <strong>1800-180-5522</strong> (24x7 Toll Free)</span>
      </a>
      <span class="top-sep">|</span>
      <a href="<?= url('/admin') ?>" class="top-link-staff">
        <i class="fa-solid fa-user-lock"></i>
        Staff Portal
      </a>
    </div>
  </div>
</div>

<!-- Tier 2: Collegiate Institutional Masthead -->
<div class="masthead" role="banner">
  <div class="container masthead-inner">
    <div class="masthead-brand">
      <a href="<?= url('/') ?>" class="masthead-logo-link" aria-label="<?= e($collegeName) ?>">
        <img src="<?= asset('assets/images/kcet-logo-header.png') ?>" alt="<?= e($collegeName) ?>" class="masthead-logo-img">
      </a>
      <div class="masthead-affiliation-block">
        <div class="masthead-urdu" lang="ur" dir="rtl">كشمير كالج آف انجنيرنک اينڈ ٹيکنالوجى</div>
        <p class="masthead-subtitle">
          Approved by AICTE, New Delhi &bull; Affiliated to University of Kashmir
        </p>
        <div class="masthead-meta">
          <span>Estd. 2002</span>
          <span>&bull;</span>
          <span>Ranbirgarh, Srinagar, Jammu &amp; Kashmir &ndash; 190001</span>
        </div>
      </div>
    </div>

    <!-- Masthead Right: Admissions Hotline & Prominent Apply Button -->
    <div class="masthead-actions">
      <div class="masthead-helpline">
        <div class="masthead-helpline-icon">
          <i class="fa-solid fa-headset"></i>
        </div>
        <div class="masthead-helpline-text">
          <span class="helpline-label">Admissions Hotline</span>
          <a href="tel:<?= preg_replace('/\s+/', '', $phonePrimary) ?>" class="helpline-number"><?= e($phonePrimary) ?></a>
        </div>
      </div>
      <a href="<?= url('/apply') ?>" class="btn-masthead-apply" title="Apply Online for B.Tech Admissions 2026-27">
        <i class="fa-solid fa-file-signature"></i>
        <span>Apply Online 2026-27</span>
      </a>
    </div>
  </div>
</div>

<!-- Tier 3: Primary Academic Navigation Bar -->
<header class="site-header" role="navigation" aria-label="Main Navigation">
  <div class="container nav-container">
    <nav class="desktop-nav">
      <ul class="nav-list">
        <li class="nav-item">
          <a href="<?= url('/') ?>" class="nav-link <?= $currentUri === '/' ? 'active' : '' ?>">Home</a>
        </li>

        <li class="nav-item has-dropdown">
          <a href="<?= url('/about') ?>" class="nav-link <?= (str_starts_with($currentUri, '/about') || str_contains($currentUri, 'message') || str_starts_with($currentUri, '/leadership')) ? 'active' : '' ?>">
            About Us
            <i class="fa-solid fa-chevron-down dropdown-caret"></i>
          </a>
          <ul class="dropdown-menu">
            <li class="dropdown-item"><a href="<?= url('/about') ?>">Institutional Genesis &amp; Profile</a></li>
            <li class="dropdown-item"><a href="<?= url('/about#vision-mission') ?>">Vision, Mission &amp; Values</a></li>
            <li class="dropdown-item"><a href="<?= url('/chairmans-message') ?>">Chairman's Message</a></li>
            <li class="dropdown-item"><a href="<?= url('/directors-message') ?>">Director's Message</a></li>
            <li class="dropdown-item"><a href="<?= url('/principals-message') ?>">Principal's Desk Message</a></li>
            <li class="dropdown-item"><a href="<?= url('/about#governing-body') ?>">Statutory Committees &amp; Cells</a></li>
          </ul>
        </li>

        <li class="nav-item has-dropdown">
          <a href="<?= url('/programmes') ?>" class="nav-link <?= (str_starts_with($currentUri, '/programmes') || str_starts_with($currentUri, '/departments') || str_starts_with($currentUri, '/faculty')) ? 'active' : '' ?>">
            Academics
            <i class="fa-solid fa-chevron-down dropdown-caret"></i>
          </a>
          <ul class="dropdown-menu">
            <li class="dropdown-item"><a href="<?= url('/programmes') ?>">All 4-Year B.Tech Programmes</a></li>
            <li class="dropdown-item"><a href="<?= url('/departments') ?>">Academic Departments</a></li>
            <li class="dropdown-item"><a href="<?= url('/faculty') ?>">Faculty Directory</a></li>
            <li class="dropdown-item"><a href="<?= url('/syllabus') ?>">B.Tech Syllabus &amp; Curricula</a></li>
            <li class="dropdown-item"><a href="<?= url('/downloads') ?>">Downloads, Prospectus &amp; Forms</a></li>
          </ul>
        </li>

        <li class="nav-item has-dropdown">
          <a href="<?= url('/admissions') ?>" class="nav-link <?= (str_starts_with($currentUri, '/admissions') || str_starts_with($currentUri, '/apply')) ? 'active' : '' ?>">
            Admissions
            <i class="fa-solid fa-chevron-down dropdown-caret"></i>
          </a>
          <ul class="dropdown-menu">
            <li class="dropdown-item"><a href="<?= url('/admissions') ?>">Admission Guidelines 2026-27</a></li>
            <li class="dropdown-item"><a href="<?= url('/admissions#eligibility') ?>">Eligibility &amp; Seat Matrix</a></li>
            <li class="dropdown-item"><a href="<?= url('/admissions#lateral-entry') ?>">Lateral Entry (3rd Sem)</a></li>
            <li class="dropdown-item"><a href="<?= url('/apply') ?>" class="font-bold text-accent">Apply Online 2026-27</a></li>
          </ul>
        </li>

        <li class="nav-item has-dropdown">
          <a href="<?= url('/facilities') ?>" class="nav-link <?= (str_starts_with($currentUri, '/facilities') || str_starts_with($currentUri, '/campus-life') || str_starts_with($currentUri, '/events')) ? 'active' : '' ?>">
            Campus Life
            <i class="fa-solid fa-chevron-down dropdown-caret"></i>
          </a>
          <ul class="dropdown-menu">
            <li class="dropdown-item"><a href="<?= url('/facilities') ?>">Campus Facilities &amp; Labs</a></li>
            <li class="dropdown-item"><a href="<?= url('/campus-life') ?>">Campus Gallery &amp; Culture</a></li>
            <li class="dropdown-item"><a href="<?= url('/events') ?>">Academic Events &amp; Workshops</a></li>
            <li class="dropdown-item"><a href="<?= url('/careers') ?>">Careers at KCET</a></li>
          </ul>
        </li>

        <li class="nav-item">
          <a href="<?= url('/notices') ?>" class="nav-link <?= str_starts_with($currentUri, '/notices') ? 'active' : '' ?>">Notice Board</a>
        </li>

        <li class="nav-item">
          <a href="<?= url('/contact') ?>" class="nav-link <?= str_starts_with($currentUri, '/contact') ? 'active' : '' ?>">Contact</a>
        </li>
      </ul>
    </nav>

    <!-- Header Right Actions: Quick Search & Mobile Drawer Trigger -->
    <div class="nav-right-actions">
      <button type="button" class="btn-search-trigger" onclick="openSearchModal()" aria-label="Search KCET website" title="Search website (Ctrl+K)">
        <i class="fa-solid fa-magnifying-glass"></i>
        <span class="search-label inline-block">Search</span>
        <span class="search-key-hint">Ctrl K</span>
      </button>

      <button type="button" class="mobile-nav-toggle" aria-label="Toggle navigation menu" aria-expanded="false" aria-controls="mobileDrawer">
        <i class="fa-solid fa-bars text-xl"></i>
      </button>
    </div>
  </div>
</header>

<!-- Mobile Navigation Drawer -->
<div class="drawer-backdrop"></div>
<aside id="mobileDrawer" class="mobile-drawer" aria-hidden="true">
  <div class="drawer-header">
    <div class="drawer-brand">
      <img src="<?= asset('assets/images/kcet-emblem-official.png') ?>" alt="KCET Official Emblem" width="44" height="44" class="object-contain">
      <div>
        <div class="drawer-brand-urdu">كشمير كالج</div>
        <strong class="drawer-brand-title">KCET Srinagar</strong>
      </div>
    </div>
    <button type="button" class="drawer-close" aria-label="Close menu"><i class="fa-solid fa-xmark"></i></button>
  </div>
  <nav class="drawer-nav">
    <ul class="drawer-list">
      <li class="drawer-item"><a href="<?= url('/') ?>">Home</a></li>
      <li class="drawer-item"><a href="<?= url('/about') ?>">About KCET</a></li>
      <li class="drawer-item"><a href="<?= url('/chairmans-message') ?>">Chairman's Message</a></li>
      <li class="drawer-item"><a href="<?= url('/directors-message') ?>">Director's Message</a></li>
      <li class="drawer-item"><a href="<?= url('/principals-message') ?>">Principal's Message</a></li>
      <li class="drawer-item"><a href="<?= url('/programmes') ?>">B.Tech Programmes</a></li>
      <li class="drawer-item"><a href="<?= url('/departments') ?>">Departments</a></li>
      <li class="drawer-item"><a href="<?= url('/faculty') ?>">Faculty Directory</a></li>
      <li class="drawer-item"><a href="<?= url('/syllabus') ?>">B.Tech Syllabus &amp; Curricula</a></li>
      <li class="drawer-item"><a href="<?= url('/downloads') ?>">Downloads &amp; Forms</a></li>
      <li class="drawer-item"><a href="<?= url('/admissions') ?>">Admissions 2026-27</a></li>
      <li class="drawer-item"><a href="<?= url('/facilities') ?>">Campus Facilities</a></li>
      <li class="drawer-item"><a href="<?= url('/campus-life') ?>">Campus Life &amp; Gallery</a></li>
      <li class="drawer-item"><a href="<?= url('/notices') ?>">Notice Board &amp; Circulars</a></li>
      <li class="drawer-item"><a href="<?= url('/contact') ?>">Contact Us</a></li>
    </ul>
  </nav>
  <div class="drawer-actions">
    <a href="<?= url('/apply') ?>" class="btn btn-accent btn-lg w-full">Apply Online 2026-27</a>
  </div>
</aside>
