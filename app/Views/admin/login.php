<?php
/**
 * Admin Login View with Multi-Role Toggle
 */
?>

<!-- Role Toggle Segmented Control -->
<div class="role-toggle-group">
  <span class="role-toggle-label">Select Staff Access Role</span>
  <div class="role-toggle-bar" role="tablist" aria-label="Portal Role Selector">
    <button type="button" class="role-toggle-item active" data-role="superadmin" data-email="admin@kcet.edu.in" data-placeholder="admin@kcet.edu.in" data-desc="Institutional Super Admin (Full governance &amp; settings)" role="tab" aria-selected="true">
      <span><i class="fa-solid fa-user-shield role-icon-mr"></i>Super Admin</span>
      <span class="role-toggle-badge">Principal / IT</span>
    </button>
    <button type="button" class="role-toggle-item" data-role="admissions" data-email="admissions@kcet.edu.in" data-placeholder="admissions@kcet.edu.in" data-desc="Admissions Desk (Student applications &amp; enquiries)" role="tab" aria-selected="false">
      <span><i class="fa-solid fa-id-card role-icon-mr"></i>Admissions</span>
      <span class="role-toggle-badge">Enrollment</span>
    </button>
    <button type="button" class="role-toggle-item" data-role="editor" data-email="editor@kcet.edu.in" data-placeholder="editor@kcet.edu.in" data-desc="Academic Editor (Notices, events &amp; campus content)" role="tab" aria-selected="false">
      <span><i class="fa-solid fa-pen-to-square role-icon-mr"></i>Content Editor</span>
      <span class="role-toggle-badge">Faculty / Staff</span>
    </button>
  </div>
</div>

<!-- Active Role Description Strip -->
<div class="role-info-strip" id="roleInfoStrip">
  <span id="roleDescText">Access Mode: <strong>Super Admin</strong> (Full administrative privileges)</span>
  <button type="button" class="role-quick-fill" id="quickFillBtn" title="Fill demo credentials for testing">
    <i class="fa-solid fa-bolt role-icon-mr"></i>Quick Fill
  </button>
</div>

<form action="<?= url('/admin/login') ?>" method="POST" id="adminLoginForm">
  <?= csrf_field() ?>

  <!-- Hidden Role Field -->
  <input type="hidden" name="role" id="login_role" value="superadmin">

  <div class="form-group">
    <label class="form-label" for="login_email" id="emailLabel">Official Email Address</label>
    <input type="email" id="login_email" name="email" class="form-control" required placeholder="admin@kcet.edu.in" autofocus value="<?= e(old('email', '')) ?>">
  </div>

  <div class="form-group mb-4">
    <div class="form-actions--between mb-1">
      <label class="form-label mb-0" for="login_password">Password</label>
    </div>
    <div class="password-input-group">
      <input type="password" id="login_password" name="password" class="form-control" required placeholder="••••••••••••" autocomplete="current-password">
      <button type="button" class="password-visibility-btn" id="togglePasswordBtn" aria-label="Toggle password visibility" title="Show/Hide password">
        <i id="eyeIconOpen" class="fa-regular fa-eye"></i>
        <i id="eyeIconClosed" class="fa-regular fa-eye-slash d-none"></i>
      </button>
    </div>
  </div>

  <button type="submit" class="btn btn-primary btn-lg w-100 mb-3" id="submitLoginBtn">
    Sign In as Super Admin <i class="fa-solid fa-arrow-right-to-bracket role-icon-ml"></i>
  </button>

  <div class="text-center">
    <a href="<?= url('/') ?>" class="login-sublink">
      <i class="fa-solid fa-arrow-left role-icon-mr"></i> Return to KCET Public Website
    </a>
  </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const roleButtons = document.querySelectorAll('.role-toggle-item');
  const roleInput = document.getElementById('login_role');
  const emailInput = document.getElementById('login_email');
  const passwordInput = document.getElementById('login_password');
  const roleDescText = document.getElementById('roleDescText');
  const submitLoginBtn = document.getElementById('submitLoginBtn');
  const quickFillBtn = document.getElementById('quickFillBtn');
  const togglePasswordBtn = document.getElementById('togglePasswordBtn');
  const eyeIconOpen = document.getElementById('eyeIconOpen');
  const eyeIconClosed = document.getElementById('eyeIconClosed');

  // Role credentials dictionary for demo / verification convenience
  const rolePresets = {
    'superadmin': {
      label: 'Super Admin',
      desc: 'Institutional Super Admin (Full administrative privileges)',
      email: 'admin@kcet.edu.in',
      pass: 'Admin@KCET2026!'
    },
    'admissions': {
      label: 'Admissions Desk',
      desc: 'Admissions Officer (Student applications & enquiries)',
      email: 'admissions@kcet.edu.in',
      pass: 'Admissions@2026'
    },
    'editor': {
      label: 'Content Editor',
      desc: 'Academic Editor (Notices, events & campus content)',
      email: 'editor@kcet.edu.in',
      pass: 'Editor@KCET2026'
    }
  };

  let currentRole = 'superadmin';

  roleButtons.forEach(btn => {
    btn.addEventListener('click', function() {
      roleButtons.forEach(b => {
        b.classList.remove('active');
        b.setAttribute('aria-selected', 'false');
      });
      this.classList.add('active');
      this.setAttribute('aria-selected', 'true');

      currentRole = this.getAttribute('data-role');
      roleInput.value = currentRole;

      const preset = rolePresets[currentRole];
      if (preset) {
        roleDescText.innerHTML = `Access Mode: <strong>${preset.label}</strong>`;
        emailInput.placeholder = preset.email;
        submitLoginBtn.innerHTML = `Sign In as ${preset.label} <i class="fa-solid fa-arrow-right-to-bracket role-icon-ml"></i>`;
      }
    });
  });

  // Quick fill button
  quickFillBtn.addEventListener('click', function() {
    const preset = rolePresets[currentRole];
    if (preset) {
      emailInput.value = preset.email;
      passwordInput.value = preset.pass;
      passwordInput.focus();
    }
  });

  // Password visibility toggle
  togglePasswordBtn.addEventListener('click', function() {
    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      eyeIconOpen.classList.add('d-none');
      eyeIconClosed.classList.remove('d-none');
      togglePasswordBtn.setAttribute('title', 'Hide password');
    } else {
      passwordInput.type = 'password';
      eyeIconOpen.classList.remove('d-none');
      eyeIconClosed.classList.add('d-none');
      togglePasswordBtn.setAttribute('title', 'Show password');
    }
  });
});
</script>
