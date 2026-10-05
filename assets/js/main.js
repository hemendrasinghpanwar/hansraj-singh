/* ============================================================
   Portfolio — main.js
   Depends on: jQuery 3.7+ and Bootstrap 5 bundle (loaded in footer.php)
   PHP injects `window.APP_CONFIG` before this file is loaded.
   ============================================================ */
(function ($) {
  'use strict';

  const CONFIG = window.APP_CONFIG || { roles: [], contactUrl: 'contact-handler.php' };

  /* ---------- Environment flags ---------- */
  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const isFinePointer        = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
  const isDesktop            = () => window.innerWidth > 991;

  /* ============================================================
     PRELOADER
     ============================================================ */
  (function preloader() {
    const barFill = document.getElementById('loaderBarFill');
    if (!barFill) return;

    let progress = 0;
    const interval = setInterval(() => {
      progress += Math.random() * 18;
      if (progress > 100) progress = 100;
      barFill.style.width = progress + '%';
      if (progress >= 100) clearInterval(interval);
    }, 160);

    const finish = () => {
      setTimeout(() => {
        const $pre = $('#preloader');
        if (!$pre.length) return;
        $pre.addClass('hide');
        $('body').addClass('loaded');
        setTimeout(() => $pre.remove(), 700);
      }, 500);
    };

    if (document.readyState === 'complete') finish();
    else $(window).on('load', finish);
    setTimeout(finish, 2600); // hard fallback
  })();

  /* ============================================================
     SCROLL UI — nav shrink, progress bar, back-to-top
     ============================================================ */
  const $window = $(window);

  function updateScrollUI() {
    const st = $window.scrollTop();

    $('#mainNav').toggleClass('scrolled', st > 40);

    const docHeight = $(document).height() - $window.height();
    const pct       = docHeight > 0 ? (st / docHeight) * 100 : 0;
    $('#scrollProgress').css('width', pct + '%');

    $('#backToTop').toggleClass('show', st > 500);

    highlightNav();
    animateImpactCounters();
    animatePressCounters();
  }

  /* ============================================================
     ACTIVE NAV + MAGNETIC INDICATOR
     ============================================================ */
  const $sections  = $('section[id], header[id]');
  const $navLinks  = $('.nav-links-wrap .nav-link');
  const $navWrap   = $('#navLinksWrap');
  const $indicator = $('#navIndicator');

  function moveIndicator($link) {
    if (!$link || !$link.length || !isDesktop()) return;
    const pos = $link.position();
    $indicator.css({
      left:    pos.left + 'px',
      width:   $link.outerWidth() + 'px',
      opacity: 1,
    });
  }

  function highlightNav() {
    const scrollPos = $window.scrollTop() + 140;
    let current = null;

    $sections.each(function () {
      if ($(this).offset().top <= scrollPos) current = $(this).attr('id');
    });

    $navLinks.removeClass('active');
    const $active = current ? $navLinks.filter('[href="#' + current + '"]') : null;

    if ($active && $active.length) {
      $active.addClass('active');
      if (!$navWrap.is(':hover')) moveIndicator($active);
    } else {
      $indicator.css('opacity', 0);
    }
  }

  /* ============================================================
     NAV DROPDOWN — click to toggle (desktop + mobile)
     ============================================================ */
  (function navDropdown() {
    const dropdowns = document.querySelectorAll('.nav-dropdown');
    if (!dropdowns.length) return;

    const mobileMQ = window.matchMedia('(max-width: 991px)');

    function closeAll(except) {
      dropdowns.forEach(d => {
        if (d === except) return;
        d.classList.remove('is-open');
        const t = d.querySelector('.nav-dropdown-toggle');
        if (t) t.setAttribute('aria-expanded', 'false');
      });
    }

    function closeOuterCollapse() {
      if (!mobileMQ.matches) return;
      const navMenu = document.getElementById('navMenu');
      if (navMenu && navMenu.classList.contains('show') && typeof bootstrap !== 'undefined') {
        const inst = bootstrap.Collapse.getInstance(navMenu)
                  || new bootstrap.Collapse(navMenu, { toggle: false });
        inst.hide();
      }
    }

    dropdowns.forEach(dropdown => {
      const toggle = dropdown.querySelector('.nav-dropdown-toggle');
      if (!toggle) return;

      toggle.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();

        const willOpen = !dropdown.classList.contains('is-open');
        closeAll(dropdown);
        dropdown.classList.toggle('is-open', willOpen);
        this.setAttribute('aria-expanded', String(willOpen));
      });

      dropdown.querySelectorAll('.nav-dropdown-item').forEach(item => {
        item.addEventListener('click', () => {
          closeAll(null);
          closeOuterCollapse();
        });
      });
    });

    document.addEventListener('click', (e) => {
      if (!e.target.closest('.nav-dropdown')) closeAll(null);
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeAll(null);
    });

    const sync = () => closeAll(null);
    if (mobileMQ.addEventListener) mobileMQ.addEventListener('change', sync);
    else if (mobileMQ.addListener) mobileMQ.addListener(sync);
  })();

  /* ============================================================
     CUSTOM CURSOR — desktop (fine pointer) only
     ============================================================ */
  (function customCursor() {
    const cursorMQ = window.matchMedia(
      '(hover: hover) and (pointer: fine) and (min-width: 992px)'
    );

    let dot    = null;
    let ring   = null;
    let rafId  = null;
    let onMove = null;

    function enable() {
      if (dot || prefersReducedMotion) return;

      document.body.classList.add('custom-cursor');

      dot  = document.createElement('div');
      ring = document.createElement('div');
      dot.className  = 'cursor-dot';
      ring.className = 'cursor-ring';
      document.body.append(dot, ring);

      let mx = window.innerWidth / 2,  my = window.innerHeight / 2;
      let rx = mx,                     ry = my;

      onMove = (e) => {
        mx = e.clientX;
        my = e.clientY;
        dot.style.left = mx + 'px';
        dot.style.top  = my + 'px';
      };
      document.addEventListener('mousemove', onMove);

      (function animateRing() {
        rx += (mx - rx) * 0.18;
        ry += (my - ry) * 0.18;
        ring.style.left = rx + 'px';
        ring.style.top  = ry + 'px';
        rafId = requestAnimationFrame(animateRing);
      })();

      document.querySelectorAll(
        'a, button, .ucard, .hero-frame, .gallery-item, input, textarea, .exp-card, .press-card, .dossier-entry'
      ).forEach(el => {
        el.addEventListener('mouseenter', () => ring.classList.add('hovering'));
        el.addEventListener('mouseleave', () => ring.classList.remove('hovering'));
      });
    }

    function disable() {
      document.body.classList.remove('custom-cursor');
      if (dot)  { dot.remove();  dot  = null; }
      if (ring) { ring.remove(); ring = null; }
      if (rafId) { cancelAnimationFrame(rafId); rafId = null; }
      if (onMove) { document.removeEventListener('mousemove', onMove); onMove = null; }
    }

    function sync() {
      if (cursorMQ.matches) enable();
      else                  disable();
    }

    sync();

    if (cursorMQ.addEventListener) cursorMQ.addEventListener('change', sync);
    else if (cursorMQ.addListener) cursorMQ.addListener(sync);
  })();

  /* ============================================================
     HERO TILT + SPOTLIGHT
     ============================================================ */
  (function heroTilt() {
    if (!isFinePointer || prefersReducedMotion) return;

    const $hero  = $('.hero');
    const $frame = $('#heroVisual');
    const heroEl = document.querySelector('.hero');
    if (!$hero.length || !heroEl) return;

    $hero.on('mousemove', function (e) {
      const rect = this.getBoundingClientRect();
      const x = (e.clientX - rect.left) / rect.width  - 0.5;
      const y = (e.clientY - rect.top)  / rect.height - 0.5;

      if ($frame.length) {
        $frame.css('transform', `rotate3d(${-y}, ${x}, 0, 3deg)`);
      }
      heroEl.style.setProperty('--mx', ((e.clientX - rect.left) / rect.width  * 100) + '%');
      heroEl.style.setProperty('--my', ((e.clientY - rect.top)  / rect.height * 100) + '%');
    });

    $hero.on('mouseleave', () => {
      if ($frame.length) $frame.css('transform', 'rotate3d(0,0,0,0deg)');
    });
  })();

  /* ============================================================
     EXPERIENCE / DOSSIER CARD SPOTLIGHT
     ============================================================ */
  (function cardSpotlight() {
    if (!isFinePointer || prefersReducedMotion) return;
    document.querySelectorAll('.exp-card, .dossier-entry').forEach(card => {
      card.addEventListener('mousemove', e => {
        const r = card.getBoundingClientRect();
        card.style.setProperty('--mx', (e.clientX - r.left) / r.width  * 100 + '%');
        card.style.setProperty('--my', (e.clientY - r.top)  / r.height * 100 + '%');
      });
    });
  })();

  /* ============================================================
     TYPEWRITER
     ============================================================ */
  (function typewriter() {
    const roles = CONFIG.roles || [];
    const el    = document.getElementById('typedRole');
    if (!el || !roles.length) return;

    let ri = 0, ci = 0, deleting = false;

    function tick() {
      const current = roles[ri];
      if (!deleting) {
        ci++;
        el.textContent = current.substring(0, ci);
        if (ci === current.length) { deleting = true; return setTimeout(tick, 1500); }
      } else {
        ci--;
        el.textContent = current.substring(0, ci);
        if (ci === 0) { deleting = false; ri = (ri + 1) % roles.length; }
      }
      setTimeout(tick, deleting ? 35 : 75);
    }
    setTimeout(tick, 1200);
  })();

  /* ============================================================
     IMPACT COUNTERS (uses data-count / data-suffix)
     ============================================================ */
  let impactCounted = false;
  function animateImpactCounters() {
    if (impactCounted) return;
    const $impact = $('.impact');
    if (!$impact.length) return;

    if ($window.scrollTop() + $window.height() > $impact.offset().top + 60) {
      impactCounted = true;
      $('.stat-num').each(function () {
        const $this  = $(this);
        const target = parseFloat($this.data('count')) || 0;
        const suffix = $this.data('suffix') || '';

        $({ val: 0 }).animate({ val: target }, {
          duration: 1400,
          easing: 'swing',
          step()     { $this.text(Math.floor(this.val)); },
          complete() { $this.text(target + suffix); },
        });
      });
    }
  }

  /* ============================================================
     PRESS STAT COUNTERS
     ============================================================ */
  function animatePressCounters() {
    const statEls = document.querySelectorAll('.press-meta-num');
    const head    = document.querySelector('.press-head');
    if (!statEls.length || !head || head.dataset.counted === '1') return;

    const r  = head.getBoundingClientRect();
    const vh = window.innerHeight || document.documentElement.clientHeight;

    if (r.top < vh * 0.9 && r.bottom > 0) {
      head.dataset.counted = '1';
      statEls.forEach(el => {
        const target = parseInt(el.dataset.count, 10) || 0;
        let current = 0;
        const step  = Math.max(1, Math.ceil(target / 20));
        el.textContent = '0';
        const t = setInterval(() => {
          current += step;
          if (current >= target) { current = target; clearInterval(t); }
          el.textContent = current;
        }, 40);
      });
    }
  }

  /* ============================================================
     REVEAL ON SCROLL
     ============================================================ */
  function setupReveal() {
    if (!('IntersectionObserver' in window)) {
      document.querySelectorAll('.reveal, .reveal-item').forEach(el => el.classList.add('in'));
      return;
    }
    const io = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) entry.target.classList.add('in');
      });
    }, { threshold: 0.15 });

    document.querySelectorAll('.reveal').forEach(el => io.observe(el));
    document.querySelectorAll('.reveal-item').forEach((el, i) => {
      el.style.transitionDelay = (i % 6) * 90 + 'ms';
      io.observe(el);
    });
  }

  /* ============================================================
     CONTACT FORM (AJAX submit)
     ============================================================ */
  function setupContactForm() {
    const form = document.getElementById('contactForm');
    if (!form) return;

    const $success = $('#formSuccess');
    const $error   = $('#formError');
    const $btn     = $('#cfSubmit');

    form.addEventListener('submit', async e => {
      e.preventDefault();
      e.stopPropagation();

      if (!form.checkValidity()) {
        form.classList.add('was-validated');
        const firstInvalid = form.querySelector(':invalid');
        if (firstInvalid) firstInvalid.focus();
        return;
      }

      const originalHtml = $btn.html();
      $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Sending...');
      $success.removeClass('show');
      $error.removeClass('show');

      try {
        const action = form.getAttribute('action') || CONFIG.contactUrl;
        const res    = await fetch(action, {
          method: 'POST',
          headers: { 'X-Requested-With': 'XMLHttpRequest' },
          body: new FormData(form),
        });

        const data = await res.json();

        if (data.ok) {
          $success.addClass('show');
          form.reset();
          form.classList.remove('was-validated');
          setTimeout(() => $success.removeClass('show'), 6000);
        } else {
          const errMsg = data.error || 'Please check the fields and try again.';
          $error.find('span').text(errMsg);
          $error.addClass('show');

          if (data.errors) {
            form.classList.add('was-validated');
            Object.entries(data.errors).forEach(([name]) => {
              const field = form.querySelector(`[name="${name}"]`);
              if (field) field.classList.add('is-invalid');
            });
          }
        }
      } catch (err) {
        $error.find('span').text('Network error. Please try again or email directly.');
        $error.addClass('show');
      } finally {
        $btn.prop('disabled', false).html(originalHtml);
      }
    });
  }

  /* ============================================================
     GALLERY LIGHTBOX
     ============================================================ */
  function setupGallery() {
    const modalEl = document.getElementById('galleryModal');
    if (!modalEl || typeof bootstrap === 'undefined') return;

    const modal = new bootstrap.Modal(modalEl);
    const wrap  = document.getElementById('modalMediaWrap');
    const capEl = document.getElementById('modalCap');
    const locEl = document.getElementById('modalLoc');

    document.querySelectorAll('.gallery-item').forEach(item => {
      item.addEventListener('click', () => {
        const type = item.getAttribute('data-type');
        const cap  = item.getAttribute('data-cap');
        const loc  = item.getAttribute('data-loc');

        if (type === 'photo') {
          const imgSrc = item.querySelector('img')?.getAttribute('src') || '';
          wrap.className = '';
          wrap.id        = 'modalMediaWrap';
          wrap.innerHTML = `<img src="${imgSrc}" alt="${cap}">`;
          wrap.style.background = 'transparent';
        } else {
          const icon    = item.getAttribute('data-icon');
          const media   = item.querySelector('.gallery-media');
          const bgClass = media ? media.className.replace('gallery-media', '').trim() : '';

          wrap.className = bgClass;
          wrap.id        = 'modalMediaWrap';
          wrap.style.background = '';
          wrap.innerHTML = `<i class="fa-solid ${icon}"></i>`;
        }

        capEl.textContent = cap || '';
        locEl.textContent = loc || '';
        modal.show();
      });
    });
  }

  /* ============================================================
     BACK TO TOP
     ============================================================ */
  function setupBackToTop() {
    const btn = document.getElementById('backToTop');
    if (!btn) return;
    btn.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: prefersReducedMotion ? 'auto' : 'smooth' });
    });
  }

  /* ============================================================
     INIT
     ============================================================ */
  $(function () {
    $('#year').text(new Date().getFullYear());

    setupReveal();
    setupContactForm();
    setupGallery();
    setupBackToTop();

    // Initial state
    highlightNav();
    animateImpactCounters();
    animatePressCounters();
    moveIndicator($navLinks.filter('.active'));
  });

  // Bind scroll handler (throttled via rAF)
  let ticking = false;
  $window.on('scroll', () => {
    if (ticking) return;
    ticking = true;
    requestAnimationFrame(() => {
      updateScrollUI();
      ticking = false;
    });
  });

})(jQuery);

/* ============================================================
   HERO — AUTO SLIDER
   ============================================================ */
(function heroSlider() {
  'use strict';

  const slider = document.getElementById('heroSlider');
  if (!slider) return;

  const track   = document.getElementById('heroSliderTrack');
  const slides  = slider.querySelectorAll('.hero-slide');
  const dots    = slider.querySelectorAll('.hero-slider-dot');
  const prevBtn = document.getElementById('heroSliderPrev');
  const nextBtn = document.getElementById('heroSliderNext');

  if (!track || slides.length < 2) return;

  const isTouch  = window.matchMedia('(hover: none)').matches;
  const DELAY    = isTouch ? 3500 : 4500;
  const DURATION = isTouch ? 700  : 900;

  track.style.transitionDuration = DURATION + 'ms';

  let index = 0;
  let timer = null;

  function go(i) {
    index = (i + slides.length) % slides.length;
    track.style.transform = `translateX(-${index * 100}%)`;
    slides.forEach((s, si) => s.classList.toggle('is-active', si === index));
    dots.forEach((d, di)   => d.classList.toggle('is-active', di === index));
  }

  function start() {
    stop();
    timer = setInterval(() => go(index + 1), DELAY);
  }

  function stop() {
    if (timer) { clearInterval(timer); timer = null; }
  }

  dots.forEach(dot => {
    dot.addEventListener('click', () => {
      const i = parseInt(dot.getAttribute('data-index'), 10) || 0;
      go(i);
      start();
    });
  });

  if (prevBtn) prevBtn.addEventListener('click', () => { go(index - 1); start(); });
  if (nextBtn) nextBtn.addEventListener('click', () => { go(index + 1); start(); });

  if (!isTouch) {
    slider.addEventListener('mouseenter', stop);
    slider.addEventListener('mouseleave', start);
  }

  let touchStartX = 0, touchStartY = 0;
  slider.addEventListener('touchstart', (e) => {
    touchStartX = e.changedTouches[0].screenX;
    touchStartY = e.changedTouches[0].screenY;
    stop();
  }, { passive: true });

  slider.addEventListener('touchend', (e) => {
    const dx = touchStartX - e.changedTouches[0].screenX;
    const dy = touchStartY - e.changedTouches[0].screenY;
    if (Math.abs(dx) > Math.abs(dy) && Math.abs(dx) > 40) {
      go(dx > 0 ? index + 1 : index - 1);
    }
    start();
  }, { passive: true });

  document.addEventListener('visibilitychange', () => {
    if (document.hidden) stop(); else start();
  });

  slider.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowRight') { go(index + 1); start(); }
    if (e.key === 'ArrowLeft')  { go(index - 1); start(); }
  });

  go(0);
  start();
})();
/* ============================================================
   NEWSPAPER CLIPPINGS — LIGHTBOX MODAL
   ============================================================ */
(function pressClippingsLightbox() {
    'use strict';

    const modalEl = document.getElementById('clippingModal');

    if (!modalEl) {
        console.log('clippingModal not found');
        return;
    }

    const modalImg      = document.getElementById('clippingModalImg');
    const modalOutlet   = document.getElementById('clippingModalOutlet');
    const modalDate     = document.getElementById('clippingModalDate');
    const modalHeadline = document.getElementById('clippingModalHeadline');

    /* Populate modal when clipping is clicked */
    modalEl.addEventListener('show.bs.modal', function (e) {

        const trigger = e.relatedTarget;

        if (!trigger) return;

        const image = trigger.getAttribute('data-img') || '';

        console.log('Clipping image:', image);

        modalImg.src = image;
        modalImg.alt = trigger.getAttribute('data-headline') || 'Newspaper clipping';

        modalOutlet.textContent =
            trigger.getAttribute('data-outlet') || '';

        modalDate.textContent =
            trigger.getAttribute('data-date') || '';

        modalHeadline.textContent =
            trigger.getAttribute('data-headline') || '';

        /* If image cannot load */
        modalImg.onerror = function () {
            console.error('Image failed to load:', image);

            this.onerror = null;
            this.src = 'assets/images/press/cutouts/placeholder.jpg';
        };
    });

    /* Clear image after modal closes */
    modalEl.addEventListener('hidden.bs.modal', function () {
        modalImg.src = '';
    });

})();
/* ============================================================
   SOCIAL FEEDS — big-card inner scroll
   Handles:
     • LinkedIn  → zigzag image cards (no iframe needed)
     • Facebook  → .fb-page iframe from Facebook SDK
     • Instagram → .instagram-media iframe from Instagram SDK
   Runs as its own IIFE, independent of jQuery and the hero slider.
   ============================================================ */
(function socialFeeds() {
  'use strict';

  function initSocialFeeds() {
    var cards = document.querySelectorAll('.social-card');
    if (!cards.length) return;

    /* ------------------------------------------------------------
       1. Mark bodies as loading
          - LinkedIn: clears immediately (renders from static HTML)
          - Facebook/Instagram: cleared when their iframe appears
       ------------------------------------------------------------ */
    cards.forEach(function (card) {
      var body = card.querySelector('.social-body');
      if (!body) return;

      var isLinkedIn = card.classList.contains('social-card--linkedin');

      if (isLinkedIn) {
        // No iframe to wait for — flip loading off on next tick
        setTimeout(function () {
          body.setAttribute('data-loading', 'false');
        }, 100);
      } else {
        body.setAttribute('data-loading', 'true');
      }
    });

    /* ------------------------------------------------------------
       2. Poll for Facebook + Instagram iframes
       ------------------------------------------------------------ */
    function waitForIframe(selector, timeout) {
      var start = Date.now();
      var t = setInterval(function () {
        if (document.querySelector(selector)) {
          clearInterval(t);
          clearAllLoading();
          attachShieldHandlers();
        } else if (Date.now() - start > timeout) {
          clearInterval(t);
          clearAllLoading();
          attachShieldHandlers();
        }
      }, 250);
    }

    function clearAllLoading() {
      document.querySelectorAll('.social-body').forEach(function (b) {
        b.setAttribute('data-loading', 'false');
      });
    }

    waitForIframe('iframe[src*="facebook.com/plugins/page"]', 8000);
    waitForIframe('.social-ig-embed iframe', 8000);

    // Safety net — clear all loading states after 9s no matter what
    setTimeout(clearAllLoading, 9000);

    // Attach scroll handlers immediately for LinkedIn
    // (guarded by data-shieldReady, so double-attach won't hurt)
    setTimeout(attachShieldHandlers, 200);

    /* ------------------------------------------------------------
       3. Core: make wheel events scroll INSIDE the card
       ------------------------------------------------------------ */
    function attachShieldHandlers() {
      cards.forEach(function (card) {
        var body = card.querySelector('.social-body');
        if (!body || body.dataset.shieldReady === '1') return;
        body.dataset.shieldReady = '1';

        var shield = body.querySelector('.social-shield');

        /* ----- WHEEL over card → scroll body, not page ----- */
        function handleWheel(e) {
          var atTop    = body.scrollTop <= 0;
          var atBottom = body.scrollTop + body.clientHeight >= body.scrollHeight - 2;

          // If we're at an edge AND the wheel is pushing further, let page scroll
          if ((atTop && e.deltaY < 0) || (atBottom && e.deltaY > 0)) {
            return;
          }

          // Otherwise scroll the card content
          body.scrollTop += e.deltaY;
          e.preventDefault();
          e.stopPropagation();
        }

        // Attach to the body itself
        body.addEventListener('wheel', handleWheel, { passive: false });

        // Attach to the shield (transparent overlay over embeds)
        if (shield) {
          shield.addEventListener('wheel', handleWheel, { passive: false });

          // First click on shield → enable interaction with iframe
          shield.addEventListener('click', function () {
            body.classList.add('is-interactive');
          });
        }

        // Click outside the embed → focus the scroll body
        card.addEventListener('click', function (e) {
          if (e.target.closest('iframe, a, button')) return;
          body.focus({ preventScroll: true });
        });

        /* ----- Touch swipe support (mobile) ----- */
        var touchStartY = 0;
        body.addEventListener('touchstart', function (e) {
          touchStartY = e.touches[0].clientY;
        }, { passive: true });

        body.addEventListener('touchmove', function (e) {
          var dy = touchStartY - e.touches[0].clientY;
          var atTop    = body.scrollTop <= 0;
          var atBottom = body.scrollTop + body.clientHeight >= body.scrollHeight - 2;

          if ((atTop && dy < 0) || (atBottom && dy > 0)) return;
          e.stopPropagation();
        }, { passive: true });

        /* ----- Keyboard arrows when focused ----- */
        body.addEventListener('keydown', function (e) {
          var step = 60;
          if (e.key === 'ArrowDown') {
            body.scrollTop += step;
            e.preventDefault();
          } else if (e.key === 'ArrowUp') {
            body.scrollTop -= step;
            e.preventDefault();
          } else if (e.key === 'PageDown') {
            body.scrollTop += body.clientHeight;
            e.preventDefault();
          } else if (e.key === 'PageUp') {
            body.scrollTop -= body.clientHeight;
            e.preventDefault();
          }
        });
      });
    }
     /* ============================================================
     PRESS PAGE — category tab filter
     ============================================================ */
  function setupPressFilter() {
    const tabs    = document.querySelectorAll('.press-tab');
    const hero    = document.querySelector('.press-hero');
    const tiles   = document.querySelectorAll('.press-tile');
    if (!tabs.length) return;

    tabs.forEach(tab => {
      tab.addEventListener('click', () => {
        const filter = tab.getAttribute('data-filter');

        // Update active tab
        tabs.forEach(t => {
          t.classList.remove('is-active');
          t.setAttribute('aria-selected', 'false');
        });
        tab.classList.add('is-active');
        tab.setAttribute('aria-selected', 'true');

        // Filter hero
        if (hero) {
          const heroCat = hero.getAttribute('data-category');
          const showHero = (filter === 'all' || filter === heroCat);
          hero.classList.toggle('is-hidden', !showHero);
        }

        // Filter tiles
        tiles.forEach(tile => {
          const cat = tile.getAttribute('data-category');
          const show = (filter === 'all' || filter === cat);
          tile.classList.toggle('is-hidden', !show);

          // Re-trigger entrance animation
          if (show) {
            tile.classList.remove('in');
            void tile.offsetWidth;
            setTimeout(() => tile.classList.add('in'), 30);
          }
        });
      });
    });
  }

    /* ============================================================
     ANCHOR SCROLL — safe for same-page + cross-page navigation
     ============================================================ */
  function setupAnchorScroll() {
    // 1. If URL has a hash on page load → smooth-scroll to it
    if (window.location.hash) {
      const target = document.querySelector(window.location.hash);
      if (target) {
        setTimeout(() => {
          const offset = 110;
          const top = target.getBoundingClientRect().top + window.pageYOffset - offset;
          window.scrollTo({ top, behavior: 'smooth' });
        }, 120);
      }
    }

    // 2. Handle clicks on SAME-PAGE anchors only (#section)
    document.querySelectorAll('a[href^="#"]').forEach(link => {
      link.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (!href || href === '#' || !href.startsWith('#')) return;

        const hash = href.substring(1);
        const target = document.getElementById(hash);

        // Target doesn't exist here → let browser navigate naturally
        if (!target) return;

        // Target exists → smooth scroll
        e.preventDefault();
        const offset = 110;
        const top = target.getBoundingClientRect().top + window.pageYOffset - offset;
        window.scrollTo({ top, behavior: 'smooth' });
        history.pushState(null, '', '#' + hash);
      });
    });
  }
  let autoScrollInterval;
const autoScrollDelay = 4000; // 4 seconds

function startAutoScroll() {
    autoScrollInterval = setInterval(() => {
        const cardWidth = cards[0].offsetWidth + 30;
        const maxScroll = track.scrollWidth - track.clientWidth;
        
        if (track.scrollLeft >= maxScroll - 10) { // Reached the end
            track.scrollTo({ left: 0, behavior: 'smooth' });
        } else {
            track.scrollBy({ left: cardWidth, behavior: 'smooth' });
        }
    }, autoScrollDelay);
}

function stopAutoScroll() {
    clearInterval(autoScrollInterval);
}

// Start on load
startAutoScroll();

// Pause on hover
track.addEventListener('mouseenter', stopAutoScroll);
track.addEventListener('mouseleave', startAutoScroll);

// Reset timer on manual click
prevBtn.addEventListener('click', () => {
    stopAutoScroll();
    const step = cards[0].offsetWidth + 30;
    track.scrollBy({ left: -step, behavior: 'smooth' });
    startAutoScroll(); // Restart the timer
});

nextBtn.addEventListener('click', () => {
    stopAutoScroll();
    const step = cards[0].offsetWidth + 30;
    track.scrollBy({ left: step, behavior: 'smooth' });
    startAutoScroll(); // Restart the timer
});
    /* ------------------------------------------------------------
       4. Re-hide shield when mouse leaves the card
       ------------------------------------------------------------ */
    cards.forEach(function (card) {
      var body = card.querySelector('.social-body');
      if (!body) return;
      card.addEventListener('mouseleave', function () {
        body.classList.remove('is-interactive');
      });
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initSocialFeeds);
  } else {
    initSocialFeeds();
  }

  /* ------------------------------------------------------------
       5. Re-init if new cards are added dynamically
       ------------------------------------------------------------ */
  window.reinitSocialFeeds = initSocialFeeds;
})();