<?php
/**
 * Admin Faculty Form (Create / Edit)
 */
$isEdit = !empty($facultyMember);
$action = $isEdit ? url('/admin/faculty/edit/' . $facultyMember['id']) : url('/admin/faculty');
?>

<div class="page-title-box">
  <div>
    <h1><?= $isEdit ? 'Edit Faculty Member' : 'Add Faculty Member' ?></h1>
    <p class="admin-text-muted-sm">Update profile, academic qualifications, and research areas.</p>
  </div>
  <a href="<?= url('/admin/faculty') ?>" class="btn btn-outline btn-sm">&larr; Back to Faculty</a>
</div>

<div class="admin-card">
  <div class="admin-card-body">
    <form action="<?= $action ?>" method="POST" enctype="multipart/form-data">
      <?= csrf_field() ?>

      <div class="form-row">
        <div class="form-group form-group--2">
          <label class="form-label" for="fac_name">Full Name *</label>
          <input type="text" id="fac_name" name="name" value="<?= e($facultyMember['name'] ?? '') ?>" class="form-control" required data-slug-source="#fac_slug" placeholder="e.g. Dr. Shabir Hussain">
        </div>
        <div class="form-group form-group--1">
          <label class="form-label" for="fac_slug">Slug *</label>
          <input type="text" id="fac_slug" name="slug" value="<?= e($facultyMember['slug'] ?? '') ?>" class="form-control" required placeholder="dr-shabir-hussain">
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="fac_dept">Department *</label>
          <select id="fac_dept" name="department_id" class="form-control" required>
            <option value="">-- Select Department --</option>
            <?php foreach ($departments as $d): ?>
              <option value="<?= $d['id'] ?>" <?= (($facultyMember['department_id'] ?? 0) == $d['id']) ? 'selected' : '' ?>>
                <?= e($d['name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label" for="designation">Designation *</label>
          <input type="text" id="designation" name="designation" value="<?= e($facultyMember['designation'] ?? 'Assistant Professor') ?>" class="form-control" required>
        </div>

        <div class="form-group">
          <label class="form-label" for="qualification">Qualifications *</label>
          <input type="text" id="qualification" name="qualification" value="<?= e($facultyMember['qualification'] ?? '') ?>" class="form-control" required placeholder="Ph.D., M.Tech, B.Tech">
        </div>
      </div>

      <div class="form-row">
        <div class="form-group form-group--2">
          <label class="form-label" for="specialization">Area of Specialization / Research</label>
          <input type="text" id="specialization" name="specialization" value="<?= e($facultyMember['specialization'] ?? '') ?>" class="form-control" placeholder="e.g. Deep Learning, Structural Dynamics, Wireless IoT">
        </div>

        <div class="form-group form-group--1">
          <label class="form-label" for="email">Institutional Email</label>
          <input type="email" id="email" name="email" value="<?= e($facultyMember['email'] ?? '') ?>" class="form-control" placeholder="name@kcet.edu.in">
        </div>

        <div class="form-group form-group--1">
          <label class="form-label" for="display_order">Display Order</label>
          <input type="number" id="display_order" name="display_order" value="<?= e($facultyMember['display_order'] ?? '0') ?>" class="form-control">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="bio">Short Biography</label>
        <textarea id="bio" name="bio" class="form-control" rows="3"><?= e($facultyMember['bio'] ?? '') ?></textarea>
      </div>

      <!-- Faculty Photo / Profile Image Field -->
      <div class="form-group">
        <label class="form-label" for="photo">Faculty Profile Photo</label>
        <?php if (!empty($facultyMember['photo'])): ?>
          <div class="admin-photo-card">
            <?php if (file_exists(ROOT_PATH . '/public/' . ltrim($facultyMember['photo'], '/'))): ?>
              <img src="<?= asset($facultyMember['photo']) ?>" alt="Current Photo" class="admin-photo-card-img">
            <?php endif; ?>
            <div class="admin-photo-info">
              <div class="admin-photo-title">Current Photo:</div>
              <code class="admin-photo-path"><?= e($facultyMember['photo']) ?></code>
            </div>
            <label class="admin-photo-card-remove">
              <input type="checkbox" name="remove_photo" value="1">
              <span>Remove Photo</span>
            </label>
          </div>
        <?php endif; ?>

        <input type="file" id="photo" name="photo" class="form-control" accept="image/jpeg,image/png,image/webp,image/gif">
        <small class="form-hint">
          Upload portrait photo (JPG, PNG, WebP up to 5MB). Recommended aspect ratio: 1:1 square.
        </small>

        <!-- Live Instant Image Preview Container -->
        <div id="photoPreviewWrap" class="admin-preview-box">
          <img id="photoPreviewImg" src="" alt="Selected Photo Preview" class="admin-preview-avatar">
          <div>
            <span class="admin-preview-title">New Photo Selected</span>
            <span class="admin-preview-hint">Will be uploaded and saved on form submit.</span>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="cv_file">Curriculum Vitae (PDF Document)</label>
        <input type="file" id="cv_file" name="cv_file" class="form-control" accept=".pdf">
      </div>

      <div class="form-toggle-wrap">
        <label class="form-check-label">
          <input type="checkbox" name="is_active" value="1" <?= (!isset($facultyMember['is_active']) || (int)$facultyMember['is_active'] === 1) ? 'checked' : '' ?>>
          <span class="form-check-text">Active in Public Directory</span>
        </label>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Save Changes' : 'Add Member' ?></button>
        <a href="<?= url('/admin/faculty') ?>" class="btn btn-outline">Cancel</a>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const photoInput = document.getElementById('photo');
  const previewWrap = document.getElementById('photoPreviewWrap');
  const previewImg = document.getElementById('photoPreviewImg');

  if (photoInput && previewWrap && previewImg) {
    photoInput.addEventListener('change', function(e) {
      const file = e.target.files && e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(evt) {
          previewImg.src = evt.target.result;
          previewWrap.style.display = 'flex';
        };
        reader.readAsDataURL(file);
      } else {
        previewWrap.style.display = 'none';
      }
    });
  }
});
</script>
