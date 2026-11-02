<?php
/**
 * Application Success View
 */
$reference = $ref ?: ($appData['reference'] ?? 'KCET-2026-SUBMITTED');
$name = $appData['name'] ?? 'Candidate';
$programme = $appData['programme'] ?? 'B.Tech Engineering';
$phonePrimary = setting('phone_primary', '+91 88994 12793');
?>

<div class="page-hero text-center" style="background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);">
  <div class="container page-hero-inner">
    <div class="success-icon-badge">
      <i class="fa-solid fa-check"></i>
    </div>
    <span class="page-hero-badge text-amber-200">
      Registration Registered
    </span>
    <h1 class="page-hero-title">Application Successfully Submitted!</h1>
    <p class="page-hero-desc mx-auto max-w-xl">
      Thank you, <strong><?= e($name) ?></strong>. Your admission registration has been recorded into the KCET admissions database.
    </p>
  </div>
</div>

<section class="section">
  <div class="container max-w-2xl">
    <!-- Print-Only Institutional Header -->
    <div class="print-only-header d-none">
      <div class="masthead">
        <img src="<?= asset('assets/images/kcet-logo-header.png') ?>" alt="KCET Official Logo" class="masthead-logo-img">
        <div>
          <h2 class="text-lg text-uppercase font-bold text-black m-0">Kashmir College of Engineering &amp; Technology</h2>
          <p class="text-xs text-black my-1">Approved by AICTE, New Delhi &bull; Affiliated to University of Kashmir &bull; Estd. 2002</p>
          <p class="text-xs text-black m-0">Ranbirgarh, Srinagar, J&amp;K &ndash; 190001 | Web: kcet.edu.in | Helpline: +91 88994 12793</p>
        </div>
      </div>
      <div class="text-center mb-4">
        <h3 class="text-base underline font-bold m-0">OFFICIAL ADMISSION REGISTRATION ACKNOWLEDGEMENT</h3>
        <span class="text-xs">Academic Session: 2026-27 | Generated on: <?= date('d M Y, h:i A') ?></span>
      </div>
    </div>

    <!-- Reference Card -->
    <div class="receipt-card">
      <span class="text-muted text-xs font-bold text-uppercase tracking-wider">Your Unique Application Reference ID</span>
      <div class="receipt-ref-num">
        <?= e($reference) ?>
      </div>
      <p class="text-muted text-sm max-w-md mx-auto mb-4">
        Please save or note down this reference number. It will be required during in-person counselling and original document verification at the campus admissions counter.
      </p>

      <div class="receipt-meta-box">
        <div class="receipt-meta-row">
          <span class="text-muted">Applicant Name:</span>
          <strong class="text-dark"><?= e($name) ?></strong>
        </div>
        <div class="receipt-meta-row">
          <span class="text-muted">Programme Selected:</span>
          <strong class="text-primary"><?= e($programme) ?></strong>
        </div>
        <div class="receipt-meta-row">
          <span class="text-muted">Application Status:</span>
          <span class="badge badge-warning">Under Review</span>
        </div>
      </div>

      <div class="d-flex justify-center gap-3 flex-wrap">
        <button type="button" class="btn btn-primary" onclick="window.print()">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
          Print Receipt
        </button>
        <a href="<?= url('/') ?>" class="btn btn-outline">Return to Homepage</a>
      </div>
    </div>

    <!-- Next Steps Checklist -->
    <div class="receipt-next-steps">
      <h3 class="text-primary font-bold text-lg mb-3">Next Steps for Verification</h3>
      <ol class="text-muted text-sm leading-relaxed d-flex flex-col gap-2 ps-4 m-0">
        <li>Our admissions officer will review your preliminary details within 24 to 48 hours.</li>
        <li>Carry original 10+2 marks card, DOB certificate, and 6 passport photographs to the admissions office at Ranbirgarh, Srinagar.</li>
        <li>For any urgent query regarding seat availability or transport routes, call: <strong><?= e($phonePrimary) ?></strong>.</li>
      </ol>
    </div>
  </div>
</section>
