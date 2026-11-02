<?php
/**
 * Terms of Use Page View
 */
$collegeName = setting('college_name', 'Kashmir College of Engineering & Technology');
?>

<!-- Header -->
<div class="page-hero" style="background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);">
  <div class="container page-hero-inner">
    <h1 class="page-hero-title">Terms of Use</h1>
    <p class="page-hero-desc">
      General conditions governing usage of the <?= e($collegeName) ?> web portal.
    </p>
  </div>
</div>

<section class="section">
  <div class="container max-w-4xl">
    <div class="legal-content-card">
      <h2>1. Acceptance of Terms</h2>
      <p>
        By browsing and utilizing this website, you agree to comply with these terms of use. The contents of this portal are intended to provide institutional information, course curricula, and digital admission applications for <?= e($collegeName) ?>.
      </p>

      <h2>2. Accuracy of Institutional Information</h2>
      <p>
        While KCET strives to ensure all published notices, curricula, and schedules are accurate and up to date, academic guidelines, fee schedules, and regulatory notifications are subject to statutory updates by the University of Kashmir and state higher-education authorities. Official confirmation is verified directly at the college admissions office.
      </p>

      <h2>3. Online Application Submissions</h2>
      <p>
        Submitting an online registration form registers your candidature for counselling and admission consideration. Final admission is granted only upon in-person verification of original certificates, fulfillment of statutory eligibility criteria, and settlement of prescribed term dues.
      </p>

      <h2>4. Intellectual Property</h2>
      <p class="mb-0">
        The text, institutional logos, downloadable syllabi, and layout elements of this website are the property of Kashmir College of Engineering & Technology. Unauthorized reproduction or commercial redistribution without prior written consent is strictly prohibited.
      </p>
    </div>
  </div>
</section>
