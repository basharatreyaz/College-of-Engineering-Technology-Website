<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($pageTitle ?? 'Admin Authentication | KCET') ?></title>
  
  <!-- Bunny Fonts: Outfit Family -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= asset('assets/css/fontawesome.min.css') ?>">

  <link rel="stylesheet" href="<?= asset('assets/css/style.css') ?>">
  <link rel="stylesheet" href="<?= asset('assets/css/admin.css') ?>">
</head>
<body class="auth-page">
  <div class="auth-card">
    <div class="auth-brand">
      <img src="<?= asset('assets/images/kcet-logo-header.png') ?>" alt="KCET Official Logo" class="auth-logo">
      <h1>KCET Staff Portal</h1>
      <p>Kashmir College of Engineering & Technology</p>
    </div>

    <?php \App\Services\View::component('alert'); ?>

    <?= $content ?? '' ?>
  </div>
</body>
</html>
