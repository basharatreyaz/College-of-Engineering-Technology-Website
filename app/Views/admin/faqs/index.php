<?php
/**
 * Admin FAQs Index View
 */
?>

<div class="page-title-box">
  <div>
    <h1>Frequently Asked Questions</h1>
    <p class="admin-text-muted-sm">Manage admissions and campus FAQs displayed across the website.</p>
  </div>
  <a href="<?= url('/admin/faqs/create') ?>" class="btn btn-primary btn-sm">+ Add FAQ</a>
</div>

<div class="admin-card">
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Question</th>
          <th>Category</th>
          <th>Order</th>
          <th>Status</th>
          <th class="text-right">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($faqs as $faq): ?>
        <tr>
          <td>
            <strong class="admin-cell-title"><?= e($faq['question']) ?></strong>
            <span class="admin-cell-subtitle"><?= truncate($faq['answer'], 80) ?></span>
          </td>
          <td><span class="badge badge-info"><?= strtoupper(e($faq['category'])) ?></span></td>
          <td><?= e($faq['display_order']) ?></td>
          <td>
            <span class="badge badge-<?= (int)$faq['is_active'] === 1 ? 'success' : 'danger' ?>">
              <?= (int)$faq['is_active'] === 1 ? 'Active' : 'Inactive' ?>
            </span>
          </td>
          <td class="text-right">
            <div class="table-actions table-actions--right">
              <a href="<?= url('/admin/faqs/edit/' . $faq['id']) ?>" class="btn btn-outline btn-icon">Edit</a>
              <form action="<?= url('/admin/faqs/delete/' . $faq['id']) ?>" method="POST" class="js-delete-form d-inline">
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
