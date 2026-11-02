<?php
/**
 * Campus Life View
 */
?>

<!-- Header -->
<div class="page-hero" style="background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);">
  <div class="container page-hero-inner">
    <span class="page-hero-badge">
      Student Experience
    </span>
    <h1 class="page-hero-title">Campus Life & Student Community</h1>
    <p class="page-hero-desc">
      Beyond engineering lectures and lab circuits: discover student technical clubs, annual hackathons, sports leagues, and regional community drives.
    </p>
  </div>
</div>

<section class="section">
  <div class="container">
    <!-- Student Clubs Grid -->
    <div class="mb-5">
      <div class="section-header">
        <span class="section-badge">Clubs & Societies</span>
        <h2 class="section-title">Co-Curricular Student Clubs</h2>
        <p class="section-subtitle">Student-led initiatives fostering innovation, competitive coding, cultural expression, and environmental stewardship.</p>
      </div>

      <div class="cards-grid">
        <div class="card">
          <div class="card-body">
            <i class="fa-solid fa-code text-primary club-card-icon"></i>
            <h3 class="card-title text-primary">KCET Coding &amp; Hackathon Society</h3>
            <p class="card-desc">
              Organizes collaborative weekend coding sprints, competitive programming challenges, algorithm workshops, and web dev hackathons.
            </p>
            <span class="badge badge-info">Technical Society</span>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <i class="fa-solid fa-brain text-primary club-card-icon"></i>
            <h3 class="card-title text-primary">AI &amp; Intelligent Systems Club</h3>
            <p class="card-desc">
              Hands-on exploration of deep learning, computer vision, and autonomous robotics projects leveraging KCET's GPU computing lab.
            </p>
            <span class="badge badge-info">Specialized AI Club</span>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <i class="fa-solid fa-trowel-bricks text-primary club-card-icon"></i>
            <h3 class="card-title text-primary">Civil &amp; Sustainable Infrastructure Club</h3>
            <p class="card-desc">
              Coordinates practical field surveying, geotechnical case studies along Himalayan highways, and sustainable building seminars.
            </p>
            <span class="badge badge-info">Field &amp; Engineering</span>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <i class="fa-solid fa-seedling text-secondary club-card-icon"></i>
            <h3 class="card-title text-primary">Nature &amp; Green Campus Initiative</h3>
            <p class="card-desc">
              Drives tree plantation drives across the 100+ kanal estate, campus recycling, and environmental awareness seminars.
            </p>
            <span class="badge badge-success">Eco Stewardship</span>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <i class="fa-solid fa-volleyball text-accent club-card-icon"></i>
            <h3 class="card-title text-primary">Sports &amp; Athletics Club</h3>
            <p class="card-desc">
              Conducts annual inter-department cricket championships, football tournaments, badminton leagues, and indoor table-tennis matches.
            </p>
            <span class="badge badge-warning">Sports &amp; Fitness</span>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <i class="fa-solid fa-masks-theater text-primary club-card-icon"></i>
            <h3 class="card-title text-primary">Cultural &amp; Literary Society</h3>
            <p class="card-desc">
              Arranges the annual freshers induction celebration, Kashmiri debate forums, technical symposiums, and college stage drama.
            </p>
            <span class="badge badge-info">Arts &amp; Culture</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Campus Life Photo Gallery -->
    <div>
      <div class="section-header">
        <span class="section-badge">Moments & Memories</span>
        <h2 class="section-title">Campus Gallery</h2>
        <p class="section-subtitle">Visual impressions of student activities, laboratories, and campus life at Ranbirgarh, Srinagar.</p>
      </div>

      <div class="cards-grid-3">
        <?php foreach ($galleryItems as $item): ?>
        <div class="card">
          <?php if (!empty($item['image_url'])): ?>
            <div class="card-image-wrapper">
              <img src="<?= asset($item['image_url']) ?>" alt="<?= e($item['title']) ?>" loading="lazy" class="h-48 w-full object-cover">
            </div>
          <?php endif; ?>
          <div class="card-body">
            <span class="badge badge-muted mb-2"><?= e(strtoupper($item['category'])) ?></span>
            <h4 class="text-primary font-bold text-lg mb-1"><?= e($item['title']) ?></h4>
            <?php if (!empty($item['caption'])): ?>
              <p class="text-muted text-sm leading-relaxed m-0"><?= e($item['caption']) ?></p>
            <?php endif; ?>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
