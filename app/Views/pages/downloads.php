<?php
/**
 * Downloads & Academic Syllabi View
 * Kashmir College of Engineering & Technology (KCET) Srinagar
 */
$isSyllabusRoute = $isSyllabusRoute ?? ($selectedCategory === 'syllabus' || str_starts_with($_SERVER['REQUEST_URI'] ?? '', '/syllabus'));
$routeBase = $isSyllabusRoute ? '/syllabus' : '/downloads';

$selectedCategory = $selectedCategory ?? ($isSyllabusRoute ? 'syllabus' : 'all');
$selectedBranch = $selectedBranch ?? 'ai';
// If category is syllabus and branch is 'all', default branch to 'ai' for better UX
if ($selectedCategory === 'syllabus' && $selectedBranch === 'all') {
    $selectedBranch = 'ai';
}
$selectedSemester = $selectedSemester ?? 0;
$searchQuery = $searchQuery ?? '';

// Active branch data
$activeBranchData = $branches[$selectedBranch] ?? $branches['ai'];
?>

<!-- Hero Header -->
<div class="page-hero" style="background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);">
  <div class="page-hero-overlay"></div>
  <div class="container page-hero-inner">
    <div class="d-flex align-items-center gap-2 mb-2">
      <span class="page-hero-badge-pill"><?= $isSyllabusRoute ? 'Academic Curricula & Course Schemas' : 'Official Academic Repository' ?></span>
      <span class="text-slate-400 text-sm">• Updated for 2026-27 Academic Session</span>
    </div>
    
    <h1 class="page-hero-title"><?= $isSyllabusRoute ? 'B.Tech Syllabus & Academic Curricula' : 'Downloads & Academic Syllabi' ?></h1>
    
    <p class="page-hero-desc mb-4">
      <?= $isSyllabusRoute 
        ? 'Official AICTE Model Curriculum and University of Kashmir approved 4-Year B.Tech course outlines across Artificial Intelligence, Computer Engineering, Civil, IT, and Electronics & Communication. Explore detailed semester modules (Semesters 1 to 8) and download verified syllabus booklets.'
        : 'Access official AICTE & University of Kashmir curricula, branch-wise and semester-wise course syllabi, institutional prospectus, academic calendars, and printable admission forms.' ?>
    </p>

    <!-- Quick Live Search Bar -->
    <div class="downloads-search-wrapper">
      <form action="<?= url($routeBase) ?>" method="GET" class="downloads-search-form" id="downloadsSearchForm">
        <?php if (!$isSyllabusRoute && $selectedCategory !== 'all'): ?>
          <input type="hidden" name="cat" value="<?= e($selectedCategory) ?>">
        <?php endif; ?>
        <?php if ($selectedBranch !== 'all'): ?>
          <input type="hidden" name="branch" value="<?= e($selectedBranch) ?>">
        <?php endif; ?>
        
        <div class="downloads-search-field">
          <i class="fa-solid fa-magnifying-glass downloads-search-icon"></i>
          <input type="text" name="q" id="docSearchInput" value="<?= e($searchQuery) ?>" 
                 placeholder="Search by subject name, course code, branch or document..." 
                 class="downloads-search-input">
        </div>
        <button type="submit" class="btn btn-accent downloads-search-btn">Search</button>
      </form>
    </div>
  </div>
</div>

<section class="section section-subtle pt-4">
  <div class="container">

    <!-- Category Nav Pills -->
    <div class="downloads-category-nav">
      <span class="downloads-category-label">
        <i class="fa-solid fa-layer-group"></i> Category:
      </span>

      <a href="<?= url('/downloads') ?>" class="btn btn-sm btn-pill <?= (!$isSyllabusRoute && $selectedCategory === 'all') ? 'btn-primary' : 'btn-outline' ?>">
        <i class="fa-solid fa-folder-open me-1"></i> All Resources
      </a>

      <a href="<?= url('/syllabus?branch=' . e($selectedBranch)) ?>" class="btn btn-sm btn-pill <?= ($isSyllabusRoute || $selectedCategory === 'syllabus') ? 'btn-primary' : 'btn-outline' ?>">
        <i class="fa-solid fa-graduation-cap me-1"></i> B.Tech Syllabi
      </a>

      <a href="<?= url('/downloads?cat=prospectus') ?>" class="btn btn-sm btn-pill <?= ($selectedCategory === 'prospectus') ? 'btn-primary' : 'btn-outline' ?>">
        <i class="fa-solid fa-book-open me-1"></i> Prospectus &amp; Brochures
      </a>

      <a href="<?= url('/downloads?cat=forms') ?>" class="btn btn-sm btn-pill <?= ($selectedCategory === 'forms') ? 'btn-primary' : 'btn-outline' ?>">
        <i class="fa-solid fa-file-lines me-1"></i> Admission Forms
      </a>

      <a href="<?= url('/downloads?cat=circular') ?>" class="btn btn-sm btn-pill <?= ($selectedCategory === 'circular') ? 'btn-primary' : 'btn-outline' ?>">
        <i class="fa-solid fa-calendar-days me-1"></i> Calendars &amp; Regulations
      </a>

      <?php if (!empty($searchQuery)): ?>
        <a href="<?= url($routeBase) ?>" class="btn btn-sm btn-outline downloads-clear-btn">
          <i class="fa-solid fa-xmark me-1"></i> Clear Filter ("<?= e($searchQuery) ?>")
        </a>
      <?php endif; ?>
    </div>

    <!-- MAIN SYLLABUS SECTION (When viewing syllabus or all) -->
    <?php if ($selectedCategory === 'all' || $selectedCategory === 'syllabus'): ?>
      <div id="syllabus-explorer" class="mb-5">
        <div class="d-flex justify-content-between align-items-end mb-3 flex-wrap gap-3">
          <div>
            <span class="section-subtitle">Academic Curricula</span>
            <h2 class="section-title text-left mb-1">B.Tech Syllabus by Engineering Branch</h2>
            <p class="text-muted text-sm m-0">
              Select a branch below to explore semester-wise course breakdown, subject credits, and download official syllabus booklets.
            </p>
          </div>

          <span class="badge badge-info py-2 px-3">
            <i class="fa-solid fa-circle-check text-success me-1"></i> Affiliated with University of Kashmir & AICTE
          </span>
        </div>

        <!-- Branch Selector Cards Grid -->
        <div class="branch-selector-grid">
          <?php foreach ($branches as $bKey => $bMeta): 
            $isActiveBranch = ($selectedBranch === $bKey);
            $branchUrl = $isSyllabusRoute 
              ? url('/syllabus/' . $bKey) 
              : url('/downloads?cat=syllabus&branch=' . $bKey);
          ?>
            <a href="<?= $branchUrl ?>#syllabus-explorer" 
               class="branch-selector-card <?= $isActiveBranch ? 'active' : '' ?>">
              
              <?php if ($isActiveBranch): ?>
                <span class="branch-card-selected-tag">Selected</span>
              <?php endif; ?>

              <div class="branch-card-icon">
                <i class="<?= e($bMeta['icon']) ?>"></i>
              </div>

              <strong class="branch-card-title">
                <?= e($bMeta['short_name']) ?>
              </strong>

              <span class="branch-card-meta">
                <?= e($bMeta['code']) ?> • Intake: <?= e((string)$bMeta['intake']) ?>
              </span>

              <span class="branch-card-action">
                View Syllabi <i class="fa-solid fa-arrow-right text-xs"></i>
              </span>
            </a>
          <?php endforeach; ?>
        </div>

        <!-- Active Branch Information Banner & Complete Booklet Download -->
        <div class="branch-detail-banner">
          <div class="branch-banner-accent-bar" style="background:<?= e($activeBranchData['badge_color'] ?? 'var(--color-primary)') ?>;"></div>
          
          <div class="branch-banner-content">
            <div class="branch-banner-info">
              <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge badge-primary font-bold">
                  <?= e($activeBranchData['code']) ?>
                </span>
                <span class="badge badge-warning font-bold">
                  <?= e($activeBranchData['duration']) ?>
                </span>
                <span class="text-muted text-xs">
                  <?= e($activeBranchData['degree']) ?>
                </span>
              </div>

              <h3 class="branch-banner-title">
                <?= e($activeBranchData['name']) ?>
              </h3>

              <p class="branch-banner-desc">
                <?= e($activeBranchData['description']) ?>
              </p>

              <div class="branch-banner-metrics">
                <span><i class="fa-solid fa-users text-primary me-1"></i> Approved Intake: <strong><?= e((string)$activeBranchData['intake']) ?> Seats</strong></span>
                <span><i class="fa-solid fa-award text-accent me-1"></i> Affiliation: <strong>University of Kashmir</strong></span>
                <span><i class="fa-solid fa-book-bookmark text-success me-1"></i> Scheme: <strong>AICTE Model Curriculum</strong></span>
              </div>
            </div>

            <!-- Complete Scheme PDF Button -->
            <div class="branch-banner-action">
              <a href="<?= asset($activeBranchData['full_syllabus_file']) ?>" download class="btn btn-primary branch-banner-btn">
                <i class="fa-solid fa-file-pdf me-2 text-accent"></i>
                Download Complete Syllabus Booklet
              </a>
              <span class="branch-banner-note">
                <i class="fa-solid fa-circle-info"></i> Contains all semesters, course codes, lecture schemes & lab details.
              </span>
            </div>
          </div>
        </div>

        <!-- Semester Breakdown Tabs / Sub-filter -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
          <div>
            <h3 class="text-primary font-bold text-xl m-0">
              Semester-Wise Detailed Syllabus & Course Modules
            </h3>
            <span class="text-muted text-sm">
              Click "Download PDF" for the official syllabus sheet or review individual subjects below.
            </span>
          </div>

          <!-- Semester Filter Buttons -->
          <div class="d-flex flex-wrap gap-1" id="semFilterBar">
            <button type="button" class="btn btn-sm sem-filter-btn <?= ($selectedSemester === 0) ? 'btn-primary' : 'btn-outline' ?>" data-sem-target="0" onclick="filterSem(0)">
              All Semesters (<?= count($activeBranchData['semesters']) ?>)
            </button>
            <?php foreach ($activeBranchData['semesters'] as $semNum => $semInfo): ?>
              <button type="button" class="btn btn-sm sem-filter-btn <?= ($selectedSemester === $semNum) ? 'btn-primary' : 'btn-outline' ?>" data-sem-target="<?= $semNum ?>" onclick="filterSem(<?= $semNum ?>)">
                Sem <?= $semNum ?>
              </button>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Semester Cards Grid -->
        <div class="semester-cards-grid" id="semesterCardsContainer">
          <?php foreach ($activeBranchData['semesters'] as $semNum => $semInfo): 
            $matchesSearch = true;
            if ($searchQuery !== '') {
                $sq = strtolower($searchQuery);
                $matchesSearch = str_contains(strtolower($semInfo['name']), $sq)
                    || str_contains(strtolower($semInfo['credits']), $sq)
                    || str_contains(strtolower($activeBranchData['name']), $sq);
                if (!$matchesSearch) {
                    foreach ($semInfo['core_subjects'] as $sub) {
                        if (str_contains(strtolower($sub['title']), $sq) || str_contains(strtolower($sub['code']), $sq)) {
                            $matchesSearch = true;
                            break;
                        }
                    }
                }
            }
          ?>
            <div class="semester-card" data-sem="<?= $semNum ?>" style="display:<?= ($matchesSearch && ($selectedSemester === 0 || $selectedSemester === $semNum)) ? 'flex' : 'none' ?>;">
              
              <!-- Card Top Header -->
              <div class="semester-card-header">
                <div>
                  <span class="badge badge-secondary text-xs mb-1">
                    <?= e($semInfo['year']) ?>
                  </span>
                  <h4 class="text-primary font-bold text-base m-0">
                    <?= e($semInfo['name']) ?>
                  </h4>
                </div>
                <span class="badge badge-info font-bold">
                  <?= e($semInfo['credits']) ?>
                </span>
              </div>

              <!-- Course Subjects List -->
              <div class="semester-card-body">
                <span class="semester-card-label">
                  Core Curriculum Subjects & Labs:
                </span>

                <ul class="semester-subject-list">
                  <?php foreach ($semInfo['core_subjects'] as $sub): 
                    $typeClass = match($sub['type']) {
                        'Practical' => 'type-badge--practical',
                        'Elective' => 'type-badge--elective',
                        'Project' => 'type-badge--project',
                        'Humanities' => 'type-badge--humanities',
                        default => 'type-badge--default'
                    };
                  ?>
                    <li class="semester-subject-item">
                      <div class="semester-subject-info">
                        <span class="semester-subject-code">
                          <?= e($sub['code']) ?>
                        </span>
                        <span class="semester-subject-title" title="<?= e($sub['title']) ?>">
                          <?= e($sub['title']) ?>
                        </span>
                      </div>
                      <div class="semester-subject-meta">
                        <span class="type-badge <?= $typeClass ?>">
                          <?= e($sub['type']) ?>
                        </span>
                        <span class="text-muted text-xs font-bold">
                          <?= e((string)$sub['credits']) ?> Cr
                        </span>
                      </div>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>

              <!-- Card Action Footer -->
              <div class="semester-card-footer">
                <span class="text-muted text-xs d-flex align-items-center gap-1">
                  <i class="fa-solid fa-file-pdf text-danger"></i> PDF Format
                </span>

                <a href="<?= asset($semInfo['file']) ?>" download class="btn btn-primary btn-sm font-semibold">
                  <i class="fa-solid fa-download me-1"></i> Download Syllabus
                </a>
              </div>

            </div>
          <?php endforeach; ?>
        </div>

        <!-- Empty Search State -->
        <div id="noSyllabusMatches" class="empty-state-card">
          <i class="fa-solid fa-file-circle-question text-muted mb-3 empty-icon-lg"></i>
          <h4 class="text-primary font-bold text-lg mb-2">No Syllabi Matching Your Criteria</h4>
          <p class="text-muted text-sm mx-auto mb-4 max-w-450">
            We couldn't find any course modules matching your search keyword in this branch.
          </p>
          <button type="button" class="btn btn-primary btn-sm" onclick="clearSyllabusFilter()">
            Reset Semester & Search Filters
          </button>
        </div>

      </div>
    <?php endif; ?>

    <!-- INSTITUTIONAL PROSPECTUS & BROCHURES SECTION -->
    <?php if ($selectedCategory === 'all' || $selectedCategory === 'prospectus'): ?>
      <div id="prospectus-section" class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
          <div>
            <span class="section-subtitle">Institutional Publications</span>
            <h2 class="section-title text-left mb-1">Prospectus & Information Brochures</h2>
            <p class="text-muted text-sm m-0">
              Official brochures detailing campus infrastructure, B.Tech admission guidelines, fee structures, and scholarship criteria.
            </p>
          </div>
        </div>

        <div class="doc-card-grid">
          <?php foreach ($prospectusDownloads as $pDoc): ?>
            <div class="doc-card">
              <div class="doc-card-icon">
                <i class="fa-solid fa-book-bookmark"></i>
              </div>

              <div class="doc-card-body">
                <div class="d-flex align-items-center gap-2 mb-1">
                  <span class="badge badge-warning text-xs text-uppercase">Prospectus</span>
                  <span class="text-muted text-xs">• <?= e($pDoc['file_size']) ?></span>
                </div>

                <h4 class="doc-card-title">
                  <?= e($pDoc['title']) ?>
                </h4>

                <p class="doc-card-desc">
                  Published by the KCET Directorate of Admissions & Public Relations. Complete guide for prospective scholars and guardians.
                </p>

                <div class="doc-card-action">
                  <span class="text-muted text-xs">
                    <i class="fa-regular fa-calendar me-1"></i> <?= format_date($pDoc['publication_date']) ?>
                  </span>

                  <a href="<?= asset($pDoc['file_path']) ?>" download class="btn btn-primary btn-sm font-semibold">
                    <i class="fa-solid fa-download me-1"></i> Download PDF
                  </a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

    <!-- PRINTABLE ADMISSION & REGISTRATION FORMS SECTION -->
    <?php if ($selectedCategory === 'all' || $selectedCategory === 'forms'): ?>
      <div id="forms-section" class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
          <div>
            <span class="section-subtitle">Printable Documentation</span>
            <h2 class="section-title text-left mb-1">Offline Admission & Student Application Forms</h2>
            <p class="text-muted text-sm m-0">
              Download and print standard official forms. Duly filled forms must be submitted physically at the KCET Campus Admission Cell.
            </p>
          </div>
        </div>

        <div class="doc-card-grid">
          <?php foreach ($formDownloads as $fDoc): ?>
            <div class="doc-card flex-col justify-between">
              <div>
                <div class="d-flex justify-content-between align-items-start mb-2">
                  <span class="badge badge-info text-xs text-uppercase">Application Form</span>
                  <span class="text-muted text-xs font-semibold"><?= e($fDoc['file_size']) ?></span>
                </div>

                <h4 class="doc-card-title">
                  <?= e($fDoc['title']) ?>
                </h4>

                <p class="doc-card-desc">
                  Official standard printable PDF. Print on standard A4 bond paper, complete all mandatory applicant columns, and attach required testimonials.
                </p>
              </div>

              <div class="doc-card-action pt-3 border-top">
                <span class="text-muted text-xs">
                  <i class="fa-solid fa-file-pdf text-danger me-1"></i> Verified Form
                </span>

                <a href="<?= asset($fDoc['file_path']) ?>" download class="btn btn-outline btn-sm font-bold">
                  <i class="fa-solid fa-download me-1"></i> Download Form
                </a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <!-- Form Submission Notice Callout -->
        <div class="callout-box-info mt-4">
          <i class="fa-solid fa-circle-info text-primary text-xl"></i>
          <span>
            <strong>Offline Submission Desk:</strong> Duly completed application forms along with attested marks cards can be deposited directly at the <em>KCET Admission Cell, Ground Floor, Administrative Block, Ranbirgarh Narbal, Srinagar</em> on all working days from 9:30 AM to 4:30 PM.
          </span>
        </div>
      </div>
    <?php endif; ?>

    <!-- ACADEMIC CALENDARS, ORDINANCES & REGULATIONS SECTION -->
    <?php if ($selectedCategory === 'all' || $selectedCategory === 'circular'): ?>
      <div id="circular-section" class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
          <div>
            <span class="section-subtitle">Academic Governance</span>
            <h2 class="section-title text-left mb-1">Calendars, Examination Ordinances & Notifications</h2>
            <p class="text-muted text-sm m-0">
              Official session timelines, University of Kashmir grading schemes, passing standards, and anti-ragging codes of conduct.
            </p>
          </div>
        </div>

        <div class="card overflow-hidden">
          <div class="table-responsive">
            <table class="admin-table">
              <thead>
                <tr>
                  <th class="th-title-width">Circular / Regulation Title</th>
                  <th>Authority & Category</th>
                  <th>Format / Size</th>
                  <th>Effective Date</th>
                  <th class="text-right">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($circularDownloads as $cDoc): ?>
                  <tr>
                    <td>
                      <strong class="text-primary font-bold text-sm block mb-1">
                        <?= e($cDoc['title']) ?>
                      </strong>
                      <span class="text-muted text-xs">
                        Approved by Academic Council & Affiliated University
                      </span>
                    </td>
                    <td>
                      <span class="badge badge-secondary text-xs">ACADEMIC NOTIFICATION</span>
                    </td>
                    <td>
                      <span class="text-dark font-semibold text-sm"><?= e($cDoc['file_type']) ?></span>
                      <span class="text-muted text-xs">(<?= e($cDoc['file_size']) ?>)</span>
                    </td>
                    <td class="text-muted text-sm">
                      <?= format_date($cDoc['publication_date']) ?>
                    </td>
                    <td class="text-right">
                      <a href="<?= asset($cDoc['file_path']) ?>" download class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-download me-1"></i>
                        Download
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <!-- Academic Cell Advisory & Helpdesk Box -->
    <div class="academic-advisory-banner" style="background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);">
      <div class="advisory-bg-icon">
        <i class="fa-solid fa-graduation-cap"></i>
      </div>

      <div class="advisory-content">
        <span class="advisory-badge">
          Academic Support & Equivalency Inquiries
        </span>
        <h3 class="advisory-title">
          Need a Previous Batch Syllabus or Course Equivalency Certificate?
        </h3>
        <p class="advisory-desc">
          Students requiring archived curricula (prior scheme years), transcript verification, or course equivalency certificates for foreign university evaluations (WES/AIU) may connect with the KCET Academic Cell.
        </p>

        <div class="advisory-action-row">
          <a href="<?= url('/contact') ?>" class="btn btn-accent font-bold py-2 px-4">
            <i class="fa-solid fa-headset me-2"></i> Contact Academic Cell
          </a>
          <a href="tel:+918899412793" class="btn btn-outline text-white border-white-40 py-2 px-4">
            <i class="fa-solid fa-phone me-2"></i> Helpline: +91 88994 12793
          </a>
          <span class="text-slate-400 text-sm">
            Email: <strong class="text-white">info@kcet.edu.in</strong>
          </span>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- Client-side Interactive Filter Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('docSearchInput');
  const cards = document.querySelectorAll('.semester-card');
  const noMatchesBox = document.getElementById('noSyllabusMatches');
  let currentSemFilter = <?= (int)$selectedSemester ?>;

  function updateSemesterVisibility() {
    let visibleCount = 0;
    const query = searchInput ? searchInput.value.toLowerCase().trim() : '';

    cards.forEach(card => {
      const sem = parseInt(card.getAttribute('data-sem'), 10);
      const text = card.textContent.toLowerCase();
      
      const semMatches = (currentSemFilter === 0 || sem === currentSemFilter);
      const textMatches = (query === '' || text.includes(query));

      if (semMatches && textMatches) {
        card.style.display = 'flex';
        visibleCount++;
      } else {
        card.style.display = 'none';
      }
    });

    if (noMatchesBox) {
      noMatchesBox.style.display = (visibleCount === 0) ? 'block' : 'none';
    }
  }

  window.filterSem = function(sem) {
    currentSemFilter = sem;
    const buttons = document.querySelectorAll('.sem-filter-btn');
    buttons.forEach(btn => {
      const target = parseInt(btn.getAttribute('data-sem-target'), 10);
      if (target === sem) {
        btn.classList.add('btn-primary');
        btn.classList.remove('btn-outline');
      } else {
        btn.classList.remove('btn-primary');
        btn.classList.add('btn-outline');
      }
    });

    updateSemesterVisibility();
  };

  window.clearSyllabusFilter = function() {
    if (searchInput) searchInput.value = '';
    filterSem(0);
  };

  if (searchInput) {
    searchInput.addEventListener('input', function() {
      updateSemesterVisibility();
    });
  }
});
</script>
