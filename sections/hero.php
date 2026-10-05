<?php
/* ============================================================
   sections/hero.php — Hero section with auto-detecting slider
   ─────────────────────────────────────────────
   The slider automatically scans:
       assets/images/banners/
   and displays every JPG, PNG, JPEG, WEBP, GIF, JFIF or AVIF
   file it finds.

   style.css and main.js are NOT touched. The small <style> block
   below (scoped to #heroSlider) makes every slide use the banner's
   own proportions, so the whole banner is visible — never cropped —
   on phones, tablets, laptops and very large screens.
   ============================================================ */

/* ---------- Scan the banners folder ---------- */
$bannerDir = __DIR__ . '/../assets/images/banners';
$bannerUrl = 'assets/images/banners';
$slides    = [];

if (is_dir($bannerDir)) {
    $files = scandir($bannerDir);
    foreach ($files as $f) {
        if ($f === '.' || $f === '..') continue;
        $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'jfif', 'avif'], true)) {
            $slides[] = $f;
        }
    }
}

/* Natural sort: 1.jpg, 2.jpg, 10.jpg — not 1.jpg, 10.jpg, 2.jpg */
natcasesort($slides);
$slides = array_values($slides);

/* Proportions of the first banner (fallback 24 / 9 like your CSS) */
$ratioW = 24;
$ratioH = 9;

if (!empty($slides)) {
    $size = @getimagesize($bannerDir . '/' . $slides[0]);
    if ($size && $size[0] > 0 && $size[1] > 0) {
        $ratioW = (int)$size[0];
        $ratioH = (int)$size[1];
    }
}
?>
<?php if (!empty($slides)): ?>
<style>
  #heroSlider { --hb-ratio: <?= $ratioW ?> / <?= $ratioH ?>; }

  /* slides side by side, one banner per slide */
  #heroSlider .hero-slider-track { display: flex !important; flex-wrap: nowrap !important; }

  #heroSlider .hero-slide {
    flex: 0 0 100% !important;
    min-width: 100% !important;
    position: relative !important;
    opacity: 1 !important;
    visibility: visible !important;
    /* same proportions as the banner on EVERY screen (replaces 24/9, 16/9 and 4/5) */
    aspect-ratio: var(--hb-ratio) !important;
  }

  #heroSlider .hero-slide img { object-fit: cover; object-position: center; }

  /* very large monitors: keep the banner sharp instead of stretching it */
  @media (min-width: 1921px) {
    .hero-slider-section { max-width: 1920px; margin-left: auto; margin-right: auto; }
  }

  /* tablet + phone: tighter spacing, smaller controls */
  @media (max-width: 767px) {
    .hero-slider-section { margin-bottom: 32px !important; }
    #heroSlider .hero-slider-dots { margin-top: 14px; }
    #heroSlider .hero-slider-nav { width: 34px; height: 34px; font-size: 0.75rem; }
    #heroSlider .hero-slider-nav.prev { left: 8px; }
    #heroSlider .hero-slider-nav.next { right: 8px; }
  }

  /* small phones: keep the banner clear of overlays */
  @media (max-width: 640px) {
    #heroSlider .hero-slide-caption { display: none !important; }
    #heroSlider .hero-slide::after { display: none; }
  }
</style>
<?php endif; ?>
<header class="hero" id="home">

  <!-- ============================================================
       DECORATIVE BACKGROUND
       ============================================================ -->
  <svg class="hero-dots" viewBox="0 0 1000 600" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
    <defs>
      <pattern id="dotgrid" width="26" height="26" patternUnits="userSpaceOnUse">
        <circle cx="1.2" cy="1.2" r="1.2" fill="#4FA8DE"/>
      </pattern>
    </defs>
    <rect width="1000" height="600" fill="url(#dotgrid)"/>
  </svg>

  <div class="hero-spotlight" id="heroSpotlight"></div>

  <!-- ============================================================
       TOP BAR — official strip
       ============================================================ -->
  <div class="hero-topline">
    <div class="container container-narrow">
      <div class="hero-topline-inner">
        <span class="hero-topline-left">
          <?= icon('fa-solid','fa-circle-dot') ?>
          Official Portfolio &middot; Institutional Representation
        </span>
        <span class="hero-topline-right">
          <?= icon('fa-solid','fa-globe') ?>
          Geneva &middot; New York &middot; Jodhpur
        </span>
      </div>
    </div>
  </div>

  <?php if (isset($_GET['debug'])): ?>
  <!-- ============================================================
       DEBUG PANEL  (open the page with  ?debug=1  — remove later)
       ============================================================ -->
  <div id="heroDebug" style="position:relative;z-index:50;margin:12px;padding:14px;background:#fff;color:#111;font:13px/1.5 monospace;border:3px solid #d4a83f;border-radius:8px">
    <strong>HERO SLIDER DEBUG</strong><br>
    scanned folder: <?= htmlspecialchars((string)realpath($bannerDir)) ?><br>
    slides found: <?= count($slides) ?><br><br>

    <table border="1" cellpadding="6" style="border-collapse:collapse;background:#fff;color:#111">
      <tr><th>#</th><th>file on disk</th><th>url used</th><th>size</th><th>pixels</th><th>md5</th><th>what this URL serves</th></tr>
      <?php $seen = []; foreach ($slides as $i => $f):
          $full = $bannerDir . '/' . $f;
          $md5  = is_file($full) ? substr(md5_file($full), 0, 10) : 'missing';
          $dim  = @getimagesize($full);
          $seen[$md5][] = $f;
      ?>
      <tr>
        <td><?= $i + 1 ?></td>
        <td><?= htmlspecialchars($f) ?></td>
        <td><a href="<?= htmlspecialchars($bannerUrl . '/' . rawurlencode($f)) ?>" target="_blank"><?= htmlspecialchars($bannerUrl . '/' . rawurlencode($f)) ?></a></td>
        <td><?= is_file($full) ? round(filesize($full) / 1024) . ' KB' : '-' ?></td>
        <td><?= $dim ? $dim[0] . ' x ' . $dim[1] : '-' ?></td>
        <td><?= $md5 ?></td>
        <td><img src="<?= htmlspecialchars($bannerUrl . '/' . rawurlencode($f)) ?>?nocache=<?= time() ?>" style="width:220px;height:auto;display:block"></td>
      </tr>
      <?php endforeach; ?>
    </table>

    <?php foreach ($seen as $hash => $names): if (count($names) > 1): ?>
      <p style="color:#c00"><strong>WARNING:</strong> these files are IDENTICAL (same content): <?= htmlspecialchars(implode(', ', $names)) ?></p>
    <?php endif; endforeach; ?>

    <pre id="heroDebugJs" style="margin:10px 0 0;white-space:pre-wrap">measuring slides…</pre>
  </div>
  <script>
  window.addEventListener('load', function () {
    setTimeout(function () {
      const out = document.getElementById('heroDebugJs');
      const slider = document.getElementById('heroSlider');
      if (!out) return;
      if (!slider) { out.textContent = '#heroSlider NOT FOUND on page'; return; }
      const track = document.getElementById('heroSliderTrack');
      const lines = ['window width: ' + window.innerWidth,
                     'track transform: ' + (track ? track.style.transform || '(none)' : 'no track'),
                     'track display: ' + (track ? getComputedStyle(track).display : '-'), ''];
      slider.querySelectorAll('.hero-slide').forEach(function (s, i) {
        const r  = s.getBoundingClientRect();
        const cs = getComputedStyle(s);
        const im = s.querySelector('img');
        lines.push('slide ' + (i + 1) + ': left=' + Math.round(r.left) + ' width=' + Math.round(r.width) +
                   ' position=' + cs.position + ' opacity=' + cs.opacity + ' visibility=' + cs.visibility +
                   ' active=' + s.classList.contains('is-active'));
        lines.push('         img=' + (im ? decodeURIComponent((im.currentSrc || im.src).split('/').pop()) +
                   ' loaded=' + im.naturalWidth + 'x' + im.naturalHeight : 'none'));
      });
      out.textContent = lines.join('\n');
    }, 800);
  });
  </script>
  <?php endif; ?>

  <!-- ============================================================
       AUTO SLIDER — auto-detects images in assets/images/banners/
       ============================================================ -->
  <?php if (!empty($slides)): ?>
    <div class="hero-slider-section">
      <div class="hero-slider" id="heroSlider" tabindex="0">

        <div class="hero-slider-viewport">
          <div class="hero-slider-track" id="heroSliderTrack">

            <?php foreach ($slides as $i => $file): ?>
              <?php
                /* Build a nice caption from the filename */
                $name = pathinfo($file, PATHINFO_FILENAME);
                $name = str_replace(['-', '_'], ' ', $name);
                $name = ucwords($name);
              ?>
              <div class="hero-slide<?= $i === 0 ? ' is-active' : '' ?>">
                <img src="<?= htmlspecialchars($bannerUrl . '/' . rawurlencode($file)) ?>"
                     alt="<?= htmlspecialchars($name) ?>"
                     loading="eager"
                     draggable="false">
                <div class="hero-slide-caption">
                  <span class="hero-slide-caption-dot"></span>
                  <strong><?= htmlspecialchars($name) ?></strong>
                </div>
              </div>
            <?php endforeach; ?>

          </div>
        </div>

        <?php if (count($slides) > 1): ?>
          <!-- Prev / Next -->
          <button type="button" class="hero-slider-nav prev" id="heroSliderPrev" aria-label="Previous slide">
            <i class="fa-solid fa-chevron-left"></i>
          </button>
          <button type="button" class="hero-slider-nav next" id="heroSliderNext" aria-label="Next slide">
            <i class="fa-solid fa-chevron-right"></i>
          </button>

          <!-- Dots -->
          <div class="hero-slider-dots" role="tablist">
            <?php foreach ($slides as $i => $f): ?>
              <button type="button"
                      class="hero-slider-dot<?= $i === 0 ? ' is-active' : '' ?>"
                      data-index="<?= $i ?>"
                      aria-label="Go to slide <?= $i + 1 ?>"></button>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

      </div>
    </div>
  <?php else: ?>
    <!-- Fallback when no images are found -->
    <div class="hero-slider-empty">
      <p>
        <?= icon('fa-solid','fa-image') ?>
        No images found in <code>assets/images/banners/</code>
      </p>
      <p class="hero-slider-empty-hint">
        Add JPG, PNG, or WEBP files to that folder and refresh the page.
      </p>
    </div>
  <?php endif; ?>

  <!-- ============================================================
       MAIN HERO — text + credential
       ============================================================ -->
  <div class="container container-narrow">
    <div class="hero-grid">

      <!-- ============ LEFT · TEXT ============ -->
      <div class="hero-text">

        <div class="hero-emblem">
          <span class="hero-emblem-mark"><?= icon('fa-solid','fa-shield-halved') ?></span>
          <span class="hero-emblem-text">
            <strong>Appointed Representative</strong>
            <em>Roster of Accredited NGO Delegates</em>
          </span>
        </div>

        <p class="hero-eyebrow"><?= e($config['profile']['title']) ?></p>

        <h1 class="hero-name"><?= e($config['profile']['name']) ?></h1>

        <div class="hero-designation">
          <span class="hero-designation-line"></span>
          <p>
            Coordinator &mdash; <strong>UN Affairs &amp; ECOSOC Liaison</strong>
            <br>
            <span class="hero-designation-sub">
              IT Solutions &middot; Graphic Design &middot; Institutional Communications
            </span>
          </p>
        </div>

        <p class="hero-lede">
          Representing civil society before the United Nations Human Rights Council and the
          Economic and Social Council &mdash; advancing multilateral dialogue on human rights,
          gender equality, and sustainable development.
        </p>

        <div class="hero-cta">
          <a href="#experience" class="btn btn-gold">
            <?= icon('fa-solid','fa-briefcase') ?> View Credentials
          </a>
          <a href="#contact" class="btn btn-outline-light-custom">
            <?= icon('fa-solid','fa-envelope') ?> Official Correspondence
          </a>
        </div>

        <div class="hero-meta">
          <div class="hero-meta-item">
            <span class="hero-meta-label">Accreditation</span>
            <span class="hero-meta-value">ECOSOC &middot; UNHRC</span>
          </div>
          <div class="hero-meta-item">
            <span class="hero-meta-label">Statements Delivered</span>
            <span class="hero-meta-value">58 &middot; 34 oral / 24 written</span>
          </div>
          <div class="hero-meta-item">
            <span class="hero-meta-label">Visas</span>
            <span class="hero-meta-value">Schengen (valid through Aug 2026)</span>
          </div>
        </div>

      </div>

      <!-- ============ RIGHT · OFFICIAL CREDENTIAL ============ -->
      <div class="hero-visual" id="heroVisual">

        <div class="hero-credential">

          <div class="hero-credential-frame">
            <div class="hero-credential-header">
              <span class="hero-credential-header-left">
                <?= icon('fa-solid','fa-landmark') ?>
                <span>Permanent Mission</span>
              </span>
            </div>

            <div class="hero-credential-photo">
              <?php
                /* Also auto-detect the credential photo if missing */
                $heroImg = $config['assets']['hero_img'] ?? '';
                $heroImgPath = __DIR__ . '/../' . ltrim($heroImg, '/');
                if ($heroImg === '' || !is_file($heroImgPath)) {
                    /* Fallback to first banner image */
                    if (!empty($slides)) {
                        $heroImg = $bannerUrl . '/' . rawurlencode($slides[0]);
                    }
                }
              ?>
              <img src="<?= e($heroImg) ?>"
                   alt="<?= e($config['profile']['name']) ?>">
            </div>
          </div>

          <!-- Floating decorations -->
          <div class="hero-credential-serial" aria-hidden="true">
            GENEVA &middot; MMXXV
          </div>

          <div class="hero-credential-emblem" aria-hidden="true">
            <div class="globe-orbit"></div>
            <div class="globe3d"></div>
          </div>

          <div class="hero-credential-seal" aria-hidden="true">
            <?= icon('fa-solid','fa-award') ?>
            <span>Certified</span>
          </div>

        </div>

      </div>
    </div>

    <div class="scroll-cue"><?= icon('fa-solid','fa-chevron-down') ?></div>
  </div>
</header>