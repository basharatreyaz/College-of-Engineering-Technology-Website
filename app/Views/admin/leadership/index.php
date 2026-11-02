<?php
/**
 * Admin Leadership Messages View (Chairman, Director & Principal)
 */
?>

<div class="page-title-box">
  <div>
    <h1>Institutional Leadership Messages</h1>
    <p class="admin-meta-text">
      Manage the official messages, inspiring quotes, designations, and portrait photos of the Chairman, Director, and Principal.
    </p>
  </div>
</div>

<form action="<?= url('/admin/leadership') ?>" method="POST" enctype="multipart/form-data">
  <?= csrf_field() ?>

  <!-- 1. Chairman's Message Card -->
  <div class="admin-card admin-card--primary-top">
    <div class="admin-card-header admin-card-header--subtle">
      <div class="d-flex align-items-center gap-3">
        <span class="admin-icon-box">
          <i class="fa-solid fa-user-tie"></i>
        </span>
        <div>
          <h2 class="admin-card-title text-primary text-lg m-0">From the Chairman's Desk</h2>
          <span class="text-muted text-xs">Trustee &amp; Governing Body Vision</span>
        </div>
      </div>
      <div class="d-flex align-items-center gap-2">
        <a href="<?= url('/chairmans-message') ?>" target="_blank" class="btn btn-outline text-xs py-1 px-3 bg-white">
          <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> View Dedicated Page
        </a>
        <span class="badge badge-info">Governing Council</span>
      </div>
    </div>

    <div class="admin-card-body">
      <div class="form-row">
        <div class="form-group flex-2">
          <label class="form-label" for="chairman_name">Chairman Full Name *</label>
          <input type="text" id="chairman_name" name="chairman_name" value="<?= e($leadership['chairman_name'] ?? '') ?>" class="form-control" required placeholder="e.g. Er. Raja Aijaz Ali (Retd. IPS / IGP)">
        </div>
        <div class="form-group flex-2">
          <label class="form-label" for="chairman_designation">Official Designation *</label>
          <input type="text" id="chairman_designation" name="chairman_designation" value="<?= e($leadership['chairman_designation'] ?? '') ?>" class="form-control" required placeholder="e.g. Chairman, Kashmir College of Engineering & Technology">
        </div>
      </div>

      <!-- Chairman Photo Upload -->
      <div class="form-group">
        <label class="form-label" for="chairman_photo">Chairman Portrait Photo</label>
        <?php if (!empty($leadership['chairman_photo'])): ?>
          <div class="admin-photo-card">
            <?php if (file_exists(ROOT_PATH . '/public/' . ltrim($leadership['chairman_photo'], '/'))): ?>
              <img src="<?= asset($leadership['chairman_photo']) ?>" alt="Chairman Photo" class="admin-photo-card-img">
            <?php endif; ?>
            <div class="overflow-hidden">
              <div class="text-xs font-semibold text-dark">Current Photo:</div>
              <code class="text-xs text-muted break-all"><?= e($leadership['chairman_photo']) ?></code>
            </div>
            <label class="admin-photo-card-remove">
              <input type="checkbox" name="remove_chairman_photo" value="1">
              <span>Remove Photo</span>
            </label>
          </div>
        <?php endif; ?>

        <input type="file" id="chairman_photo" name="chairman_photo" class="form-control" accept="image/jpeg,image/png,image/webp,image/gif">
        <small class="admin-meta-text mt-1 block">
          Upload high-resolution portrait (JPG, PNG, WebP up to 5MB).
        </small>
        <div id="chairmanPreviewWrap" class="admin-preview-box">
          <img id="chairmanPreviewImg" src="" alt="Preview" class="admin-preview-avatar">
          <span class="text-primary font-semibold text-sm">Selected for upload</span>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="chairman_quote">Key Inspiring Quote (Featured Highlight)</label>
        <textarea id="chairman_quote" name="chairman_quote" class="form-control" rows="2" placeholder="Brief inspiring message summary or quote..."><?= e($leadership['chairman_quote'] ?? '') ?></textarea>
      </div>

      <div class="form-group">
        <label class="form-label" for="chairman_message">Full Address / Detailed Message *</label>
        <textarea id="chairman_message" name="chairman_message" class="form-control" rows="5" required placeholder="Detailed institutional message from the Chairman..."><?= e($leadership['chairman_message'] ?? '') ?></textarea>
      </div>
    </div>
  </div>

  <!-- 2. Director's Message Card -->
  <div class="admin-card admin-card--primary-top">
    <div class="admin-card-header admin-card-header--subtle">
      <div class="d-flex align-items-center gap-3">
        <span class="admin-icon-box">
          <i class="fa-solid fa-building-columns"></i>
        </span>
        <div>
          <h2 class="admin-card-title text-primary text-lg m-0">From the Director's Desk</h2>
          <span class="text-muted text-xs">Administrative &amp; Infrastructure Leadership</span>
        </div>
      </div>
      <div class="d-flex align-items-center gap-2">
        <a href="<?= url('/directors-message') ?>" target="_blank" class="btn btn-outline text-xs py-1 px-3 bg-white">
          <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> View Dedicated Page
        </a>
        <span class="badge badge-success">Administration</span>
      </div>
    </div>

    <div class="admin-card-body">
      <div class="form-row">
        <div class="form-group flex-2">
          <label class="form-label" for="director_name">Director Full Name *</label>
          <input type="text" id="director_name" name="director_name" value="<?= e($leadership['director_name'] ?? '') ?>" class="form-control" required placeholder="e.g. Er. Raja Minad Aijaz">
        </div>
        <div class="form-group flex-2">
          <label class="form-label" for="director_designation">Official Designation *</label>
          <input type="text" id="director_designation" name="director_designation" value="<?= e($leadership['director_designation'] ?? '') ?>" class="form-control" required placeholder="e.g. Director / Director of Administration, KCET">
        </div>
      </div>

      <!-- Director Photo Upload -->
      <div class="form-group">
        <label class="form-label" for="director_photo">Director Portrait Photo</label>
        <?php if (!empty($leadership['director_photo'])): ?>
          <div class="admin-photo-card">
            <?php if (file_exists(ROOT_PATH . '/public/' . ltrim($leadership['director_photo'], '/'))): ?>
              <img src="<?= asset($leadership['director_photo']) ?>" alt="Director Photo" class="admin-photo-card-img">
            <?php endif; ?>
            <div class="overflow-hidden">
              <div class="text-xs font-semibold text-dark">Current Photo:</div>
              <code class="text-xs text-muted break-all"><?= e($leadership['director_photo']) ?></code>
            </div>
            <label class="admin-photo-card-remove">
              <input type="checkbox" name="remove_director_photo" value="1">
              <span>Remove Photo</span>
            </label>
          </div>
        <?php endif; ?>

        <input type="file" id="director_photo" name="director_photo" class="form-control" accept="image/jpeg,image/png,image/webp,image/gif">
        <small class="admin-meta-text mt-1 block">
          Upload high-resolution portrait (JPG, PNG, WebP up to 5MB).
        </small>
        <div id="directorPreviewWrap" class="admin-preview-box">
          <img id="directorPreviewImg" src="" alt="Preview" class="admin-preview-avatar">
          <span class="text-primary font-semibold text-sm">Selected for upload</span>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="director_quote">Key Inspiring Quote (Featured Highlight)</label>
        <textarea id="director_quote" name="director_quote" class="form-control" rows="2" placeholder="Brief inspiring message summary or quote..."><?= e($leadership['director_quote'] ?? '') ?></textarea>
      </div>

      <div class="form-group">
        <label class="form-label" for="director_message">Full Address / Detailed Message *</label>
        <textarea id="director_message" name="director_message" class="form-control" rows="5" required placeholder="Detailed institutional message from the Director..."><?= e($leadership['director_message'] ?? '') ?></textarea>
      </div>
    </div>
  </div>

  <!-- 3. Principal's Message Card -->
  <div class="admin-card admin-card--primary-top">
    <div class="admin-card-header admin-card-header--subtle">
      <div class="d-flex align-items-center gap-3">
        <span class="admin-icon-box">
          <i class="fa-solid fa-graduation-cap"></i>
        </span>
        <div>
          <h2 class="admin-card-title text-primary text-lg m-0">From the Principal's Desk</h2>
          <span class="text-muted text-xs">Academic Excellence &amp; Campus Leadership</span>
        </div>
      </div>
      <div class="d-flex align-items-center gap-2">
        <a href="<?= url('/principals-message') ?>" target="_blank" class="btn btn-outline text-xs py-1 px-3 bg-white">
          <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> View Dedicated Page
        </a>
        <span class="badge badge-warning">Academic Head</span>
      </div>
    </div>

    <div class="admin-card-body">
      <div class="form-row">
        <div class="form-group flex-2">
          <label class="form-label" for="principal_name">Principal Full Name *</label>
          <input type="text" id="principal_name" name="principal_name" value="<?= e($leadership['principal_name'] ?? '') ?>" class="form-control" required placeholder="e.g. Dr. Syed Jalal Ahmad">
        </div>
        <div class="form-group flex-1-5">
          <label class="form-label" for="principal_designation">Designation *</label>
          <input type="text" id="principal_designation" name="principal_designation" value="<?= e($leadership['principal_designation'] ?? '') ?>" class="form-control" required placeholder="Principal & Professor of Engineering">
        </div>
        <div class="form-group flex-1-5">
          <label class="form-label" for="principal_qualifications">Academic Qualifications</label>
          <input type="text" id="principal_qualifications" name="principal_qualifications" value="<?= e($leadership['principal_qualifications'] ?? '') ?>" class="form-control" placeholder="e.g. Ph.D. (IIT Delhi), M.Tech, B.E.">
        </div>
      </div>

      <!-- Principal Photo Upload -->
      <div class="form-group">
        <label class="form-label" for="principal_photo">Principal Portrait Photo</label>
        <?php if (!empty($leadership['principal_photo'])): ?>
          <div class="admin-photo-card">
            <?php if (file_exists(ROOT_PATH . '/public/' . ltrim($leadership['principal_photo'], '/'))): ?>
              <img src="<?= asset($leadership['principal_photo']) ?>" alt="Principal Photo" class="admin-photo-card-img">
            <?php endif; ?>
            <div class="overflow-hidden">
              <div class="text-xs font-semibold text-dark">Current Photo:</div>
              <code class="text-xs text-muted break-all"><?= e($leadership['principal_photo']) ?></code>
            </div>
            <label class="admin-photo-card-remove">
              <input type="checkbox" name="remove_principal_photo" value="1">
              <span>Remove Photo</span>
            </label>
          </div>
        <?php endif; ?>

        <input type="file" id="principal_photo" name="principal_photo" class="form-control" accept="image/jpeg,image/png,image/webp,image/gif,image/svg+xml">
        <small class="admin-meta-text mt-1 block">
          Upload high-resolution portrait (JPG, PNG, WebP or SVG up to 5MB).
        </small>
        <div id="principalPreviewWrap" class="admin-preview-box">
          <img id="principalPreviewImg" src="" alt="Preview" class="admin-preview-avatar">
          <span class="text-primary font-semibold text-sm">Selected for upload</span>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="principal_quote">Key Inspiring Quote (Featured on Homepage)</label>
        <textarea id="principal_quote" name="principal_quote" class="form-control" rows="2" placeholder="Inspiring quote highlighted in italics on homepage..."><?= e($leadership['principal_quote'] ?? '') ?></textarea>
      </div>

      <div class="form-group">
        <label class="form-label" for="principal_message">Full Address / Detailed Message *</label>
        <textarea id="principal_message" name="principal_message" class="form-control" rows="5" required placeholder="Detailed message from the Principal..."><?= e($leadership['principal_message'] ?? '') ?></textarea>
      </div>
    </div>
  </div>

  <!-- Sticky Save Bar -->
  <div class="admin-sticky-bar">
    <span class="admin-meta-text">Updates reflect immediately on the Homepage and About page.</span>
    <button type="submit" class="btn btn-primary btn-lg">
      <i class="fa-solid fa-floppy-disk me-2"></i> Save All Leadership Messages
    </button>
  </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
  function setupPreview(inputId, wrapId, imgId) {
    const input = document.getElementById(inputId);
    const wrap = document.getElementById(wrapId);
    const img = document.getElementById(imgId);
    if (!input || !wrap || !img) return;

    input.addEventListener('change', function(e) {
      const file = e.target.files && e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(evt) {
          img.src = evt.target.result;
          wrap.style.display = 'flex';
        };
        reader.readAsDataURL(file);
      } else {
        wrap.style.display = 'none';
      }
    });
  }

  setupPreview('chairman_photo', 'chairmanPreviewWrap', 'chairmanPreviewImg');
  setupPreview('director_photo', 'directorPreviewWrap', 'directorPreviewImg');
  setupPreview('principal_photo', 'principalPreviewWrap', 'principalPreviewImg');
});
</script>
