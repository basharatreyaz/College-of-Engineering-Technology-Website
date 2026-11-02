<?php
/**
 * Contact Us Page View
 */
$collegeName = setting('college_name', 'Kashmir College of Engineering & Technology');
$phonePrimary = setting('phone_primary', '+91 88994 12793');
$emailPrimary = setting('email_primary', 'info@kcet.edu.in');
$emailSecondary = setting('email_secondary', 'kcetsrinagar@gmail.com');
$address = setting('address', 'Ranbirgarh, Srinagar, Jammu and Kashmir 190001, India');
$officeHours = setting('office_hours', 'Monday – Saturday: 9:00 AM – 5:00 PM');
?>

<!-- Header -->
<div class="page-hero" style="background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);">
  <div class="container page-hero-inner">
    <span class="page-hero-badge">
      Get in Touch
    </span>
    <h1 class="page-hero-title">Contact KCET Srinagar</h1>
    <p class="page-hero-desc">
      Have questions regarding admissions, transport routes, or campus visits? Reach out to our admissions and administrative office.
    </p>
  </div>
</div>

<section class="section">
  <div class="container">
    <div class="contact-layout-grid">
      <!-- Contact Info Details Col -->
      <div>
        <h2 class="text-primary font-bold text-2xl mb-4">Campus Information</h2>
        
        <div class="contact-items-list">
          <div class="contact-item">
            <div class="contact-item-icon">
              <i class="fa-solid fa-location-dot"></i>
            </div>
            <div>
              <strong class="contact-item-label">Campus Location</strong>
              <p class="contact-item-text"><?= e($address) ?></p>
            </div>
          </div>

          <div class="contact-item">
            <div class="contact-item-icon">
              <i class="fa-solid fa-phone"></i>
            </div>
            <div>
              <strong class="contact-item-label">Admissions Hotline</strong>
              <p class="contact-item-text">
                <a href="tel:<?= preg_replace('/\s+/', '', $phonePrimary) ?>" class="text-primary font-semibold no-underline"><?= e($phonePrimary) ?></a>
              </p>
            </div>
          </div>

          <div class="contact-item">
            <div class="contact-item-icon">
              <i class="fa-solid fa-envelope"></i>
            </div>
            <div>
              <strong class="contact-item-label">Email Communications</strong>
              <p class="contact-item-text">
                Primary: <a href="mailto:<?= e($emailPrimary) ?>"><?= e($emailPrimary) ?></a><br>
                Alternate: <a href="mailto:<?= e($emailSecondary) ?>"><?= e($emailSecondary) ?></a>
              </p>
            </div>
          </div>

          <div class="contact-item">
            <div class="contact-item-icon">
              <i class="fa-solid fa-clock"></i>
            </div>
            <div>
              <strong class="contact-item-label">Administrative Working Hours</strong>
              <p class="contact-item-text"><?= e($officeHours) ?></p>
            </div>
          </div>
        </div>

        <!-- Campus Map Notice -->
        <div class="contact-location-card">
          <h4 class="text-primary font-bold text-base mb-1">Location Directions</h4>
          <p class="text-muted text-sm leading-relaxed mb-3">
            KCET is conveniently situated along the Srinagar-Baramulla national highway corridor at Ranbirgarh, easily reachable via public transport and college transit buses.
          </p>
          <a href="https://maps.google.com/?q=Ranbirgarh+Srinagar+KCET" target="_blank" rel="noopener" class="btn btn-outline btn-sm">
            Open in Google Maps &rarr;
          </a>
        </div>
      </div>

      <!-- Contact Form Col -->
      <div>
        <form action="<?= url('/contact') ?>" method="POST" class="js-enquiry-form contact-form-card">
          <?= csrf_field() ?>
          <input type="text" name="enquiry_hp" class="form-hp" tabindex="-1" autocomplete="off">
          <input type="hidden" name="source_page" value="contact">

          <h3 class="text-primary font-bold text-xl mb-1">Send a Message</h3>
          <p class="text-muted text-sm mb-4">
            Fill out the form below and an admissions officer will get in touch within 24 hours.
          </p>

          <div class="form-group">
            <label class="form-label" for="contact_name">Full Name *</label>
            <input type="text" id="contact_name" name="name" class="form-control" required placeholder="Your full name">
          </div>

          <div class="form-row">
            <div class="form-group flex-1">
              <label class="form-label" for="contact_email">Email Address *</label>
              <input type="email" id="contact_email" name="email" class="form-control" required placeholder="you@example.com">
            </div>
            <div class="form-group flex-1">
              <label class="form-label" for="contact_phone">Phone / WhatsApp Number *</label>
              <input type="tel" id="contact_phone" name="phone" class="form-control" required placeholder="+91 XXXXX XXXXX">
            </div>
          </div>

          <div class="form-group">
            <label class="form-label" for="contact_programme">Programme / Enquiry Type</label>
            <select id="contact_programme" name="programme_id" class="form-control">
              <option value="">General Institutional Enquiry</option>
              <?php foreach (($programmes ?? []) as $p): ?>
                <option value="<?= $p['id'] ?>">Admission Enquiry: <?= e($p['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label" for="contact_message">Your Message / Query *</label>
            <textarea id="contact_message" name="message" class="form-control" rows="4" required placeholder="How can we help you? Ask about admissions, eligibility, transport..."></textarea>
          </div>

          <button type="submit" class="btn btn-primary btn-lg w-full">
            <span class="btn-text">Submit Enquiry</span>
            <span class="btn-spinner d-none"><i class="fa-solid fa-spinner fa-spin"></i> Submitting...</span>
          </button>
        </form>
      </div>
    </div>
  </div>
</section>
