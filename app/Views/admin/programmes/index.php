<?php
/**
 * Admin Programmes Index View
 */
?>

<div class="page-title-box">
  <div>
    <h1>Engineering Programmes</h1>
    <p class="admin-text-muted-sm">Manage B.Tech branches, curriculums, eligibility, and admission availability.</p>
  </div>
  <a href="<?= url('/admin/programmes/create') ?>" class="btn btn-primary btn-sm">+ Add New Programme</a>
</div>

<div class="admin-card">
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th class="table-col-thumb">Image</th>
          <th>Programme Name</th>
          <th>Department</th>
          <th>Degree / Duration</th>
          <th>Intake</th>
          <th>Admissions</th>
          <th>Status</th>
          <th class="text-right">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($programmes as $prog): ?>
        <tr>
          <td>
            <?php if (!empty($prog['featured_image'])): ?>
              <img src="<?= asset($prog['featured_image']) ?>" alt="<?= e($prog['name']) ?>" class="admin-thumb-img">
            <?php else: ?>
              <div class="admin-thumb-empty">
                <i class="fa-solid fa-image"></i>
              </div>
            <?php endif; ?>
          </td>
          <td>
            <strong class="admin-cell-title"><?= e($prog['name']) ?></strong>
            <span class="admin-cell-subtitle">Slug: <?= e($prog['slug']) ?></span>
          </td>
          <td><?= e($departments[$prog['department_id']] ?? 'N/A') ?></td>
          <td><?= e($prog['degree_type']) ?> &bull; <?= e($prog['duration']) ?></td>
          <td><?= e($prog['intake'] ?: 'Not specified') ?></td>
          <td>
            <span class="badge badge-<?= (int)$prog['is_admissions_open'] === 1 ? 'success' : 'muted' ?>">
              <?= (int)$prog['is_admissions_open'] === 1 ? 'Open' : 'Closed' ?>
            </span>
          </td>
          <td>
            <span class="badge badge-<?= (int)$prog['is_active'] === 1 ? 'success' : 'danger' ?>">
              <?= (int)$prog['is_active'] === 1 ? 'Active' : 'Inactive' ?>
            </span>
          </td>
          <td class="text-right">
            <div class="table-actions table-actions--right">
              <a href="<?= url('/admin/programmes/edit/' . $prog['id']) ?>" class="btn btn-outline btn-icon">Edit</a>
              <form action="<?= url('/admin/programmes/delete/' . $prog['id']) ?>" method="POST" class="js-delete-form d-inline">
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
