<?php
/**
 * Admin Downloads Index View
 */
?>

<div class="page-title-box">
  <div>
    <h1>Downloads & Syllabi</h1>
    <p class="admin-text-muted-sm">Manage downloadable syllabus PDFs, branch & semester schemes, prospectus, and offline forms.</p>
  </div>
  <a href="<?= url('/admin/downloads/create') ?>" class="btn btn-primary btn-sm">+ Upload Document</a>
</div>

<div class="admin-card">
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Document Title</th>
          <th>Category</th>
          <th>Branch & Semester</th>
          <th>File Format / Size</th>
          <th>Date</th>
          <th>Status</th>
          <th class="text-right">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($downloads as $doc): ?>
        <tr>
          <td>
            <strong class="admin-cell-title"><?= e($doc['title']) ?></strong>
            <span class="admin-cell-subtitle"><?= e($doc['file_path']) ?></span>
          </td>
          <td><span class="badge badge-info"><?= strtoupper(e($doc['category'])) ?></span></td>
          <td>
            <?php if (!empty($doc['branch']) && $doc['branch'] !== 'all'): ?>
              <span class="badge badge-primary admin-cell-badge"><?= strtoupper(e($doc['branch'])) ?></span>
            <?php endif; ?>
            <?php if (!empty($doc['semester']) && (int)$doc['semester'] > 0): ?>
              <span class="badge badge-secondary admin-cell-badge">Sem <?= (int)$doc['semester'] ?></span>
            <?php elseif ($doc['category'] === 'syllabus'): ?>
              <span class="badge badge-secondary admin-cell-badge">All Semesters</span>
            <?php endif; ?>
          </td>
          <td><?= e($doc['file_type']) ?> <?= !empty($doc['file_size']) ? '(' . e($doc['file_size']) . ')' : '' ?></td>
          <td><?= format_date($doc['publication_date']) ?></td>
          <td>
            <span class="badge badge-<?= (int)$doc['is_active'] === 1 ? 'success' : 'danger' ?>">
              <?= (int)$doc['is_active'] === 1 ? 'Active' : 'Inactive' ?>
            </span>
          </td>
          <td class="text-right">
            <div class="table-actions table-actions--right">
              <a href="<?= asset($doc['file_path']) ?>" target="_blank" class="btn btn-outline btn-icon" title="View file"><i class="fa-solid fa-eye"></i></a>
              <a href="<?= url('/admin/downloads/edit/' . $doc['id']) ?>" class="btn btn-outline btn-icon">Edit</a>
              <form action="<?= url('/admin/downloads/delete/' . $doc['id']) ?>" method="POST" class="js-delete-form d-inline">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-outline btn-icon btn-delete">Delete</button>
              </form>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
