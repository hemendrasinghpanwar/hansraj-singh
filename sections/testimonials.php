<?php
$testimonials = $config['testimonials'] ?? null;
if (!$testimonials) return;
$total = count($testimonials);
?>
<section class="section ts-section" id="testimonials" style="background:#fff;">
  <div class="container container-narrow">

    <!-- ============ EXACT GALLERY HEADER STRUCTURE ============ -->
    <div class="section-head reveal">
      <p class="section-label">Stalwart Says</p>
      <h2 class="section-headline">
        Voices of<br>
        <em>trust &amp; respect.</em>
      </h2>
      <div class="divider-rule"></div>
    </div>

    <!-- ============ PREMIUM MARQUEE ============ -->
    <div class="ts-marquee-wrap reveal" style="margin-top: 30px;">
      <div class="ts-marquee">
        <div class="ts-marquee-track">
          <?php for ($i = 0; $i < 3; $i++): ?>
            <?php foreach ($testimonials as $t): ?>
              <div class="ts-marquee-item">
                <span class="ts-marquee-dot"></span>
                <?= e($t['name']) ?>
              </div>
            <?php endforeach; ?>
          <?php endfor; ?>
        </div>
      </div>
    </div>

    <!-- ============ SLIDER CONTROLS ============ -->
    <div class="ts-controls reveal" style="margin-top: 40px;">
      <div class="ts-arrows">
        <button class="t-arrow" id="testimonialPrev" aria-label="Previous">
          <i class="fa-solid fa-chevron-left"></i>
        </button>
        <span class="t-counter">
          <span id="tCurrent">01</span>
          <span class="t-counter-sep">/</span>
          <span id="tTotal"><?= str_pad((string)$total, 2, '0', STR_PAD_LEFT) ?></span>
        </span>
        <button class="t-arrow" id="testimonialNext" aria-label="Next">
          <i class="fa-solid fa-chevron-right"></i>
        </button>
      </div>
    </div>

    <!-- ============ SLIDER ============ -->
    <div class="ts-slider reveal">
      <div class="ts-track" id="testimonialTrack">
        <?php foreach ($testimonials as $i => $t): ?>
          <article class="t-card">
            <span class="t-quote-mark" aria-hidden="true">&ldquo;</span>

            <div class="t-card-top">
              <div class="t-avatar">
                <img src="<?= e($t['img']) ?>" alt="<?= e($t['name']) ?>" loading="lazy">
              </div>
              <span class="t-index"><?= str_pad((string)($i+1), 2, '0', STR_PAD_LEFT) ?></span>
            </div>

            <p class="t-quote"><?= e($t['quote']) ?></p>

            <div class="t-footer">
              <span class="t-bar"></span>
              <div class="t-author">
                <span class="t-name"><?= e($t['name']) ?></span>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
      </div>

      <!-- Progress bar -->
      <div class="t-progress">
        <span class="t-progress-fill" id="tProgressFill"></span>
      </div>
    </div>

  </div>
</section>

<!-- ============ JAVASCRIPT (AUTO SCROLL) ============ -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const track     = document.getElementById('testimonialTrack');
    const prevBtn   = document.getElementById('testimonialPrev');
    const nextBtn   = document.getElementById('testimonialNext');
    const currentEl = document.getElementById('tCurrent');
    const fill      = document.getElementById('tProgressFill');

    if (!track || !prevBtn || !nextBtn) return;

    const cards = track.querySelectorAll('.t-card');
    let autoScrollInterval;
    const autoScrollDelay = 4000; // 4 seconds

    function pad(n) { return n < 10 ? '0' + n : '' + n; }

    function updateUI() {
        const cardWidth = cards[0].offsetWidth + 30; // 30 = gap
        let idx = Math.round(track.scrollLeft / cardWidth);
        idx = Math.max(0, Math.min(cards.length - 1, idx));

        currentEl.textContent = pad(idx + 1);

        const maxScroll = track.scrollWidth - track.clientWidth;
        const progress  = maxScroll > 0 ? (track.scrollLeft / maxScroll) * 100 : 0;
        fill.style.width = Math.min(100, Math.max(8, progress)) + '%';
    }

    function startAutoScroll() {
        stopAutoScroll(); // Prevent multiple intervals
        autoScrollInterval = setInterval(() => {
            const cardWidth = cards[0].offsetWidth + 30;
            const maxScroll = track.scrollWidth - track.clientWidth;
            
            // If we are at the end, loop back to the start
            if (track.scrollLeft >= maxScroll - 10) {
                track.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                track.scrollBy({ left: cardWidth, behavior: 'smooth' });
            }
        }, autoScrollDelay);
    }

    function stopAutoScroll() {
        clearInterval(autoScrollInterval);
    }

    // Start auto-scrolling on load
    startAutoScroll();

    // Pause on hover
    track.addEventListener('mouseenter', stopAutoScroll);
    track.addEventListener('mouseleave', startAutoScroll);

    // Reset timer on manual click
    prevBtn.addEventListener('click', () => {
        stopAutoScroll();
        const step = cards[0].offsetWidth + 30;
        track.scrollBy({ left: -step, behavior: 'smooth' });
        startAutoScroll();
    });

    nextBtn.addEventListener('click', () => {
        stopAutoScroll();
        const step = cards[0].offsetWidth + 30;
        track.scrollBy({ left: step, behavior: 'smooth' });
        startAutoScroll();
    });

    // Update UI on scroll and pause auto-scroll while user is manually scrolling
    let scrollTimeout;
    track.addEventListener('scroll', () => {
        updateUI();
        stopAutoScroll();
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(startAutoScroll, 5000); // Resume after 5 seconds of inactivity
    });

    window.addEventListener('resize', updateUI);
    updateUI();
});
</script>