<?php
/**
 * Instant Spotlight Quick Search Component (Ctrl+K)
 */
$db = \App\Services\Database::getInstance();
$programmes = $db->query("SELECT id, name, slug FROM programmes WHERE is_active = 1 ORDER BY display_order ASC");
$departments = $db->query("SELECT id, name, slug FROM departments WHERE is_active = 1 ORDER BY name ASC");
$facilities = $db->query("SELECT id, title, slug FROM facilities WHERE is_active = 1 ORDER BY display_order ASC LIMIT 8");
?>

<div id="quickSearchModal" class="search-modal-backdrop" role="dialog" aria-modal="true" aria-labelledby="quickSearchInput" aria-hidden="true">
  <div class="search-modal-card">
    <div class="search-modal-input-wrap">
      <i class="fa-solid fa-magnifying-glass text-accent text-lg"></i>
      <input type="text" id="quickSearchInput" class="search-modal-input" placeholder="Search programmes, departments, syllabus, notices... (ESC to close)" autocomplete="off">
      <button type="button" class="modal-close text-muted text-xl" onclick="closeSearchModal()" aria-label="Close search">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>

    <div class="search-modal-results" id="searchResultsContainer">
      <div class="search-modal-heading">
        Quick Navigation
      </div>
      
      <a href="<?= url('/apply') ?>" class="search-result-item" data-search-term="apply online registration admission 2026-27 form">
        <div>
          <strong>Apply Online 2026-27</strong>
          <span class="text-muted text-xs block">Digital B.Tech Admission Application</span>
        </div>
        <span class="search-result-badge search-result-badge--amber">Admissions</span>
      </a>

      <a href="<?= url('/chairmans-message') ?>" class="search-result-item" data-search-term="chairman message address er raja aijaz ali trustees vision">
        <div>
          <strong>Chairman's Message</strong>
          <span class="text-muted text-xs block">From the Chairman's Desk (Er. Raja Aijaz Ali)</span>
        </div>
        <span class="search-result-badge">Leadership</span>
      </a>

      <a href="<?= url('/directors-message') ?>" class="search-result-item" data-search-term="director message er raja minad aijaz administration infrastructure">
        <div>
          <strong>Director's Message</strong>
          <span class="text-muted text-xs block">From the Director's Desk (Er. Raja Minad Aijaz)</span>
        </div>
        <span class="search-result-badge">Leadership</span>
      </a>

      <a href="<?= url('/principals-message') ?>" class="search-result-item" data-search-term="principal desk academic message dr syed jalal ahmad">
        <div>
          <strong>Principal's Desk Message</strong>
          <span class="text-muted text-xs block">From the Principal's Desk (Dr. Syed Jalal Ahmad)</span>
        </div>
        <span class="search-result-badge">Leadership</span>
      </a>

      <?php foreach ($programmes as $prog): ?>
        <a href="<?= url('/programmes/' . $prog['slug']) ?>" class="search-result-item" data-search-term="programme btech b.tech <?= strtolower(e($prog['name'])) ?>">
          <div>
            <strong><?= e($prog['name']) ?></strong>
            <span class="text-muted text-xs block">4-Year B.Tech Degree Programme</span>
          </div>
          <span class="search-result-badge search-result-badge--sky">B.Tech Branch</span>
        </a>
      <?php endforeach; ?>

      <?php foreach ($departments as $dept): ?>
        <a href="<?= url('/departments/' . $dept['slug']) ?>" class="search-result-item" data-search-term="department <?= strtolower(e($dept['name'])) ?>">
          <div>
            <strong>Department of <?= e($dept['name']) ?></strong>
            <span class="text-muted text-xs block">Academic Department Overview &amp; Faculty</span>
          </div>
          <span class="search-result-badge">Department</span>
        </a>
      <?php endforeach; ?>

      <?php foreach ($facilities as $fac): ?>
        <a href="<?= url('/facilities/' . $fac['slug']) ?>" class="search-result-item" data-search-term="facility infrastructure lab <?= strtolower(e($fac['title'])) ?>">
          <div>
            <strong><?= e($fac['title']) ?></strong>
            <span class="text-muted text-xs block">Campus Infrastructure &amp; Student Facility</span>
          </div>
          <span class="search-result-badge">Facility</span>
        </a>
      <?php endforeach; ?>

      <a href="<?= url('/syllabus') ?>" class="search-result-item" data-search-term="syllabus curricula btech ai cse civil it ece course outline subjects semester">
        <div>
          <strong>B.Tech Engineering Syllabus &amp; Curricula</strong>
          <span class="text-muted text-xs block">AICTE &amp; Kashmir University Course Outlines (Semesters 1-8)</span>
        </div>
        <span class="search-result-badge">Syllabus</span>
      </a>

      <a href="<?= url('/downloads') ?>" class="search-result-item" data-search-term="downloads syllabus curricula prospectus pdf circular">
        <div>
          <strong>Academic Syllabi &amp; Downloads</strong>
          <span class="text-muted text-xs block">Download B.Tech Curriculum, Ordinances, Calendars</span>
        </div>
        <span class="search-result-badge">Downloads</span>
      </a>

      <a href="<?= url('/faculty') ?>" class="search-result-item" data-search-term="faculty professors teachers staff directory hod">
        <div>
          <strong>Faculty Directory</strong>
          <span class="text-muted text-xs block">Distinguished Professors &amp; Academic Instructors</span>
        </div>
        <span class="search-result-badge">Faculty</span>
      </a>

      <a href="<?= url('/notices') ?>" class="search-result-item" data-search-term="notices circulars announcements admissions examinations gazette">
        <div>
          <strong>Notices &amp; Announcements</strong>
          <span class="text-muted text-xs block">Official Administrative Circulars</span>
        </div>
        <span class="search-result-badge">Notices</span>
      </a>

      <a href="<?= url('/campus-life') ?>" class="search-result-item" data-search-term="campus life clubs sports hackathon photo gallery">
        <div>
          <strong>Campus Life &amp; Student Clubs</strong>
          <span class="text-muted text-xs block">Co-Curricular Societies, Hackathons &amp; Gallery</span>
        </div>
        <span class="search-result-badge">Student Life</span>
      </a>

      <a href="<?= url('/contact') ?>" class="search-result-item" data-search-term="contact admissions phone email location ranbirgarh srinagar">
        <div>
          <strong>Contact Admissions Desk</strong>
          <span class="text-muted text-xs block">Campus Location, Telephone &amp; Directions</span>
        </div>
        <span class="search-result-badge">Contact</span>
      </a>
    </div>

    <div class="search-modal-footer">
      <span><kbd class="search-modal-kbd">ESC</kbd> to close</span>
      <span><kbd class="search-modal-kbd">&uarr;</kbd> <kbd class="search-modal-kbd">&darr;</kbd> to navigate</span>
      <span><kbd class="search-modal-kbd">&crarr;</kbd> to select</span>
    </div>
  </div>
</div>
