/**
 * KCET Admin Panel JavaScript
 */

document.addEventListener('DOMContentLoaded', function () {
  initAdminSidebar();
  initDeleteConfirmations();
  initAutoSlug();
});

function initAdminSidebar() {
  const toggleBtn = document.querySelector('.admin-toggle-btn');
  const sidebar = document.querySelector('.admin-sidebar');

  if (!toggleBtn || !sidebar) return;

  toggleBtn.addEventListener('click', function () {
    sidebar.classList.toggle('open');
  });

  document.addEventListener('click', function (e) {
    if (window.innerWidth <= 992 && !sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
      sidebar.classList.remove('open');
    }
  });
}

function initDeleteConfirmations() {
  const deleteForms = document.querySelectorAll('.js-delete-form');
  deleteForms.forEach(form => {
    form.addEventListener('submit', function (e) {
      const confirmed = confirm('Are you sure you want to permanently delete this record? This action cannot be undone.');
      if (!confirmed) {
        e.preventDefault();
      }
    });
  });
}

function initAutoSlug() {
  const nameInputs = document.querySelectorAll('[data-slug-source]');
  nameInputs.forEach(input => {
    const targetSelector = input.getAttribute('data-slug-source');
    const target = document.querySelector(targetSelector);
    if (!target) return;

    input.addEventListener('input', function () {
      if (!target.dataset.manualEdit) {
        target.value = input.value
          .toLowerCase()
          .replace(/[^\w\s-]/g, '')
          .trim()
          .replace(/[\s_-]+/g, '-')
          .replace(/^-+|-+$/g, '');
      }
    });

    target.addEventListener('input', function () {
      target.dataset.manualEdit = 'true';
    });
  });
}

