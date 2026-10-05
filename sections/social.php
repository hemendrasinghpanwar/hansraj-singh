<?php
$social = $config['social'] ?? null;
if (!$social) return;
?>
<section class="section social-section" id="social">
  <div class="container container-narrow">

    <!-- ============ TOP ROW ============ -->
    <div class="social-top reveal">
      <?php if (!empty($social['follow_url'])): ?>
        <!-- Non-clickable Follow button -->
        <span class="social-follow-pill">Follow</span>
      <?php endif; ?>
      <?php if (!empty($social['heading'])): ?>
        <p class="social-heading"><?= e($social['heading']) ?></p>
      <?php endif; ?>
    </div>

    <!-- ============ 3-CARD GRID ============ -->
    <div class="social-grid">

      <?php foreach ($social['cards'] as $card): ?>
        <?php
          $platform = $card['platform'];
          $embed    = $card['embed'] ?? [];
        ?>

        <article class="social-card social-card--<?= e($platform) ?> reveal-item">

          <span class="social-platform-icon" aria-hidden="true">
            <i class="<?= e($card['icon']) ?>"></i>
          </span>

          <!-- ============================================================
               HEADER
               ============================================================ -->
          <header class="social-profile<?= $platform === 'instagram' ? ' social-profile--ig' : '' ?>">
            <div class="social-avatar<?= $platform === 'instagram' ? ' social-avatar--ig' : '' ?>">
              <img src="<?= e(press_thumb($card['profile']['name'] . '.jpg', $card['profile']['name'], $platform === 'instagram' ? 'gold' : 'blue')) ?>"
                   alt="<?= e($card['profile']['name']) ?>" loading="lazy">
            </div>
            <div class="social-profile-text">
              
              <?php if ($platform === 'instagram'): ?>
                <!-- Instagram Header -->
                <a class="social-name social-name--ig"
                   href="<?= e($card['profile']['url']) ?>" target="_blank" rel="noopener">
                  <?= e($card['profile']['handle']) ?>
                  <?php if (!empty($card['profile']['verified'])): ?>
                    <i class="fa-solid fa-circle-check social-verified social-verified--ig"></i>
                  <?php endif; ?>
                </a>
                <span class="social-name-sub">
                  <?= e($card['profile']['name']) ?>
                  <span class="social-sep">&middot;</span>
                  <!-- Connect link for Instagram -->
                  <a class="social-follow-inline social-follow-inline--ig" href="<?= e($card['profile']['url']) ?>" target="_blank" rel="noopener">Connect</a>
                </span>
                <span class="social-followers"><?= e($card['profile']['followers'] ?? '') ?></span>

              <?php else: ?>
                <!-- LinkedIn & Facebook Header -->
                <a class="social-name"
                   href="<?= e($card['profile']['url']) ?>" target="_blank" rel="noopener">
                  <?= e($card['profile']['name']) ?>
                  <?php if (!empty($card['profile']['verified'])): ?>
                    <i class="fa-solid fa-circle-check social-verified social-verified--<?= $platform === 'linkedin' ? 'li' : '' ?>"></i>
                  <?php endif; ?>
                </a>
                <span class="social-handle">
                  <?= e($card['profile']['tagline'] ?? $card['profile']['handle']) ?>
                  <span class="social-sep">&middot;</span>
                  <!-- Connect link for LinkedIn & Facebook -->
                  <a class="social-follow-inline social-follow-inline--<?= e($platform) ?>"
                     href="<?= e($card['profile']['url']) ?>"
                     target="_blank" rel="noopener">Connect</a>
                </span>
              <?php endif; ?>

            </div>
          </header>

          <!-- ============================================================
               BODY
               ============================================================ -->
          <div class="social-body<?= $platform === 'linkedin' ? ' social-body--li-posts' : ($platform === 'instagram' ? ' social-body--ig' : ' social-body--fb') ?>" tabindex="0">
            
            <?php if ($platform === 'linkedin'): ?>
              <div class="social-li-zigzag">
                <?php foreach (($card['posts'] ?? []) as $i => $post): ?>
                  <?php
                    $flip = ($i % 2 === 1);
                    $liveImg = function_exists('li_post_image') ? li_post_image($post['url'] ?? '') : '';
                    $staticImg = press_thumb($post['img'] ?? '', $post['title'] ?? 'LinkedIn', 'blue');
                    $imgSrc = $liveImg !== '' ? $liveImg : $staticImg;
                  ?>

                  <a class="social-li-card<?= $flip ? ' is-flipped' : '' ?>"
                     href="<?= e($post['url']) ?>" target="_blank" rel="noopener">
                    <div class="social-li-card-media">
                      <img src="<?= e($imgSrc) ?>" alt="<?= e($post['title'] ?? '') ?>" loading="lazy" referrerpolicy="no-referrer" onerror="this.onerror=null;this.src='<?= e($staticImg) ?>';">
                      <span class="social-li-card-icon"><i class="fa-brands fa-linkedin-in"></i></span>
                    </div>
                    <div class="social-li-card-body">
                      <?php if (!empty($post['tag'])): ?>
                        <span class="social-li-card-tag"><?= e($post['tag']) ?></span>
                      <?php endif; ?>
                      <h4 class="social-li-card-title"><?= e($post['title'] ?? '') ?></h4>
                      <p class="social-li-card-cap"><?= e($post['cap'] ?? '') ?></p>
                      <div class="social-li-card-foot">
                        <span class="social-li-card-date"><?= e($post['date'] ?? '') ?></span>
                        <span class="social-li-card-cta">View post <i class="fa-solid fa-arrow-right"></i></span>
                      </div>
                    </div>
                  </a>
                <?php endforeach; ?>
              </div>

            <?php elseif ($platform === 'facebook'): ?>
              <!-- Facebook Scrollable Iframe Container -->
              <div class="fb-scroll-container">
                
                <!-- SOCIABLEKIT IFRAME EMBED START -->
                <iframe 
                  src="https://widgets.sociablekit.com/facebook-page-posts/iframe/25719606" 
                  width="100%" 
                  height="720" 
                  frameborder="0" 
                  scrolling="yes" 
                  allowfullscreen="true"
                  loading="lazy">
                </iframe>
                <!-- SOCIABLEKIT IFRAME EMBED END -->

              </div>

            <?php elseif ($platform === 'instagram'): ?>
              <div class="social-ig-grid">
                <?php foreach (($embed['posts'] ?? []) as $postUrl): ?>
                  <blockquote class="instagram-media social-ig-embed"
                              data-instgrm-permalink="<?= e($postUrl) ?>"
                              data-instgrm-version="14"></blockquote>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>

          </div>

        </article>
      <?php endforeach; ?>

    </div>
  </div>
</section>

<!-- ============================================================
     INSTAGRAM SDK (Required for Instagram Embeds)
     ============================================================ -->
<script async src="//www.instagram.com/embed.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
      if (window.instgrm) {
          window.instgrm.Embeds.process();
      }
  });
  setTimeout(function() {
      if (window.instgrm) {
          window.instgrm.Embeds.process();
      }
  }, 2000);
</script>