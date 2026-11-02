<?php
/**
 * Privacy Policy Page View
 */
$collegeName = setting('college_name', 'Kashmir College of Engineering & Technology');
$emailPrimary = setting('email_primary', 'info@kcet.edu.in');
?>

<!-- Header -->
<div class="page-hero" style="background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);">
  <div class="container page-hero-inner">
    <h1 class="page-hero-title">Privacy Policy</h1>
    <p class="page-hero-desc">
      Information regarding data collection, storage, and retention practices for student applicants and visitors of KCET.
    </p>
  </div>
</div>

<section class="section">
  <div class="container max-w-4xl">
    <div class="legal-content-card">
      <h2>1. Information We Collect</h2>
      <p>
        When prospective students or guardians submit forms on this website (such as the online application form or admission enquiry widget), we collect personal details including: candidate name, parent/guardian name, email address, contact telephone number, residential address, date of birth, prior academic qualifications, and examination percentages.
      </p>

      <h2>2. Purpose of Collection</h2>
      <p>
        The data collected is utilized solely for legitimate institutional purposes:
      </p>
      <ul>
        <li>Evaluating applicant eligibility for undergraduate B.Tech courses.</li>
        <li>Communicating counselling schedules, admission updates, and fee breakdowns.</li>
        <li>Generating unique application reference numbers for in-person document verification.</li>
        <li>Responding to user-initiated enquiries regarding transport, hostel, or scholarships.</li>
      </ul>

      <h2>3. Data Access and Retention</h2>
      <p>
        Applicant and enquiry records are stored within an encrypted, restricted database. Access is limited strictly to authorized admissions staff and administrative officers. We do not sell, rent, or trade applicant personal information to third-party commercial marketers. Information is retained for the duration of the admission cycle and subsequent academic enrollment records.
      </p>

      <h2>4. Cookies and Session Storage</h2>
      <p>
        Our website uses secure session cookies solely for authentication and session management. We use browser <code>sessionStorage</code> to remember when you have dismissed the admission announcement modal, ensuring you are not repeatedly interrupted during the same browsing session.
      </p>

      <h2>5. Inquiries and Correction Requests</h2>
      <p class="mb-0">
        If you wish to update, correct, or request the deletion of your submitted application or enquiry details, please contact the admissions office at <a href="mailto:<?= e($emailPrimary) ?>" class="text-primary font-semibold"><?= e($emailPrimary) ?></a>.
      </p>
    </div>
  </div>
</section>
