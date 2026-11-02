/**
 * KCET Website - Main Vanilla JavaScript
 */

document.addEventListener('DOMContentLoaded', function () {
  initMobileNav();
  initFaqAccordion();
  initAdmissionModal();
  initVideoConsent();
  initEnquiryModal();
  initHeroVideo();
  initBackToTop();
  initQuickSearch();
});

/**
 * Accessible Mobile Navigation Drawer
 */
function initMobileNav() {
  const toggleBtn = document.querySelector('.mobile-nav-toggle');
  const drawer = document.querySelector('.mobile-drawer');
  const backdrop = document.querySelector('.drawer-backdrop');
  const closeBtn = document.querySelector('.drawer-close');

  if (!toggleBtn || !drawer || !backdrop) return;

  function openDrawer() {
    drawer.classList.add('active');
    backdrop.classList.add('active');
    toggleBtn.setAttribute('aria-expanded', 'true');
    drawer.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
    if (closeBtn) closeBtn.focus();
  }

  function closeDrawer() {
    drawer.classList.remove('active');
    backdrop.classList.remove('active');
    toggleBtn.setAttribute('aria-expanded', 'false');
    drawer.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
    toggleBtn.focus();
  }

  toggleBtn.addEventListener('click', openDrawer);
  if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
  backdrop.addEventListener('click', closeDrawer);

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && drawer.classList.contains('active')) {
      closeDrawer();
    }
  });
}

/**
 * FAQ Accordion with Keyboard Support
 */
function initFaqAccordion() {
  const headers = document.querySelectorAll('.accordion-header');

  headers.forEach(header => {
    header.addEventListener('click', function () {
      const item = this.parentElement;
      const isOpen = item.classList.contains('active');

      // Close other open accordions in the same group if desired
      document.querySelectorAll('.accordion-item.active').forEach(activeItem => {
        if (activeItem !== item) {
          activeItem.classList.remove('active');
          const h = activeItem.querySelector('.accordion-header');
          if (h) h.setAttribute('aria-expanded', 'false');
        }
      });

      if (isOpen) {
        item.classList.remove('active');
        this.setAttribute('aria-expanded', 'false');
      } else {
        item.classList.add('active');
        this.setAttribute('aria-expanded', 'true');
      }
    });

    header.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        this.click();
      }
    });
  });
}

/**
 * Dismissible Admission Announcement Modal (SessionStorage based)
 */
function initAdmissionModal() {
  const modal = document.getElementById('admissionAnnouncementModal');
  if (!modal) return;

  const storageKey = 'kcet_modal_dismissed_v1';
  let isDismissed = false;
  try {
    isDismissed = sessionStorage.getItem(storageKey);
  } catch (e) {}

  if (!isDismissed) {
    setTimeout(() => {
      const eqModal = document.getElementById('quickEnquiryModal');
      if (eqModal && eqModal.classList.contains('active')) return;

      modal.classList.add('active');
      modal.setAttribute('aria-hidden', 'false');
    }, 1200);
  }

  function closeModal() {
    modal.classList.remove('active');
    modal.setAttribute('aria-hidden', 'true');
    try {
      sessionStorage.setItem(storageKey, 'true');
    } catch (e) {}
    document.body.style.overflow = '';
  }

  const closeBtns = modal.querySelectorAll('[data-dismiss="modal"]');
  closeBtns.forEach(btn => btn.addEventListener('click', closeModal));

  modal.addEventListener('click', function (e) {
    if (e.target === modal) {
      closeModal();
    }
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && modal.classList.contains('active')) {
      closeModal();
    }
  });
}

/**
 * Campus Tour Video Consent Embed
 */
function initVideoConsent() {
  const loadBtn = document.getElementById('loadCampusTourBtn');
  const container = document.getElementById('videoTourContainer');

  if (!loadBtn || !container) return;

  loadBtn.addEventListener('click', function () {
    const videoUrl = this.getAttribute('data-video-url');
    if (!videoUrl) return;

    container.innerHTML = `
      <iframe 
        width="100%" 
        height="100%" 
        src="${videoUrl}?autoplay=1&rel=0" 
        title="KCET Campus Tour Video" 
        frameborder="0" 
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
        allowfullscreen
        style="width:100%; height:100%; border:none;">
      </iframe>
    `;
  });
}

/**
 * Quick Admission Enquiry Modal Functions
 */
function openQuickEnquiryModal(programmeId) {
  const modal = document.getElementById('quickEnquiryModal');
  if (!modal) return;

  // Close announcement modal if active to prevent overlapping
  const annModal = document.getElementById('admissionAnnouncementModal');
  if (annModal) {
    annModal.classList.remove('active');
    annModal.setAttribute('aria-hidden', 'true');
  }

  if (programmeId) {
    const select = modal.querySelector('select[name="programme_id"]');
    if (select) select.value = programmeId;
  }

  modal.classList.add('active');
  modal.setAttribute('aria-hidden', 'false');
  document.body.style.overflow = 'hidden';

  const nameInput = modal.querySelector('#eq_full_name');
  if (nameInput) {
    setTimeout(function () { nameInput.focus(); }, 150);
  }
}

function closeQuickEnquiryModal() {
  const modal = document.getElementById('quickEnquiryModal');
  if (!modal) return;
  modal.classList.remove('active');
  modal.setAttribute('aria-hidden', 'true');
  document.body.style.overflow = '';
}

window.openQuickEnquiryModal = openQuickEnquiryModal;
window.closeQuickEnquiryModal = closeQuickEnquiryModal;

function initEnquiryModal() {
  const modal = document.getElementById('quickEnquiryModal');
  const triggers = document.querySelectorAll('[data-open-enquiry-modal]');

  if (!modal) return;

  triggers.forEach(trigger => {
    trigger.addEventListener('click', function (e) {
      e.preventDefault();
      const progId = this.getAttribute('data-programme-id');
      openQuickEnquiryModal(progId);
    });
  });

  const closeBtns = modal.querySelectorAll('[data-dismiss="enquiry-modal"]');
  closeBtns.forEach(btn => btn.addEventListener('click', closeQuickEnquiryModal));

  modal.addEventListener('click', function (e) {
    if (e.target === modal) closeQuickEnquiryModal();
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && modal.classList.contains('active')) {
      closeQuickEnquiryModal();
    }
  });
}

/**
 * Hero Background Video Controller & Responsive Fit
 */
function initHeroVideo() {
  const iframe = document.getElementById('heroBgVideo');
  const container = document.querySelector('.hero');
  const toggleBtn = document.getElementById('heroVideoToggle');

  if (!iframe || !container) return;

  function resizeVideo() {
    const cw = container.offsetWidth;
    const ch = container.offsetHeight;
    if (!cw || !ch) return;

    const containerRatio = cw / ch;
    const videoRatio = 16 / 9;

    // Scale by 1.25 to prevent letterboxing and push YouTube UI offscreen
    if (containerRatio < videoRatio) {
      const newWidth = Math.ceil(ch * videoRatio * 1.25);
      const newHeight = Math.ceil(ch * 1.25);
      iframe.style.width = newWidth + 'px';
      iframe.style.height = newHeight + 'px';
    } else {
      const newWidth = Math.ceil(cw * 1.25);
      const newHeight = Math.ceil((cw / videoRatio) * 1.25);
      iframe.style.width = newWidth + 'px';
      iframe.style.height = newHeight + 'px';
    }
  }

  window.addEventListener('resize', resizeVideo);
  resizeVideo();
  setTimeout(resizeVideo, 350);

  if (toggleBtn) {
    let isPlaying = true;

    toggleBtn.addEventListener('click', function () {
      if (isPlaying) {
        iframe.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
        toggleBtn.innerHTML = '<i class="fa-solid fa-play"></i> <span class="video-toggle-label">Play Video</span>';
        toggleBtn.setAttribute('aria-label', 'Play background video');
        toggleBtn.title = 'Play background video';
        isPlaying = false;
      } else {
        iframe.contentWindow.postMessage('{"event":"command","func":"playVideo","args":""}', '*');
        toggleBtn.innerHTML = '<i class="fa-solid fa-pause"></i> <span class="video-toggle-label">Pause Video</span>';
        toggleBtn.setAttribute('aria-label', 'Pause background video');
        toggleBtn.title = 'Pause background video';
        isPlaying = true;
      }
    });

    // Respect user's system accessibility preference for reduced motion
    if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
      iframe.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
      toggleBtn.innerHTML = '<i class="fa-solid fa-play"></i> <span class="video-toggle-label">Play Video</span>';
      toggleBtn.setAttribute('aria-label', 'Play background video');
      toggleBtn.title = 'Play background video';
      isPlaying = false;
    }
  }
}

/**
 * Back to Top Floating Button
 */
function initBackToTop() {
  const btn = document.getElementById('btnBackToTop');
  if (!btn) return;

  window.addEventListener('scroll', function () {
    if (window.scrollY > 300) {
      btn.classList.add('visible');
    } else {
      btn.classList.remove('visible');
    }
  }, { passive: true });

  btn.addEventListener('click', function () {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
}

/**
 * Spotlight Quick Search Modal (Ctrl+K)
 */
function openSearchModal() {
  const modal = document.getElementById('quickSearchModal');
  const input = document.getElementById('quickSearchInput');
  if (!modal) return;

  modal.classList.add('active');
  modal.setAttribute('aria-hidden', 'false');
  document.body.style.overflow = 'hidden';
  if (input) {
    input.value = '';
    filterSearchResults('');
    setTimeout(() => input.focus(), 120);
  }
}

function closeSearchModal() {
  const modal = document.getElementById('quickSearchModal');
  if (!modal) return;
  modal.classList.remove('active');
  modal.setAttribute('aria-hidden', 'true');
  document.body.style.overflow = '';
}

window.openSearchModal = openSearchModal;
window.closeSearchModal = closeSearchModal;

function filterSearchResults(query) {
  const items = document.querySelectorAll('.search-result-item');
  const q = query.toLowerCase().trim();

  items.forEach(item => {
    const text = (item.getAttribute('data-search-term') || item.textContent).toLowerCase();
    if (!q || text.includes(q)) {
      item.style.display = 'flex';
    } else {
      item.style.display = 'none';
    }
  });
}

function initQuickSearch() {
  const modal = document.getElementById('quickSearchModal');
  const input = document.getElementById('quickSearchInput');
  if (!modal) return;

  modal.addEventListener('click', function (e) {
    if (e.target === modal) closeSearchModal();
  });

  if (input) {
    input.addEventListener('input', function () {
      filterSearchResults(this.value);
    });
  }

  document.addEventListener('keydown', function (e) {
    if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
      e.preventDefault();
      if (modal.classList.contains('active')) {
        closeSearchModal();
      } else {
        openSearchModal();
      }
    }
    if (e.key === 'Escape' && modal.classList.contains('active')) {
      closeSearchModal();
    }
  });
}


