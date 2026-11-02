<?php
/**
 * Floating Action Utilities Component
 * 1. Back to Top Button
 * 2. Floating WhatsApp & Admissions Helpline
 */
$phonePrimary = setting('phone_primary', '+91 88994 12793');
$cleanPhone = preg_replace('/\D/', '', $phonePrimary);
?>

<!-- Floating Admissions Helpdesk (WhatsApp & Hotline) -->
<div class="floating-helpdesk" role="region" aria-label="Admissions Quick Helpdesk">
  <a href="https://wa.me/918899412793?text=<?= urlencode('Hello KCET Admissions Team, I would like to inquire about B.Tech Admissions 2026-27.') ?>" target="_blank" rel="noopener" class="floating-helpdesk-btn floating-btn-whatsapp" title="Chat on WhatsApp with Admissions Counsellor">
    <i class="fa-brands fa-whatsapp"></i>
    <span>WhatsApp Support</span>
  </a>
  <a href="tel:<?= $cleanPhone ?>" class="floating-helpdesk-btn floating-btn-call" title="Call KCET Admissions Desk: <?= e($phonePrimary) ?>">
    <i class="fa-solid fa-phone"></i>
    <span>Hotline</span>
  </a>
</div>

<!-- Floating Back to Top Button -->
<button type="button" id="btnBackToTop" class="btn-back-to-top" aria-label="Scroll back to top of page" title="Back to top">
  <i class="fa-solid fa-chevron-up"></i>
</button>
