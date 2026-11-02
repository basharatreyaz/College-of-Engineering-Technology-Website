<?php
/**
 * Kashmir College of Engineering & Technology (KCET)
 * Premier Collegiate Academic Footer Component
 */
$collegeName = setting('college_name', 'Kashmir College of Engineering & Technology');
$shortName = setting('college_short_name', 'KCET');
$tagline = setting('tagline', 'Excellence in Engineering, Innovation & Research');
$phonePrimary = setting('phone_primary', '+91 88994 12793');
$emailPrimary = setting('email_primary', 'info@kcet.edu.in');
$emailSecondary = setting('email_secondary', 'admissions@kcet.edu.in');
$address = setting('address', 'Ranbirgarh, Srinagar, Jammu and Kashmir 190001, India');
$officeHours = setting('office_hours', 'Monday – Saturday: 9:00 AM – 5:00 PM');
?>

<!-- Statutory Compliance & Institutional Assurance Bar -->
<section class="statutory-strip" role="region" aria-label="Statutory Bodies & Helpline Information">
  <div class="container statutory-inner">
    <div class="statutory-item">
      <div class="statutory-icon">
        <i class="fa-solid fa-shield-halved statutory-icon-symbol"></i>
      </div>
      <div class="statutory-text">
        <strong>Anti-Ragging Helpline</strong>
        <span>1800-180-5522 (Toll Free) | antiragging@kcet.edu.in</span>
      </div>
    </div>
    <div class="statutory-item">
      <div class="statutory-icon">
        <i class="fa-solid fa-scale-balanced statutory-icon-symbol"></i>
      </div>
      <div class="statutory-text">
        <strong>Grievance Redressal</strong>
        <span>Online Student Grievance Portal &amp; SGRC Committee</span>
      </div>
    </div>
    <div class="statutory-item">
      <div class="statutory-icon">
        <i class="fa-solid fa-award statutory-icon-symbol"></i>
      </div>
      <div class="statutory-text">
        <strong>AICTE Mandatory Disclosure</strong>
        <span>Extension of Approval (EoA) &amp; Public Disclosures</span>
      </div>
    </div>
  </div>
</section>

<footer class="site-footer" role="contentinfo">
  <div class="footer-top">
    <div class="container footer-grid">
      <!-- Col 1: Institutional Identity & Affiliation -->
      <div class="footer-brand">
        <div class="mb-3">
          <a href="<?= url('/') ?>" title="<?= e($collegeName) ?>">
            <img src="<?= asset('assets/images/kcet-logo-official.png') ?>" alt="<?= e($collegeName) ?>" class="footer-logo-img">
          </a>
        </div>
        <p class="footer-desc">
          A premier higher-education engineering institution established in Jammu &amp; Kashmir, delivering 4-Year B.Tech degrees across a scenic 100+ kanal green campus in Ranbirgarh, Srinagar.
        </p>
        <div class="footer-affiliations">
          <div class="footer-affil-tag"><i class="fa-solid fa-circle-check text-accent me-1"></i> Approved by AICTE, New Delhi</div>
          <div class="footer-affil-tag"><i class="fa-solid fa-circle-check text-accent me-1"></i> Affiliated to University of Kashmir</div>
          <div class="footer-affil-tag"><i class="fa-solid fa-circle-check text-accent me-1"></i> College Code: KCET | Estd. 2002</div>
        </div>
        <div class="footer-social-strip mt-3 d-flex align-items-center gap-2">
          <a href="https://facebook.com" target="_blank" rel="noopener" aria-label="KCET on Facebook" class="footer-social-btn">
            <i class="fa-brands fa-facebook-f text-sm"></i>
          </a>
          <a href="https://instagram.com" target="_blank" rel="noopener" aria-label="KCET on Instagram" class="footer-social-btn">
            <i class="fa-brands fa-instagram text-sm"></i>
          </a>
          <a href="https://linkedin.com" target="_blank" rel="noopener" aria-label="KCET on LinkedIn" class="footer-social-btn">
            <i class="fa-brands fa-linkedin-in text-sm"></i>
          </a>
          <a href="https://youtube.com" target="_blank" rel="noopener" aria-label="KCET on YouTube" class="footer-social-btn">
            <i class="fa-brands fa-youtube text-sm"></i>
          </a>
        </div>
      </div>

      <!-- Col 2: Academic Catalog -->
      <div>
        <h4 class="footer-heading">B.Tech Programmes</h4>
        <ul class="footer-links">
          <li><a href="<?= url('/programmes/b-tech-artificial-intelligence-engineering') ?>">Artificial Intelligence Engineering</a></li>
          <li><a href="<?= url('/programmes/b-tech-computer-engineering') ?>">Computer Engineering</a></li>
          <li><a href="<?= url('/programmes/b-tech-civil-engineering') ?>">Civil Engineering</a></li>
          <li><a href="<?= url('/programmes/b-tech-information-technology-engineering') ?>">Information Technology</a></li>
          <li><a href="<?= url('/programmes/b-tech-electronics-and-communication-engineering') ?>">Electronics &amp; Communication</a></li>
          <li><a href="<?= url('/admissions#lateral-entry') ?>">Lateral Entry (Direct 3rd Semester)</a></li>
          <li><a href="<?= url('/syllabus') ?>">B.Tech Syllabi &amp; Curricula</a></li>
        </ul>
      </div>

      <!-- Col 3: Institutional Links & Committees -->
      <div>
        <h4 class="footer-heading">Statutory &amp; Quick Links</h4>
        <ul class="footer-links">
          <li><a href="<?= url('/about') ?>">Genesis &amp; Institutional Profile</a></li>
          <li><a href="<?= url('/chairmans-message') ?>">Chairman's Message</a></li>
          <li><a href="<?= url('/directors-message') ?>">Director's Message</a></li>
          <li><a href="<?= url('/principals-message') ?>">Principal's Desk Message</a></li>
          <li><a href="<?= url('/departments') ?>">Academic Departments</a></li>
          <li><a href="<?= url('/faculty') ?>">Faculty Directory</a></li>
          <li><a href="<?= url('/facilities') ?>">Campus Infrastructure &amp; Labs</a></li>
          <li><a href="<?= url('/notices') ?>">Circulars &amp; Notice Board</a></li>
          <li><a href="<?= url('/events') ?>">Academic Events &amp; Workshops</a></li>
          <li><a href="<?= url('/careers') ?>">Career Opportunities</a></li>
        </ul>
      </div>

      <!-- Col 4: Campus Contact & Helpdesk -->
      <div>
        <h4 class="footer-heading">Campus &amp; Admissions Desk</h4>
        <ul class="footer-contact-list">
          <li class="footer-contact-item">
            <i class="fa-solid fa-location-dot footer-contact-icon"></i>
            <span><?= e($address) ?></span>
          </li>
          <li class="footer-contact-item">
            <i class="fa-solid fa-phone footer-contact-icon"></i>
            <div>
              <a href="tel:<?= preg_replace('/\s+/', '', $phonePrimary) ?>"><?= e($phonePrimary) ?></a>
              <div class="text-xs text-slate-400">Admissions Office Hotline</div>
            </div>
          </li>
          <li class="footer-contact-item">
            <i class="fa-solid fa-envelope footer-contact-icon"></i>
            <div>
              <a href="mailto:<?= e($emailPrimary) ?>"><?= e($emailPrimary) ?></a><br>
              <a href="mailto:<?= e($emailSecondary) ?>"><?= e($emailSecondary) ?></a>
            </div>
          </li>
          <li class="footer-contact-item">
            <i class="fa-solid fa-clock footer-contact-icon"></i>
            <span><?= e($officeHours) ?></span>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Bottom Legal & Accreditation Strip -->
  <div class="footer-bottom">
    <div class="container footer-bottom-inner">
      <div>
        &copy; <?= date('Y') ?> <?= e($collegeName) ?>. All rights reserved. | Permanent Institute ID: AICTE-1-XXXXXX
      </div>
      <div class="footer-legal-links">
        <a href="<?= url('/privacy') ?>">Privacy Policy</a>
        <a href="<?= url('/terms') ?>">Terms &amp; Disclaimers</a>
        <a href="<?= url('/downloads') ?>">Mandatory Disclosures</a>
        <a href="<?= url('/sitemap.xml') ?>">XML Sitemap</a>
        <a href="<?= url('/admin/login') ?>">Faculty / Staff Login</a>
      </div>
    </div>
  </div>
</footer>
