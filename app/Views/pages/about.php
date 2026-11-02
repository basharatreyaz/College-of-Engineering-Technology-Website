<?php
/**
 * Kashmir College of Engineering & Technology (KCET)
 * Premier Collegiate Institutional Profile & Genesis View
 */
$collegeName = setting('college_name', 'Kashmir College of Engineering & Technology');
$shortName = setting('college_short_name', 'KCET');
$tagline = setting('tagline', 'Excellence in Engineering, Innovation & Research');
$campusArea = setting('campus_area', '100+ Kanals');
$intake = setting('approved_intake', '360+ Seats');
?>

<!-- Page Hero Header -->
<div class="page-hero page-hero--bordered" style="background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);">
  <div class="container page-hero-inner">
    <span class="page-hero-badge-pill">
      INSTITUTIONAL PROFILE &bull; ESTD. 2002
    </span>
    <h1 class="page-hero-title">About Kashmir College of Engineering &amp; Technology</h1>
    <p class="page-hero-desc">
      Approved by AICTE, New Delhi and Affiliated to the University of Kashmir. Established to deliver world-standard engineering pedagogy, high-impact laboratories, and ethical technical leadership across Jammu &amp; Kashmir.
    </p>
  </div>
</div>

<!-- Genesis & History Section -->
<section class="section">
  <div class="container">
    <div class="about-genesis-grid">
      <div>
        <span class="section-badge">INSTITUTIONAL GENESIS</span>
        <h2 class="section-title text-left text-2xl mb-3">
          Pioneering Technical Excellence in the Kashmir Valley
        </h2>
        <p class="text-muted text-base leading-relaxed mb-3">
          Kashmir College of Engineering &amp; Technology (KCET) was founded in Ranbirgarh, Srinagar, to fulfill a vital national and regional mission: delivering rigorous, accredited undergraduate engineering education to the youth of Jammu &amp; Kashmir without the necessity of migrating to distant metropolitan centers.
        </p>
        <p class="text-muted text-base leading-relaxed mb-4">
          Spanning an expansive, serene campus exceeding 100 kanals, the institution is purposefully designed for deep scientific focus and practical engineering discovery. Equipped with 18+ specialized laboratories, advanced high-performance computing centers, dedicated civil surveying instrumentation, and an active Training &amp; Placement Cell, KCET continually aligns its academic training with contemporary Outcome-Based Education (OBE) norms.
        </p>
        <div class="motto-callout">
          <span class="motto-label">Institutional Motto</span>
          <p class="motto-text">"Knowledge &bull; Innovation &bull; Character"</p>
        </div>
      </div>

      <div>
        <div class="profile-governance-card">
          <h3 class="profile-governance-title">Institutional Profile &amp; Governance</h3>
          
          <div class="profile-governance-list">
            <div class="profile-governance-item">
              <span class="profile-governance-label">Statutory Approval</span>
              <p class="profile-governance-val">All India Council for Technical Education (AICTE), New Delhi</p>
            </div>
            <div class="profile-governance-item">
              <span class="profile-governance-label">University Affiliation</span>
              <p class="profile-governance-val">University of Kashmir, Srinagar (Hazratbal)</p>
            </div>
            <div class="profile-governance-item">
              <span class="profile-governance-label">Campus Infrastructure</span>
              <p class="profile-governance-val"><?= e($campusArea) ?> Dedicated Academic &amp; Green Estate</p>
            </div>
            <div class="profile-governance-item">
              <span class="profile-governance-label">Annual Approved Intake</span>
              <p class="profile-governance-val"><?= e($intake) ?> across 5 B.Tech Disciplines</p>
            </div>
            <div class="profile-governance-item">
              <span class="profile-governance-label">Admission Authority</span>
              <p class="profile-governance-val">Merit-Based / JKBOPEE Entrance &amp; Lateral Entry Scheme</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Campus Photographic Showcase -->
    <div class="campus-showcase-grid">
      <div class="campus-showcase-card">
        <img src="<?= asset('assets/images/campus-main-block.jpg') ?>" alt="KCET Academic Block at Ranbirgarh, Srinagar" class="campus-showcase-img">
        <div class="campus-showcase-body">
          <strong class="campus-showcase-title">Main Academic Block</strong>
          <span class="campus-showcase-desc">Purpose-built engineering block surrounded by lush green environs in Ranbirgarh, Srinagar.</span>
        </div>
      </div>

      <div class="campus-showcase-card">
        <img src="<?= asset('assets/images/event-inauguration-lg.jpg') ?>" alt="Hon'ble Lt. Governor Manoj Sinha inaugurating KCET Srinagar" class="campus-showcase-img">
        <div class="campus-showcase-body">
          <strong class="campus-showcase-title">Historic Inaugural Milestone</strong>
          <span class="campus-showcase-desc">Inauguration by Hon'ble Lt. Governor Sh. Manoj Sinha, advancing technical education in Kashmir.</span>
        </div>
      </div>

      <div class="campus-showcase-card">
        <img src="<?= asset('assets/images/campus-green-grounds.jpg') ?>" alt="Lush 100+ Kanal Green Campus" class="campus-showcase-img">
        <div class="campus-showcase-body">
          <strong class="campus-showcase-title">100+ Kanal Green Estate</strong>
          <span class="campus-showcase-desc">Sprawling outdoor grounds fostering sports, student recreation, and focused academic study.</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Vision & Mission Section -->
<section id="vision-mission" class="section section-alt">
  <div class="container">
    <div class="section-header">
      <span class="section-badge">CORE COMMITMENTS</span>
      <h2 class="section-title">Vision, Mission &amp; Academic Values</h2>
      <p class="section-subtitle">
        Our foundational commitments towards engineering distinction, regional advancement, and ethical leadership.
      </p>
    </div>

    <div class="vision-mission-grid">
      <!-- Vision Card -->
      <div class="vision-card">
        <div class="vision-badge">
          INSTITUTIONAL VISION
        </div>
        <h3 class="text-primary font-bold text-xl mb-3 leading-snug">
          To Be a Premier Center for Technical Rigour &amp; Innovation
        </h3>
        <p class="text-muted text-base leading-relaxed">
          To emerge as an internationally respected center of excellence in engineering education and technical research in northern India, producing globally competent, socially responsible, and ethically upright engineering professionals dedicated to nation-building and technological innovation.
        </p>
      </div>

      <!-- Mission Card -->
      <div class="mission-card">
        <div class="mission-badge">
          INSTITUTIONAL MISSION
        </div>
        <h3 class="text-primary font-bold text-xl mb-3 leading-snug">
          Empowering Hands-on Scientific Inquiry
        </h3>
        <ul class="mission-list">
          <li>Impart contemporary Outcome-Based Education (OBE) in undergraduate engineering with heavy emphasis on practical laboratory experimentation.</li>
          <li>Advance regional applied research targeting Himalayan seismic stability, water resources, digital connectivity, and smart sustainable logistics.</li>
          <li>Foster critical thinking, entrepreneurial mindsets, and professional ethics through close industry partnerships and internship programmes.</li>
          <li>Cultivate an inclusive, collaborative academic environment supporting diversity and women in STEM.</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- Leadership Messages Section -->
<?php
$leadershipCards = [
  [
    'role' => "Chairman's Desk",
    'page_url' => '/chairmans-message',
    'border_color' => '#1E3A8A',
    'badge_color' => '#1E3A8A',
    'badge_label' => 'BOARD OF TRUSTEES',
    'name' => setting('chairman_name', 'Er. Raja Aijaz Ali (Retd. IPS / IGP)'),
    'designation' => setting('chairman_designation', 'Chairman, Kashmir College of Engineering & Technology'),
    'qualifications' => 'B.E. (ECE), Former IGP, J&K',
    'photo' => setting('chairman_photo', 'assets/images/faculty-hod-cse.jpg'),
    'default_photo' => 'assets/images/chairman-portrait.svg',
    'quote' => setting('chairman_quote', 'Drawing from my engineering background and understanding the hardships students face when traveling outside the valley, KCET was established to provide state-of-the-art technical education right here in Kashmir.'),
    'message' => setting('chairman_message', 'Kashmir College of Engineering & Technology was established with a singular, resolute mission: to build a premier institution of technical excellence within the Kashmir valley so that aspiring engineering students do not have to endure the hardships of traveling outside the region to attain high-quality accredited technical education. Having served in public administration and holding a background in engineering, I envisioned KCET as a center of rigorous academic inquiry, cutting-edge computing laboratories, and ethical leadership.'),
    'office' => 'Office of the Chairman • chairman@kcet.edu.in'
  ],
  [
    'role' => "Director's Desk",
    'page_url' => '/directors-message',
    'border_color' => '#0D5C4A',
    'badge_color' => '#0D5C4A',
    'badge_label' => 'CAMPUS GOVERNANCE',
    'name' => setting('director_name', 'Er. Raja Minad Aijaz'),
    'designation' => setting('director_designation', 'Director / Director of Administration, KCET'),
    'qualifications' => 'B.E. (Engineering)',
    'photo' => setting('director_photo', 'assets/images/faculty-hod-ai.jpg'),
    'default_photo' => 'assets/images/director-portrait.svg',
    'quote' => setting('director_quote', 'Having experienced the challenges of pursuing an engineering degree away from home, our mission is to provide students at KCET with a world-class, supportive, and career-driven technical learning ecosystem.'),
    'message' => setting('director_message', 'At KCET, our focus is on creating a holistic academic and infrastructural environment where engineering students can thrive. From high-performance computing centers and specialized Artificial Intelligence laboratories to reliable campus transit routes and rich collegiate resources, every facility at Ranbirgarh is purpose-built to empower students.'),
    'office' => 'Directorate of Administration • administration@kcet.edu.in'
  ],
  [
    'role' => "Principal's Desk",
    'page_url' => '/principals-message',
    'border_color' => '#C98A2C',
    'badge_color' => '#C98A2C',
    'badge_label' => 'ACADEMIC LEADERSHIP',
    'name' => setting('principal_name', 'Dr. Syed Jalal Ahmad'),
    'designation' => setting('principal_designation', 'Principal & Professor of Engineering'),
    'qualifications' => setting('principal_qualifications', 'Ph.D. (IIT Delhi), M.Tech, B.E.'),
    'photo' => setting('principal_photo', 'assets/images/principal-portrait.svg'),
    'default_photo' => 'assets/images/principal-portrait.svg',
    'quote' => setting('principal_quote', 'Engineering education at KCET is deeply grounded in hands-on scientific enquiry, ethical problem-solving, and outcome-based pedagogical rigor. We prepare engineers not merely for examinations, but to solve real infrastructure and technological challenges of Jammu & Kashmir and the world.'),
    'message' => setting('principal_message', 'Since its inception, Kashmir College of Engineering & Technology has stood as a beacon of high-quality technical education in Srinagar. Situated across a lush 100+ kanal green campus, our institution provides an ideal environment where academic curiosity meets state-of-the-art laboratory experimentation. With approval from AICTE and affiliation to the prestigious University of Kashmir, our curriculum continually integrates modern computational frameworks, artificial intelligence paradigms, sustainable civil designs, and advanced electronics. We welcome aspiring engineers to join our vibrant academic community.'),
    'office' => 'Office of the Principal • principal@kcet.edu.in'
  ]
];
?>
<section id="leadership" class="section">
  <div class="container">
    <div class="section-header">
      <span class="section-badge">GOVERNANCE &amp; MENTORSHIP</span>
      <h2 class="section-title">Messages from Academic Leadership</h2>
      <p class="section-subtitle">
        Guiding perspectives from the Chairman, Managing Director, and Principal of KCET Srinagar.
      </p>
    </div>

    <div class="leadership-cards-grid">
      <?php foreach ($leadershipCards as $card): ?>
        <?php
          $photoPath = $card['photo'];
          $resolvedPhoto = (!empty($photoPath) && file_exists(ROOT_PATH . '/public/' . ltrim($photoPath, '/')))
            ? $photoPath
            : ($card['default_photo'] ?? 'assets/images/principal-portrait.svg');
        ?>
        <div class="about-leader-card" style="--leader-accent: <?= $card['border_color'] ?>;">
          <div class="about-leader-header">
            <img src="<?= asset($resolvedPhoto) ?>" alt="<?= e($card['name']) ?>" width="72" height="72" class="about-leader-avatar">
            <div>
              <span class="about-leader-badge"><?= e($card['badge_label']) ?></span>
              <h3 class="about-leader-name"><?= e($card['name']) ?></h3>
              <span class="about-leader-designation"><?= e($card['designation']) ?></span>
              <?php if (!empty($card['qualifications'])): ?>
                <span class="about-leader-qual"><?= e($card['qualifications']) ?></span>
              <?php endif; ?>
            </div>
          </div>
          <?php if (!empty($card['quote'])): ?>
            <blockquote class="about-leader-quote">
              "<?= e($card['quote']) ?>"
            </blockquote>
          <?php endif; ?>
          <div class="about-leader-message">
            <?= nl2br(e($card['message'])) ?>
          </div>
          <div class="about-leader-office">
            <?= e($card['office']) ?>
          </div>
          <a href="<?= url($card['page_url']) ?>" class="btn btn-outline text-xs py-2 px-3 justify-center about-leader-btn">
            <i class="fa-solid fa-file-lines me-1"></i> Read Dedicated Message &rarr;
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Governing Council & Statutory Committees -->
<section id="governing-body" class="section section-alt">
  <div class="container">
    <div class="section-header">
      <span class="section-badge">STATUTORY COMPLIANCE</span>
      <h2 class="section-title">Institutional Committees &amp; Statutory Cells</h2>
      <p class="section-subtitle">
        Established in strict adherence to AICTE and University of Kashmir statutory regulations.
      </p>
    </div>

    <div class="statutory-cells-grid">
      <div class="statutory-cell-card">
        <h4 class="statutory-cell-title">Anti-Ragging Committee</h4>
        <p class="statutory-cell-desc">
          Mandated by Supreme Court directives &amp; AICTE norms. Zero tolerance policy on campus.
        </p>
        <span class="statutory-cell-contact text-danger">24x7 Helpline: 1800-180-5522</span>
      </div>

      <div class="statutory-cell-card">
        <h4 class="statutory-cell-title">Internal Complaints (ICC)</h4>
        <p class="statutory-cell-desc">
          Prevention, prohibition and redressal of sexual harassment of women employees and students.
        </p>
        <span class="statutory-cell-contact text-primary">Contact: icc@kcet.edu.in</span>
      </div>

      <div class="statutory-cell-card">
        <h4 class="statutory-cell-title">Student Grievance Cell (SGRC)</h4>
        <p class="statutory-cell-desc">
          Structured mechanism for addressing student examinations, fee, and administrative queries.
        </p>
        <span class="statutory-cell-contact text-secondary">Ombudsman Appointed</span>
      </div>

      <div class="statutory-cell-card">
        <h4 class="statutory-cell-title">Equal Opportunity / SC-ST Cell</h4>
        <p class="statutory-cell-desc">
          Assistance, welfare scholarships, and guidance for underrepresented student communities.
        </p>
        <span class="statutory-cell-contact text-accent">Welfare Cell: scstcell@kcet.edu.in</span>
      </div>
    </div>
  </div>
</section>

<!-- Navigation Call to Action -->
<section class="section">
  <div class="container text-center">
    <h2 class="text-primary font-bold text-3xl mb-3">Ready to Join the KCET Community?</h2>
    <p class="text-muted text-base max-w-2xl mx-auto mb-4">
      Explore our 4-Year B.Tech programmes, review admission guidelines for Session 2026-27, or plan a visit to our green campus in Srinagar.
    </p>
    <div class="cta-actions-wrap">
      <a href="<?= url('/programmes') ?>" class="btn btn-primary">Undergraduate Programmes</a>
      <a href="<?= url('/admissions') ?>" class="btn btn-outline">Admission Guidelines</a>
      <a href="<?= url('/facilities') ?>" class="btn btn-outline">Campus Facilities</a>
      <a href="<?= url('/apply') ?>" class="btn btn-accent">Apply Online 2026-27</a>
    </div>
  </div>
</section>
