<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($pageTitle ?? 'Kashmir College of Engineering & Technology | KCET') ?></title>
  <meta name="description" content="<?= e($metaDescription ?? 'Official website of Kashmir College of Engineering & Technology (KCET), Srinagar. Premier B.Tech engineering programmes in AI, Computer, Civil, IT, and ECE.') ?>">
  <link rel="canonical" href="<?= htmlspecialchars(env('APP_URL', 'https://kcet.edu.in') . parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH)) ?>">

  <!-- Official Favicon & Touch Icons -->
  <link rel="icon" type="image/png" href="<?= asset('favicon.png') ?>">
  <link rel="shortcut icon" href="<?= url('/favicon.ico') ?>">
  <link rel="apple-touch-icon" href="<?= asset('assets/images/kcet-emblem-official.png') ?>">

  <!-- Open Graph / Social Sharing -->
  <meta property="og:type" content="website">
  <meta property="og:title" content="<?= e($pageTitle ?? 'Kashmir College of Engineering & Technology') ?>">
  <meta property="og:description" content="<?= e($metaDescription ?? 'Premier B.Tech engineering programmes in Kashmir.') ?>">
  <meta property="og:url" content="<?= htmlspecialchars(env('APP_URL', 'https://kcet.edu.in') . parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH)) ?>">
  <meta property="og:site_name" content="KCET Srinagar">
  <meta property="og:image" content="<?= asset('assets/images/campus-panoramic.jpg') ?>">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">

  <!-- Twitter / X Cards -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?= e($pageTitle ?? 'Kashmir College of Engineering & Technology | KCET') ?>">
  <meta name="twitter:description" content="<?= e($metaDescription ?? 'Official website of Kashmir College of Engineering & Technology (KCET), Srinagar.') ?>">
  <meta name="twitter:image" content="<?= asset('assets/images/campus-panoramic.jpg') ?>">

  <!-- Schema.org JSON-LD Structured Data for University / College -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "CollegeOrUniversity",
    "name": "Kashmir College of Engineering & Technology",
    "alternateName": ["KCET", "KCET Srinagar"],
    "url": "https://kcet.edu.in",
    "logo": "<?= asset('assets/images/kcet-logo-official.png') ?>",
    "image": "<?= asset('assets/images/campus-panoramic.jpg') ?>",
    "description": "Premier higher technical education institution in Jammu & Kashmir offering accredited 4-Year B.Tech programmes in Artificial Intelligence, Computer Engineering, Civil Engineering, IT, and ECE.",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "Ranbirgarh",
      "addressLocality": "Srinagar",
      "addressRegion": "Jammu and Kashmir",
      "postalCode": "190001",
      "addressCountry": "IN"
    },
    "telephone": "+91-88994-12793",
    "email": "info@kcet.edu.in",
    "foundingDate": "2002"
  }
  </script>

  <!-- Bunny Fonts: Outfit Family -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= asset('assets/css/fontawesome.min.css') ?>">

  <!-- Core Stylesheets -->
  <link rel="stylesheet" href="<?= asset('assets/css/style.css') ?>">
  <link rel="stylesheet" href="<?= asset('assets/css/responsive.css') ?>">
</head>
<body>
  <!-- Accessibility Skip Navigation -->
  <a href="#mainContent" class="skip-link">Skip to main content</a>

  <!-- Site Header -->
  <?php \App\Services\View::component('header'); ?>

  <!-- Global Flash Alerts (conditionally rendered) -->
  <?php \App\Services\View::component('alert'); ?>

  <!-- Main Content Body -->
  <main id="mainContent" role="main">
    <?= $content ?? '' ?>
  </main>

  <!-- Admission Announcement Modal -->
  <?php \App\Services\View::component('admission-modal'); ?>

  <!-- Quick Enquiry Modal -->
  <?php \App\Services\View::component('enquiry-modal'); ?>

  <!-- Spotlight Quick Search Modal -->
  <?php \App\Services\View::component('search-modal'); ?>

  <!-- Floating Helpdesk & Back to Top Actions -->
  <?php \App\Services\View::component('floating-actions'); ?>

  <!-- Site Footer -->
  <?php \App\Services\View::component('footer'); ?>

  <!-- Core Scripts -->
  <script src="<?= asset('assets/js/main.js') ?>" defer></script>
  <script src="<?= asset('assets/js/forms.js') ?>" defer></script>
</body>
</html>

