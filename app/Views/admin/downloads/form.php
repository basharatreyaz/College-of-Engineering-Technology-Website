<?php
/**
 * Admin Download Form (Create / Edit)
 */
$isEdit = !empty($download);
$action = $isEdit ? url('/admin/downloads/edit/' . $download['id']) : url('/admin/downloads');
?>

<div class="page-title-box">
  <div>
    <h1><?= $isEdit ? 'Edit Document' : 'Upload Document' ?></h1>
    <p class="admin-text-muted-sm">Upload course syllabus, branch & semester scheme, prospectus, or academic circulars.</p>
  </div>
  <a href="<?= url('/admin/downloads') ?>" class="btn btn-outline btn-sm">&larr; Back to Downloads</a>
</div>

<div class="admin-card">
  <div class="admin-card-body">
    <form action="<?= $action ?>" method="POST" enctype="multipart/form-data">
      <?= csrf_field() ?>

      <div class="form-row">
        <div class="form-group form-group--2">
          <label class="form-label" for="doc_title">Document Title *</label>
          <input type="text" id="doc_title" name="title" value="<?= e($download['title'] ?? '') ?>" class="form-control" required placeholder="e.g. B.Tech AI - Semester V Syllabus">
        </div>

        <div class="form-group form-group--1">
          <label class="form-label" for="category">Category *</label>
          <select id="category" name="category" class="form-control" required>
            <option value="syllabus" <?= (($download['category'] ?? '') === 'syllabus') ? 'selected' : '' ?>>B.Tech Syllabus</option>
            <option value="prospectus" <?= (($download['category'] ?? '') === 'prospectus') ? 'selected' : '' ?>>College Prospectus</option>
            <option value="forms" <?= (($download['category'] ?? '') === 'forms') ? 'selected' : '' ?>>Admission Forms</option>
            <option value="circular" <?= (($download['category'] ?? '') === 'circular') ? 'selected' : '' ?>>Calendar / Circular</option>
          </select>
        </div>

        <div class="form-group form-group--1">
          <label class="form-label" for="publication_date">Publication Date *</label>
          <input type="date" id="publication_date" name="publication_date" value="<?= e($download['publication_date'] ?? date('Y-m-d')) ?>" class="form-control" required>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group form-group--1">
          <label class="form-label" for="branch">Engineering Branch (If Syllabus)</label>
          <select id="branch" name="branch" class="form-control">
            <option value="all" <?= (($download['branch'] ?? 'all') === 'all') ? 'selected' : '' ?>>General / All Branches</option>
            <option value="common" <?= (($download['branch'] ?? '') === 'common') ? 'selected' : '' ?>>Common 1st Year (Applied Sciences)</option>
            <option value="ai" <?= (($download['branch'] ?? '') === 'ai') ? 'selected' : '' ?>>Artificial Intelligence Engineering (AI)</option>
            <option value="ce" <?= (($download['branch'] ?? '') === 'ce') ? 'selected' : '' ?>>Computer Engineering (CE)</option>
            <option value="civil" <?= (($download['branch'] ?? '') === 'civil') ? 'selected' : '' ?>>Civil Engineering (CIVIL)</option>
            <option value="it" <?= (($download['branch'] ?? '') === 'it') ? 'selected' : '' ?>>Information Technology (IT)</option>
            <option value="ece" <?= (($download['branch'] ?? '') === 'ece') ? 'selected' : '' ?>>Electronics & Communication (ECE)</option>
          </select>
        </div>

        <div class="form-group form-group--1">
          <label class="form-label" for="semester">Semester (If Syllabus)</label>
          <select id="semester" name="semester" class="form-control">
            <option value="0" <?= ((int)($download['semester'] ?? 0) === 0) ? 'selected' : '' ?>>All Semesters / Complete 4-Year Scheme</option>
            <option value="1" <?= ((int)($download['semester'] ?? 0) === 1) ? 'selected' : '' ?>>Semester I (1st Year)</option>
            <option value="2" <?= ((int)($download['semester'] ?? 0) === 2) ? 'selected' : '' ?>>Semester II (1st Year)</option>
            <option value="3" <?= ((int)($download['semester'] ?? 0) === 3) ? 'selected' : '' ?>>Semester III (2nd Year)</option>
            <option value="4" <?= ((int)($download['semester'] ?? 0) === 4) ? 'selected' : '' ?>>Semester IV (2nd Year)</option>
            <option value="5" <?= ((int)($download['semester'] ?? 0) === 5) ? 'selected' : '' ?>>Semester V (3rd Year)</option>
            <option value="6" <?= ((int)($download['semester'] ?? 0) === 6) ? 'selected' : '' ?>>Semester VI (3rd Year)</option>
            <option value="7" <?= ((int)($download['semester'] ?? 0) === 7) ? 'selected' : '' ?>>Semester VII (4th Year)</option>
            <option value="8" <?= ((int)($download['semester'] ?? 0) === 8) ? 'selected' : '' ?>>Semester VIII (4th Year)</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="file">Choose Document File (PDF, DOC, DOCX) <?= $isEdit ? '' : '*' ?></label>
        <input type="file" id="file" name="file" class="form-control" accept=".pdf,.doc,.docx" <?= $isEdit ? '' : 'required' ?>>
        <?php if (!empty($download['file_path'])): ?>
          <span class="form-helper d-block">Current file: <a href="<?= asset($download['file_path']) ?>" target="_blank" class="text-primary font-semibold"><?= e($download['file_path']) ?></a></span>
        <?php endif; ?>
      </div>

      <div class="form-toggle-wrap">
        <label class="form-check-label">
          <input type="checkbox" name="is_active" value="1" <?= (!isset($download['is_active']) || (int)$download['is_active'] === 1) ? 'checked' : '' ?>>
          <span class="form-check-text">Active in Downloads Directory</span>
        </label>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Save Changes' : 'Upload File' ?></button>
        <a href="<?= url('/admin/downloads') ?>" class="btn btn-outline">Cancel</a>
      </div>
    </form>
  </div>
</div>
