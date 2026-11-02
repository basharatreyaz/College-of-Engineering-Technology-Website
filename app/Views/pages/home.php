<?php
/**
 * Kashmir College of Engineering & Technology (KCET)
 * Premier Collegiate Homepage View
 */
$heroTitle = setting('hero_title', 'Nurturing Engineering Excellence & Innovation in Kashmir');
$heroSubtitle = setting('hero_subtitle', 'Approved by AICTE, New Delhi & Affiliated to University of Kashmir. Four-year undergraduate B.Tech programmes delivered across a picturesque 100+ kanal green campus in Ranbirgarh, Srinagar.');
$campusArea = setting('campus_area', '100+ Kanals');
$intake = setting('approved_intake', '360+ Seats');
$videoEmbedUrl = setting('youtube_tour_url', 'https://www.youtube.com/embed/Oog3g2U-UbM');
$heroVideoId = setting('hero_youtube_video_id', 'Oog3g2U-UbM');
$heroVideoEmbedUrl = "https://www.youtube.com/embed/{$heroVideoId}?autoplay=1&mute=1&controls=0&loop=1&playlist={$heroVideoId}&rel=0&playsinline=1&cc_load_policy=0&enablejsapi=1&origin=https%3A%2F%2Fkcet.edu.in&widgetid=1&forigin=https%3A%2F%2Fkcet.edu.in%2F&aoriginsup=1&vf=6";
?>

<!-- Hero Section with Authentic Campus Backdrop & Background Video -->
<section class="hero" aria-labelledby="heroTitle" style="background: linear-gradient(90deg, rgba(6, 23, 42, 0.95) 0%, rgba(10, 37, 64, 0.90) 45%, rgba(10, 37, 64, 0.55) 75%, rgba(6, 23, 42, 0.35) 100%), url('<?= asset('assets/images/campus-panoramic.jpg') ?>') center right/cover no-repeat;">
  
  <!-- Ambient YouTube Background Video -->
  <div class="hero-video-bg" aria-hidden="true">
    <iframe
      id="heroBgVideo"
      src="<?= e($heroVideoEmbedUrl) ?>"
      title="KCET Campus Video Backdrop"
      frameborder="0"
      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
      allowfullscreen
      tabindex="-1">
    </iframe>
  </div>

  <!-- Ambient Contrast Gradient Overlay for Readability -->
  <div class="hero-overlay" aria-hidden="true"></div>

  <div class="container">
    <div class="hero-content">
      <div class="hero-affiliation-badge">
        <span>AICTE APPROVED &bull; AFFILIATED TO UNIVERSITY OF KASHMIR &bull; ESTD. 2002</span>
      </div>
      <h1 id="heroTitle" class="hero-title text-white"><?= e($heroTitle) ?></h1>
      <p class="hero-subtitle"><?= e($heroSubtitle) ?></p>

      <div class="hero-buttons">
        <a href="<?= url('/apply') ?>" class="btn btn-accent btn-lg"><i class="fa-solid fa-file-signature me-2"></i> Apply for Admission 2026-27</a>
        <button type="button" class="btn btn-hero-enquiry btn-lg" data-open-enquiry-modal onclick="openQuickEnquiryModal()">
          <i class="fa-solid fa-headset me-2"></i> Admission Enquiry
        </button>
      </div>
    </div>
  </div>

  <!-- Video Playback Accessibility Controller -->
  <button type="button" id="heroVideoToggle" class="hero-video-toggle" aria-label="Pause background video" title="Pause background video">
    <i class="fa-solid fa-pause"></i> <span class="video-toggle-label">Pause Video</span>
  </button>
</section>

<!-- Live Collegiate Circular & Notice Ticker -->
<?php if (!empty($latestNotices)): ?>
<div class="notice-ticker-bar" role="region" aria-label="Latest Announcements and Circulars">
  <div class="container notice-ticker-inner">
    <div class="notice-ticker-badge">
      <span class="ticker-pulse-dot"></span>
      <i class="fa-solid fa-bullhorn text-xs"></i>
      <span>LATEST NOTICES</span>
    </div>
    <div class="notice-ticker-track" id="noticeTickerTrack">
      <div class="notice-ticker-content">
        <?php foreach ($latestNotices as $n): ?>
          <a href="<?= url('/notices/' . $n['slug']) ?>" class="notice-ticker-item">
            <span class="ticker-item-date"><?= date('d M', strtotime($n['publish_date'])) ?></span>
            <span class="ticker-item-title"><?= e($n['title']) ?></span>
            <span class="ticker-item-badge"><?= strtoupper(e($n['category'] ?? 'Notice')) ?></span>
          </a>
          <span class="ticker-separator">&bull;</span>
        <?php endforeach; ?>
        <?php foreach ($latestNotices as $n): ?>
          <a href="<?= url('/notices/' . $n['slug']) ?>" class="notice-ticker-item" aria-hidden="true">
            <span class="ticker-item-date"><?= date('d M', strtotime($n['publish_date'])) ?></span>
            <span class="ticker-item-title"><?= e($n['title']) ?></span>
            <span class="ticker-item-badge"><?= strtoupper(e($n['category'] ?? 'Notice')) ?></span>
          </a>
          <span class="ticker-separator" aria-hidden="true">&bull;</span>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="notice-ticker-all">
      <a href="<?= url('/notices') ?>" title="View all circulars and notices">
        <span>All Notices</span>
        <i class="fa-solid fa-arrow-right text-xs"></i>
      </a>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- Institutional Facts & Statistics Ribbon -->
<div class="container">
  <section class="stats-ribbon" aria-label="Key Facts and Statistics">
    <div class="stats-grid">
      <div class="stat-item">
        <span class="stat-number"><?= e($campusArea) ?></span>
        <span class="stat-label">Sprawling Green Campus</span>
        <span class="stat-verified-badge"><i class="fa-solid fa-circle-check"></i> Ranbirgarh, Srinagar</span>
      </div>
      <div class="stat-item">
        <span class="stat-number">5</span>
        <span class="stat-label">Core B.Tech Disciplines</span>
        <span class="stat-verified-badge"><i class="fa-solid fa-circle-check"></i> AI, CSE, Civil, IT, ECE</span>
      </div>
      <div class="stat-item">
        <span class="stat-number"><?= e($intake) ?></span>
        <span class="stat-label">Approved Annual Intake</span>
        <span class="stat-verified-badge"><i class="fa-solid fa-circle-check"></i> AICTE New Delhi Approved</span>
      </div>
      <div class="stat-item">
        <span class="stat-number">18+</span>
        <span class="stat-label">Advanced Engineering Labs</span>
        <span class="stat-verified-badge"><i class="fa-solid fa-circle-check"></i> High-Performance Computing</span>
      </div>
    </div>
  </section>
</div>

<!-- Dual Column: Official Notice Board & Upcoming Events (Standard Collegiate Core) -->
<section class="section section-academic-hub">
  <div class="container">
    <div class="academic-hub-grid">

      <!-- Column 1: Official Notice Board -->
      <div class="hub-column notice-board-card">
        <div class="hub-header">
          <div class="hub-title-group">
            <span class="hub-eyebrow">OFFICIAL GAZETTE</span>
            <h2 class="hub-title">Notices &amp; Circulars</h2>
          </div>
          <a href="<?= url('/notices') ?>" class="hub-more-link">All Circulars <i class="fa-solid fa-arrow-right ms-1"></i></a>
        </div>

        <div class="notice-items-list">
          <?php if (!empty($latestNotices)): ?>
            <?php foreach ($latestNotices as $idx => $notice): ?>
              <article class="notice-row-item">
                <div class="notice-date-box">
                  <span class="notice-month"><?= date('M', strtotime($notice['publish_date'])) ?></span>
                  <span class="notice-day"><?= date('d', strtotime($notice['publish_date'])) ?></span>
                  <span class="notice-year"><?= date('Y', strtotime($notice['publish_date'])) ?></span>
                </div>
                <div class="notice-info">
                  <div class="notice-category-badge"><?= strtoupper(e($notice['category'] ?? 'General')) ?></div>
                  <h3 class="notice-title">
                    <a href="<?= url('/notices/' . $notice['slug']) ?>"><?= e($notice['title']) ?></a>
                    <?php if ($idx < 2): ?>
                      <span class="badge-new">NEW</span>
                    <?php endif; ?>
                  </h3>
                  <p class="notice-summary"><?= e(substr($notice['summary'] ?? '', 0, 110)) ?>...</p>
                  <div class="notice-actions-strip">
                    <a href="<?= url('/notices/' . $notice['slug']) ?>" class="notice-read-link">Read Details <i class="fa-solid fa-arrow-right ms-1"></i></a>
                    <?php if (!empty($notice['attachment_file'])): ?>
                      <a href="<?= asset($notice['attachment_file']) ?>" target="_blank" class="notice-download-link" title="Download Official Circular PDF">
                        <i class="fa-solid fa-file-pdf"></i>
                        PDF Circular
                      </a>
                    <?php endif; ?>
                  </div>
                </div>
              </article>
            <?php endforeach; ?>
          <?php else: ?>
            <p class="p-3 text-muted">No urgent circulars at present.</p>
          <?php endif; ?>
        </div>

        <div class="hub-footer">
          <a href="<?= url('/notices') ?>" class="btn btn-outline btn-sm w-full text-center">
            View Complete Notice Board Archive <i class="fa-solid fa-arrow-right ms-1"></i>
          </a>
        </div>
      </div>

      <!-- Column 2: Upcoming Academic Events & Milestones -->
      <div class="hub-column events-hub-card">
        <div class="hub-header">
          <div class="hub-title-group">
            <span class="hub-eyebrow">CAMPUS ENGAGEMENT</span>
            <h2 class="hub-title">Events &amp; Symposia</h2>
          </div>
          <a href="<?= url('/events') ?>" class="hub-more-link">All Events <i class="fa-solid fa-arrow-right ms-1"></i></a>
        </div>

        <div class="event-items-list">
          <?php if (!empty($featuredEvents)): ?>
            <?php foreach ($featuredEvents as $event): ?>
              <article class="event-row-item">
                <div class="event-date-box">
                  <span class="event-month"><?= date('M', strtotime($event['start_date'])) ?></span>
                  <span class="event-day"><?= date('d', strtotime($event['start_date'])) ?></span>
                </div>
                <div class="event-info">
                  <div class="event-meta">
                    <span class="event-cat"><?= e($event['category'] ?? 'Academic') ?></span>
                    <?php if (!empty($event['location'])): ?>
                      <span class="event-loc">
                        <i class="fa-solid fa-location-dot"></i>
                        <?= e($event['location']) ?>
                      </span>
                    <?php endif; ?>
                  </div>
                  <h3 class="event-title">
                    <a href="<?= url('/events/' . $event['slug']) ?>"><?= e($event['title']) ?></a>
                  </h3>
                  <p class="event-summary"><?= e(substr($event['summary'] ?? '', 0, 115)) ?>...</p>
                  <a href="<?= url('/events/' . $event['slug']) ?>" class="event-link">Event Details <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>
              </article>
            <?php endforeach; ?>
          <?php else: ?>
            <p class="p-3 text-muted">No upcoming scheduled events.</p>
          <?php endif; ?>
        </div>

        <div class="hub-footer">
          <a href="<?= url('/events') ?>" class="btn btn-outline btn-sm w-full text-center">
            Browse Complete Academic Calendar <i class="fa-solid fa-arrow-right ms-1"></i>
          </a>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- Principal's Desk Section -->
<?php
$principalData = [
  'badge' => 'ACADEMIC LEADERSHIP',
  'heading' => "From the Principal's Desk",
  'page_url' => '/principals-message',
  'name' => setting('principal_name', 'Dr. Syed Jalal Ahmad'),
  'designation' => setting('principal_designation', 'Principal & Professor of Engineering'),
  'qualifications' => setting('principal_qualifications', 'Ph.D. (IIT Delhi), M.Tech, B.E.'),
  'photo' => setting('principal_photo', 'assets/images/principal-portrait.svg'),
  'default_photo' => 'assets/images/principal-portrait.svg',
  'quote' => setting('principal_quote', 'Engineering education at KCET is deeply grounded in hands-on scientific enquiry, ethical problem-solving, and outcome-based pedagogical rigor. We prepare engineers not merely for examinations, but to solve real infrastructure and technological challenges of Jammu & Kashmir and the world.'),
  'message' => setting('principal_message', 'Since its inception, Kashmir College of Engineering & Technology has stood as a beacon of high-quality technical education in Srinagar. Situated across a lush 100+ kanal green campus, our institution provides an ideal environment where academic curiosity meets state-of-the-art laboratory experimentation. With approval from AICTE and affiliation to the prestigious University of Kashmir, our curriculum continually integrates modern computational frameworks, artificial intelligence paradigms, sustainable civil designs, and advanced electronics. We welcome aspiring engineers to join our vibrant academic community.'),
];

$principalPhoto = (!empty($principalData['photo']) && file_exists(ROOT_PATH . '/public/' . ltrim($principalData['photo'], '/')))
  ? $principalData['photo']
  : $principalData['default_photo'];
?>
<section class="section section-alt">
  <div class="container">
    <div class="principal-message-container">
      <div class="principal-portrait-wrapper">
        <img src="<?= asset($principalPhoto) ?>" alt="<?= e($principalData['name']) ?>, <?= e($principalData['designation']) ?>" width="300" height="360" class="principal-portrait-img leader-portrait-img">
        <div class="principal-credentials">
          <strong><?= e($principalData['name']) ?></strong>
          <?php if (!empty($principalData['qualifications'])): ?>
            <span><?= e($principalData['qualifications']) ?></span>
          <?php endif; ?>
          <span class="principal-post"><?= e($principalData['designation']) ?></span>
        </div>
      </div>

      <div class="principal-message-content">
        <span class="section-badge"><?= e($principalData['badge']) ?></span>
        <h2 class="section-title text-left mb-3">
          <?= e($principalData['heading']) ?>
        </h2>
        <?php if (!empty($principalData['quote'])): ?>
          <blockquote class="principal-quote">
            "<?= e($principalData['quote']) ?>"
          </blockquote>
        <?php endif; ?>
        <?php
          $paragraphs = array_filter(array_map('trim', explode("\n", $principalData['message'])));
          if (empty($paragraphs)) {
            $paragraphs = [$principalData['message']];
          }
        ?>
        <?php foreach ($paragraphs as $para): ?>
          <p class="text-muted leading-relaxed mb-3">
            <?= e($para) ?>
          </p>
        <?php endforeach; ?>

        <div class="principal-actions">
          <a href="<?= url('/principals-message') ?>" class="btn btn-primary"><i class="fa-solid fa-file-lines me-1"></i> Read Full Principal's Message</a>
          <a href="<?= url('/about#leadership') ?>" class="btn btn-outline">Academic Leadership Overview</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Featured B.Tech Programmes Section -->
<section class="section">
  <div class="container">
    <div class="section-header">
      <span class="section-badge">UNDERGRADUATE ADMISSIONS</span>
      <h2 class="section-title">4-Year B.Tech Degree Programmes</h2>
      <p class="section-subtitle">
        Approved by AICTE, New Delhi and affiliated to University of Kashmir. All programmes feature modern outcome-based curricula, dedicated laboratories, and industry internships.
      </p>
    </div>

    <div class="cards-grid">
      <?php foreach ($featuredProgrammes as $p): ?>
      <article class="card programme-card">
        <?php if (!empty($p['featured_image'])): ?>
          <div class="card-image-wrapper">
            <a href="<?= url('/programmes/' . $p['slug']) ?>" tabindex="-1" aria-hidden="true">
              <img src="<?= asset($p['featured_image']) ?>" alt="<?= e($p['name']) ?>" loading="lazy" class="programme-card-img">
            </a>
          </div>
        <?php endif; ?>
        <div class="card-header-badge">
          <span class="dept-code"><?= strtoupper(e($p['code'] ?? 'BTECH')) ?></span>
          <span class="degree-type"><?= e($p['degree_type'] ?? 'B.Tech') ?> &bull; <?= e($p['duration'] ?? '4 Years') ?></span>
        </div>
        <div class="card-body">
          <h3 class="card-title">
            <a href="<?= url('/programmes/' . $p['slug']) ?>"><?= e($p['name']) ?></a>
          </h3>
          
          <div class="programme-spec-grid">
            <div class="spec-item">
              <span class="spec-label">Approved Intake</span>
              <strong class="spec-val"><?= e($p['intake'] ?: '60 Seats') ?></strong>
            </div>
            <div class="spec-item">
              <span class="spec-label">Affiliation</span>
              <strong class="spec-val">Univ. of Kashmir</strong>
            </div>
            <div class="spec-item">
              <span class="spec-label">Eligibility</span>
              <strong class="spec-val">10+2 (PCM &ge; 45%)</strong>
            </div>
            <div class="spec-item">
              <span class="spec-label">Admission Mode</span>
              <strong class="spec-val">Merit / JKBOPEE</strong>
            </div>
          </div>

          <p class="card-desc"><?= e($p['summary']) ?></p>

          <div class="card-footer">
            <a href="<?= url('/programmes/' . $p['slug']) ?>" class="btn btn-outline btn-sm">Course Details</a>
            <button type="button" class="btn btn-accent btn-sm" data-open-enquiry-modal data-programme-id="<?= $p['id'] ?>">Enquire</button>
          </div>
        </div>
      </article>
      <?php endforeach; ?>
    </div>

    <div class="text-center mt-5">
      <a href="<?= url('/programmes') ?>" class="btn btn-primary btn-lg">View Complete Academic Catalog &amp; Syllabi &rarr;</a>
    </div>
  </div>
</section>

<!-- Campus Facilities & Infrastructure Highlights -->
<section class="section section-alt">
  <div class="container">
    <div class="section-header">
      <span class="section-badge">CAMPUS INFRASTRUCTURE</span>
      <h2 class="section-title">Academic &amp; Research Facilities</h2>
      <p class="section-subtitle">
        Explore 12 dedicated campus facilities across our 100+ kanal green campus in Srinagar, engineered for student learning, safety, and innovation.
      </p>
    </div>

    <div class="cards-grid-3">
      <?php foreach ($facilities as $facility): ?>
      <div class="card facility-feature-card">
        <?php if (!empty($facility['image'])): ?>
          <div class="card-image-wrapper">
            <img src="<?= asset($facility['image']) ?>" alt="<?= e($facility['title']) ?>" loading="lazy" class="facility-card-img">
          </div>
        <?php endif; ?>
        <div class="card-body">
          <?php if (!empty($facility['badge'])): ?>
            <span class="facility-badge">
              <?= e($facility['badge']) ?>
            </span>
          <?php endif; ?>
          <h3 class="card-title text-lg mb-2">
            <a href="<?= url('/facilities/' . $facility['slug']) ?>"><?= e($facility['title']) ?></a>
          </h3>
          <p class="card-desc text-sm leading-relaxed mb-3">
            <?= e($facility['summary']) ?>
          </p>
          <div class="mt-auto">
            <a href="<?= url('/facilities/' . $facility['slug']) ?>" class="facility-link">
              Explore Facility <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="text-center mt-4">
      <a href="<?= url('/facilities') ?>" class="btn btn-outline">Explore All 12 Campus Facilities <i class="fa-solid fa-arrow-right ms-1"></i></a>
    </div>
  </div>
</section>

<!-- Campus Tour Video Embed (Privacy First) -->
<section class="section">
  <div class="container">
    <div class="section-header">
      <span class="section-badge">VIRTUAL CAMPUS WALKTHROUGH</span>
      <h2 class="section-title">Experience KCET Campus Tour</h2>
      <p class="section-subtitle">
        Take a glimpse into our serene 100+ kanal green campus, modern lecture theatres, and advanced engineering laboratories in Ranbirgarh, Srinagar.
      </p>
    </div>

    <div id="videoTourContainer" class="video-tour-container">
      <div class="video-consent-placeholder" style="background: linear-gradient(rgba(10, 37, 64, 0.88), rgba(10, 37, 64, 0.94)), url('<?= asset('assets/images/campus-main-block.jpg') ?>') center/cover no-repeat;">
        <h3>Campus Video Walkthrough</h3>
        <p>Click below to load the video player. In accordance with privacy preferences, third-party content is loaded upon user consent.</p>
        <button type="button" id="loadCampusTourBtn" data-video-url="<?= e($videoEmbedUrl) ?>" class="btn btn-accent btn-lg">
          <i class="fa-solid fa-circle-play me-2"></i>
          Load Campus Tour Video
        </button>
        <p class="text-xs mt-3 text-slate-300">
          Having trouble? <a href="<?= e($videoEmbedUrl) ?>" target="_blank" rel="noopener" class="text-amber-200 underline">Watch directly on YouTube</a>
        </p>
      </div>
    </div>
  </div>
</section>

<!-- Frequently Asked Questions Accordion -->
<section class="section section-alt">
  <div class="container">
    <div class="section-header">
      <span class="section-badge">ADMISSION GUIDELINES</span>
      <h2 class="section-title">Frequently Asked Questions</h2>
      <p class="section-subtitle">
        Official guidance regarding 4-Year B.Tech admissions, eligibility requirements, lateral entry, and student transport.
      </p>
    </div>

    <div class="accordion">
      <?php foreach ($faqs as $faq): ?>
      <div class="accordion-item">
        <button type="button" class="accordion-header" aria-expanded="false">
          <span><?= e($faq['question']) ?></span>
          <span class="accordion-icon"><i class="fa-solid fa-plus"></i></span>
        </button>
        <div class="accordion-content">
          <p><?= nl2br(e($faq['answer'])) ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="text-center mt-4">
      <a href="<?= url('/admissions') ?>" class="btn btn-outline">Read Complete Admissions &amp; Eligibility Guide</a>
    </div>
  </div>
</section>

<!-- Admission Enquiry Call to Action Banner -->
<section class="section">
  <div class="container">
    <div class="cta-banner">
      <div class="cta-banner-text">
        <h2>Admissions Open for Academic Session 2026-27</h2>
        <p>Join Kashmir College of Engineering &amp; Technology. Submit your online application or connect with our admission counselling office at Ranbirgarh, Srinagar.</p>
      </div>
      <div class="cta-banner-actions">
        <a href="<?= url('/apply') ?>" class="btn btn-accent btn-lg">Apply Online 2026-27</a>
        <button type="button" class="btn btn-white btn-lg" data-open-enquiry-modal>Request Branch Counselling</button>
      </div>
    </div>
  </div>
</section>
