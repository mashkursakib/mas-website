/* ============================================================
   MAS Consultancy — main interactions
   Navbar + scrollspy, mobile drawer, animated counters,
   scroll reveal, firm tabs, concern switcher, FAQ accordion,
   blog rendering + filters, contact + newsletter forms.
   No dependencies. Safe to load on every page.
   ============================================================ */
(function () {
  'use strict';

  const $ = (sel, ctx) => (ctx || document).querySelector(sel);
  const $$ = (sel, ctx) => Array.from((ctx || document).querySelectorAll(sel));
  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ---------- Footer year ---------- */
  const yearEl = $('#year');
  if (yearEl) yearEl.textContent = new Date().getFullYear();

  /* ---------- Navbar: scrolled state + back-to-top ---------- */
  const navbar = $('#navbar');
  const backToTop = $('#backToTop');
  const onScroll = () => {
    const y = window.scrollY;
    if (navbar) navbar.classList.toggle('scrolled', y > 40);
    if (backToTop) backToTop.classList.toggle('show', y > 600);
  };
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();
  if (backToTop) backToTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: prefersReducedMotion ? 'auto' : 'smooth' }));

  /* ---------- Scrollspy (highlights the section in view) ---------- */
  const spyLinks = $$('.nav-links a[data-spy]');
  if (spyLinks.length && 'IntersectionObserver' in window) {
    const spyObserver = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        spyLinks.forEach((link) => link.classList.toggle('active', link.dataset.spy === entry.target.id));
      });
    }, { rootMargin: '-40% 0px -55% 0px' });
    spyLinks.forEach((link) => {
      const section = document.getElementById(link.dataset.spy);
      if (section) spyObserver.observe(section);
    });
  }

  /* ---------- Mobile drawer ---------- */
  const hamburger = $('#hamburger');
  const mobileMenu = $('#mobileMenu');
  const mobileClose = $('#mobileClose');
  const overlay = $('#menuOverlay');
  const openMenu = (open) => {
    if (!mobileMenu) return;
    mobileMenu.classList.toggle('open', open);
    if (overlay) overlay.classList.toggle('show', open);
    mobileMenu.setAttribute('aria-hidden', String(!open));
    if (hamburger) hamburger.setAttribute('aria-expanded', String(open));
    document.body.style.overflow = open ? 'hidden' : '';
  };
  if (hamburger) hamburger.addEventListener('click', () => openMenu(true));
  if (mobileClose) mobileClose.addEventListener('click', () => openMenu(false));
  if (overlay) overlay.addEventListener('click', () => openMenu(false));
  $$('#mobileMenu a').forEach((a) => a.addEventListener('click', () => openMenu(false)));
  document.addEventListener('keydown', (e) => { if (e.key === 'Escape') openMenu(false); });

  /* ---------- Scroll reveal ---------- */
  const revealEls = $$('.reveal');
  if ('IntersectionObserver' in window && !prefersReducedMotion) {
    const revealObserver = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          revealObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12 });
    revealEls.forEach((el) => revealObserver.observe(el));
  } else {
    revealEls.forEach((el) => el.classList.add('visible'));
  }

  /* ---------- Animated counters ---------- */
  const counters = $$('.counter');
  const animateCounter = (el) => {
    const target = parseInt(el.dataset.target, 10);
    if (isNaN(target)) return;
    if (prefersReducedMotion) { el.textContent = target; return; }
    const duration = 1600;
    const start = performance.now();
    const tick = (now) => {
      const p = Math.min((now - start) / duration, 1);
      const eased = 1 - Math.pow(1 - p, 3); // ease-out cubic
      el.textContent = Math.round(target * eased);
      if (p < 1) requestAnimationFrame(tick);
    };
    requestAnimationFrame(tick);
  };
  if (counters.length && 'IntersectionObserver' in window) {
    const counterObserver = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          animateCounter(entry.target);
          counterObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.5 });
    counters.forEach((el) => counterObserver.observe(el));
  } else {
    counters.forEach(animateCounter);
  }

  /* ---------- Firm tabs ---------- */
  const tabBtns = $$('.tab-btn');
  tabBtns.forEach((btn) => btn.addEventListener('click', () => {
    tabBtns.forEach((b) => { b.classList.remove('active'); b.setAttribute('aria-selected', 'false'); });
    btn.classList.add('active');
    btn.setAttribute('aria-selected', 'true');
    $$('.tab-panel').forEach((panel) => panel.classList.toggle('active', panel.id === btn.dataset.tab));
  }));

  /* ---------- Concern switcher ---------- */
  const concernBtns = $$('.concern-btn');
  concernBtns.forEach((btn) => btn.addEventListener('click', () => {
    concernBtns.forEach((b) => { b.classList.remove('active'); b.setAttribute('aria-selected', 'false'); });
    btn.classList.add('active');
    btn.setAttribute('aria-selected', 'true');
    $$('.concern-panel').forEach((panel) => panel.classList.toggle('active', panel.id === btn.dataset.concern));
  }));

  /* ---------- FAQ accordion (one open at a time) ---------- */
  $$('.faq-item').forEach((item) => {
    const btn = $('.faq-q', item);
    const answer = $('.faq-a', item);
    if (!btn || !answer) return;
    btn.addEventListener('click', () => {
      const isOpen = item.classList.contains('open');
      $$('.faq-item.open').forEach((other) => {
        other.classList.remove('open');
        $('.faq-q', other).setAttribute('aria-expanded', 'false');
        $('.faq-a', other).style.maxHeight = null;
      });
      if (!isOpen) {
        item.classList.add('open');
        btn.setAttribute('aria-expanded', 'true');
        answer.style.maxHeight = answer.scrollHeight + 'px';
      }
    });
  });

  /* ---------- Blog filtering (posts are rendered server-side) ---------- */
  const blogGrid = $('#blogGrid');
  const blogEmpty = $('#blogEmpty');
  const filterBtns = $$('.filter-btn');
  if (blogGrid) {
    const cards = $$('.news-card', blogGrid);
    const updateEmptyState = (visibleCount, filter) => {
      if (!blogEmpty) return;
      if (visibleCount === 0) {
        blogEmpty.hidden = false;
        const heading = filter === 'all' ? 'No posts yet' : 'Nothing here yet';
        const text = filter === 'all'
          ? 'Check back soon for news and updates from the MAS Group.'
          : 'No posts in this category yet. Try another category, or check back soon.';
        $('h2', blogEmpty).textContent = heading;
        $('p', blogEmpty).textContent = text;
      } else {
        blogEmpty.hidden = true;
      }
    };
    filterBtns.forEach((btn) => btn.addEventListener('click', () => {
      filterBtns.forEach((b) => b.classList.remove('active'));
      btn.classList.add('active');
      const filter = btn.dataset.filter;
      let visible = 0;
      cards.forEach((card) => {
        const show = filter === 'all' || card.dataset.category === filter;
        card.style.display = show ? '' : 'none';
        if (show) visible++;
      });
      updateEmptyState(visible, filter);
    }));
  }

  /* ---------- Contact form ---------- */
  const contactForm = $('#contactForm');
  const contactMsg = $('#contactMsg');
  const messageArea = $('#cfMessage');
  const charCount = $('#charCount');
  if (messageArea && charCount) {
    messageArea.addEventListener('input', () => { charCount.textContent = messageArea.value.length; });
  }
  if (contactForm) {
    contactForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      let valid = true;
      $$('[required]', contactForm).forEach((field) => {
        const bad = !field.value.trim() || (field.type === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(field.value));
        field.classList.toggle('invalid', bad);
        if (bad) valid = false;
      });
      if (!valid) {
        contactMsg.textContent = 'Please fill in the required fields with a valid email.';
        contactMsg.className = 'form-status error';
        return;
      }
      const submitBtn = $('#contactSubmit');
      submitBtn.disabled = true;
      submitBtn.textContent = 'Sending...';
      contactMsg.textContent = '';
      try {
        const res = await fetch('contact.php', { method: 'POST', body: new FormData(contactForm) });
        const data = await res.json();
        if (data.ok) {
          contactMsg.textContent = 'Message sent! We\'ll get back to you within 24 hours.';
          contactMsg.className = 'form-status success';
          contactForm.reset();
          if (charCount) charCount.textContent = '0';
        } else {
          throw new Error(data.error || 'Send failed');
        }
      } catch (err) {
        contactMsg.textContent = 'Couldn\'t send right now — please email us directly using the address on this page.';
        contactMsg.className = 'form-status error';
      } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Send Message';
      }
    });
    // Clear the invalid state as the user types
    $$('[required]', contactForm).forEach((field) => field.addEventListener('input', () => field.classList.remove('invalid')));
  }

  /* ---------- Newsletter form ---------- */
  const newsletterForm = $('#newsletterForm');
  const newsletterMsg = $('#newsletterMsg');
  if (newsletterForm) {
    newsletterForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const emailInput = $('#newsletterEmail');
      const email = emailInput.value.trim();
      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        newsletterMsg.textContent = 'Please enter a valid email address.';
        newsletterMsg.className = 'form-note error';
        return;
      }
      try {
        const formData = new FormData();
        formData.append('email', email);
        const res = await fetch('newsletter.php', { method: 'POST', body: formData });
        const data = await res.json();
        if (!data.ok) throw new Error(data.error || 'Subscribe failed');
        newsletterMsg.textContent = 'Thanks for subscribing! You\'ll hear from us soon.';
        newsletterMsg.className = 'form-note success';
        newsletterForm.reset();
      } catch (err) {
        newsletterMsg.textContent = 'Couldn\'t subscribe right now — please try again later.';
        newsletterMsg.className = 'form-note error';
      }
    });
  }
})();
