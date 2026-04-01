// NovaVault Landing Page interactions
(() => {
  const year = document.getElementById('year');
  if (year) year.textContent = String(new Date().getFullYear());

  

  // Back to top behavior (edit these any time)
  const TOP_SCROLL_Y = 0;                 // set to e.g. 20 to stop slightly below the absolute top
  const TOP_SCROLL_BEHAVIOR = 'smooth';   // 'smooth' or 'auto'

  const backToTop = document.querySelector('.back-to-top');
  if (backToTop) {
    backToTop.addEventListener('click', (e) => {
      // Anchor-to-sticky-header can fail in some browsers; force the scroll.
      e.preventDefault();
      window.scrollTo({ top: TOP_SCROLL_Y, behavior: TOP_SCROLL_BEHAVIOR });
      // Optional: keep URL hash consistent
      history.replaceState(null, '', '#top');
    });
  }
// Mobile menu toggle
  const toggle = document.querySelector('.nav-toggle');
  const nav = document.getElementById('primary-nav');
  const header = document.querySelector('.site-header');

  function closeMenu() {
    if (!toggle || !nav) return;
    nav.classList.remove('is-open');
    toggle.setAttribute('aria-expanded', 'false');
    toggle.setAttribute('aria-label', 'Open menu');
  }

  if (toggle && nav) {
    toggle.addEventListener('click', () => {
      const isOpen = nav.classList.toggle('is-open');
      toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      toggle.setAttribute('aria-label', isOpen ? 'Close menu' : 'Open menu');
    });

    // Close on nav link click (mobile)
    nav.addEventListener('click', (e) => {
      const a = e.target.closest('a');
      if (a) closeMenu();
    });

    // Close on escape
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeMenu();
    });

    // Close on outside click (mobile)
    document.addEventListener('click', (e) => {
      if (!nav.classList.contains('is-open')) return;
      const within = nav.contains(e.target) || toggle.contains(e.target) || header.contains(e.target);
      if (!within) closeMenu();
    });
  }

  // Reveal on scroll
  const revealEls = Array.from(document.querySelectorAll('.reveal'));
  const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) entry.target.classList.add('is-visible');
    });
  }, { threshold: 0.10 });

  revealEls.forEach(el => revealObserver.observe(el));

  // Tabs
  const tabs = Array.from(document.querySelectorAll('.tab'));
  const panels = Array.from(document.querySelectorAll('[data-panel]'));

  function setActive(tabName) {
    tabs.forEach(t => {
      const active = t.dataset.tab === tabName;
      t.classList.toggle('is-active', active);
      t.setAttribute('aria-selected', active ? 'true' : 'false');
    });
    panels.forEach(p => p.classList.toggle('is-active', p.dataset.panel === tabName));
  }

  tabs.forEach(t => {
    t.addEventListener('click', () => setActive(t.dataset.tab));
  });

  // Scrollspy
  const links = Array.from(document.querySelectorAll('.nav-link'));
  const sections = links
    .map(a => document.querySelector(a.getAttribute('href')))
    .filter(Boolean);

  const spyObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      const id = '#' + entry.target.id;
      links.forEach(l => l.classList.toggle('is-active', l.getAttribute('href') === id));
    });
  }, { rootMargin: '-40% 0px -55% 0px', threshold: 0 });

  sections.forEach(sec => spyObserver.observe(sec));

  // Lightweight toast for demo form
  const toast = document.getElementById('toast');
  let toastTimer = null;

  function showToast(msg) {
    if (!toast) return;
    toast.textContent = msg;
    toast.classList.add('is-visible');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => toast.classList.remove('is-visible'), 2800);
  }

  document.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-toast]');
    if (!btn) return;
    showToast(btn.getAttribute('data-toast') || '');
  });
})();
