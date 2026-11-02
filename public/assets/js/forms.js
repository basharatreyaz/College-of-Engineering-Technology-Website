/**
 * KCET Form Validation & Asynchronous Handlers
 */

document.addEventListener('DOMContentLoaded', function () {
  initEnquiryForms();
  initApplicationValidation();
});

/**
 * Handle Quick Enquiry Form Submissions (Inline & Modal)
 */
function initEnquiryForms() {
  const enquiryForms = document.querySelectorAll('.js-enquiry-form');

  enquiryForms.forEach(form => {
    form.addEventListener('submit', function (e) {
      const submitBtn = form.querySelector('button[type="submit"]');
      const errorBox = form.querySelector('.js-form-feedback');

      const nameInput = form.querySelector('input[name="full_name"]');
      const emailInput = form.querySelector('input[name="email"]');
      const phoneInput = form.querySelector('input[name="phone"]');

      if (!nameInput || !emailInput || !phoneInput) return;

      if (!nameInput.value.trim() || !emailInput.value.trim() || !phoneInput.value.trim()) {
        e.preventDefault();
        if (errorBox) {
          errorBox.innerHTML = '<div class="alert alert-danger" style="margin-bottom:1rem; padding:0.75rem 1rem; border-radius:var(--radius-md);"><i class="fa-solid fa-circle-exclamation" style="margin-right:0.35rem;"></i> Please fill in your name, email, and 10-digit phone number.</div>';
        }
        if (!nameInput.value.trim()) {
          nameInput.focus();
        } else if (!emailInput.value.trim()) {
          emailInput.focus();
        } else {
          phoneInput.focus();
        }
        return;
      }

      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin" style="margin-right:0.35rem;"></i> Submitting Enquiry...';
      }
    });
  });
}

/**
 * Client-Side Validation for Multi-Section Application Form
 */
function initApplicationValidation() {
  const appForm = document.getElementById('admissionsApplicationForm');
  if (!appForm) return;

  appForm.addEventListener('submit', function (e) {
    const requiredFields = appForm.querySelectorAll('[required]');
    let hasError = false;
    let firstErrorField = null;

    requiredFields.forEach(field => {
      if (!field.value.trim() || (field.type === 'checkbox' && !field.checked)) {
        hasError = true;
        field.style.borderColor = 'var(--color-danger)';
        if (!firstErrorField) firstErrorField = field;
      } else {
        field.style.borderColor = '';
      }
    });

    if (hasError) {
      e.preventDefault();
      const feedback = document.getElementById('appFormFeedback');
      if (feedback) {
        feedback.innerHTML = '<div class="alert alert-danger">Please complete all required fields and accept the confirmation consent.</div>';
      }
      if (firstErrorField) {
        firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
        firstErrorField.focus();
      }
    } else {
      const submitBtn = appForm.querySelector('button[type="submit"]');
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Registering Application...';
      }
    }
  });
}

/**
 * Print Application Summary
 */
function printApplicationReceipt() {
  window.print();
}

