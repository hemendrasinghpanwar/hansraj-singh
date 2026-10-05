<?php
/* ============================================================
   sections/press.php — Press section with live images + fallbacks
   Every card shows the real article image when possible,
   otherwise a contextual fallback photo.
   ============================================================ */
$press = $config['press'] ?? null;
if (!$press) return;

$palettes = ['navy', 'gold', 'blue', 'deep'];

/**
 * Primary image source: Microlink's live OG-image embed.
 */
function press_live_img(array $item): string
{
    $url = $item['url'] ?? '';
    if ($url !== '') {
        return 'https://api.microlink.io/?url=' . urlencode($url) . '&embed=image.url';
    }
    return $item['img'] ?? '';
}

/**
 * Fallback image: the specific contextual photo from config.
 */
function press_fallback_img(array $item): string
{
    $img = $item['img'] ?? '';
    if ($img !== '' && preg_match('#^https?://#i', $img)) {
        return $img;
    }
    return 'https://images.unsplash.com/photo-1495020689067-958852a7765e?auto=format&fit=crop&w=900&q=80';
}
?>
<section class="section" id="press">
  <div class="container container-narrow">

    <!-- ============ HEADER ============ -->
    <div class="press-head reveal">
      <div class="press-rail">
        <span class="press-rail-tag"><span class="press-tag-dot"></span>Press &amp; Media</span>
        <span class="press-rail-line"></span>
        <span class="press-rail-meta">Global Coverage Desk</span>
      </div>
      <div class="press-head-grid">
        <div class="press-head-left">
          <h2 class="section-headline">In the<br><em>headlines.</em></h2>
          <p class="press-intro">Documented engagements at the United Nations, international convenings, and community-impact work — as reported by global media outlets.</p>
        </div>
        <div class="press-head-right">
          <?php foreach ($press['stats'] as $s): ?>
            <div class="press-meta-block">
              <span class="press-meta-num" data-count="<?= (int) $s['value'] ?>"><?= (int) $s['value'] ?></span>
              <span class="press-meta-label"><?= e($s['label']) ?></span>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <!-- ============ LEAD STORY ============ -->
    <a class="press-lead reveal-item" href="<?= e($press['lead']['url']) ?>" target="_blank" rel="noopener">
      <div class="press-lead-media">
        <img src="<?= e(press_live_img($press['lead'])) ?>"
             alt="<?= e($press['lead']['outlet']) ?> coverage"
             loading="eager"
             referrerpolicy="no-referrer"
             onerror="this.onerror=null;this.src='<?= e(press_fallback_img($press['lead'])) ?>';">
        <span class="press-lead-badge"><?= icon('fa-solid','fa-star') ?> Featured</span>
        <span class="press-lead-index">01</span>
      </div>
      <div class="press-lead-body">
        <div class="press-meta-row">
          <span class="press-outlet-pill"><?= e($press['lead']['outlet']) ?></span>
          <span class="press-meta-sep">&middot;</span>
          <span class="press-meta-text"><?= e($press['lead']['type']) ?></span>
        </div>
        <h3 class="press-lead-title"><?= e($press['lead']['title']) ?></h3>
        <p class="press-lead-excerpt"><?= e($press['lead']['excerpt']) ?></p>
        <span class="press-lead-cta">Read full story <?= icon('fa-solid','fa-arrow-right') ?></span>
      </div>
    </a>

    <!-- ============ CARD GRID ============ -->
    <div class="press-grid">
      <?php foreach ($press['cards'] as $i => $c): ?>
        <?php $theme = $palettes[$i % count($palettes)]; ?>
        <a class="press-card reveal-item" href="<?= e($c['url']) ?>" target="_blank" rel="noopener">
          <div class="press-card-media">
            <img src="<?= e(press_live_img($c)) ?>"
                 alt="<?= e($c['outlet']) ?> coverage"
                 loading="lazy"
                 referrerpolicy="no-referrer"
                 onerror="this.onerror=null;this.src='<?= e(press_fallback_img($c)) ?>';">
          </div>
          <div class="press-card-body">
            <span class="press-card-num"><?= str_pad((string) ($i + 2), 2, '0', STR_PAD_LEFT) ?></span>
            <span class="press-outlet-pill small<?= !empty($c['accent']) ? ' accent' : '' ?>"><?= e($c['outlet']) ?></span>
            <h4 class="press-card-title"><?= e($c['title']) ?></h4>
            <span class="press-card-cta">Read <?= icon('fa-solid','fa-arrow-right') ?></span>
          </div>
        </a>
      <?php endforeach; ?>
    </div>

    <!-- ============ WIRE ============ -->
    <div class="press-wire">
      <div class="press-wire-head reveal">
        <h4 class="press-wire-title">From the wire</h4>
        <span class="press-wire-line"></span>
        <span class="press-wire-count"><?= count($press['wire']) ?> more stories</span>
      </div>
      <div class="press-wire-grid">
        <?php foreach ($press['wire'] as $i => $w): ?>
          <a class="press-wire-item reveal-item" href="<?= e($w['url']) ?>" target="_blank" rel="noopener">
            <span class="press-wire-num"><?= str_pad((string) ($i + 6), 2, '0', STR_PAD_LEFT) ?></span>
            <div class="press-wire-thumb">
              <img src="<?= e(press_live_img($w)) ?>"
                   alt=""
                   loading="lazy"
                   referrerpolicy="no-referrer"
                   onerror="this.onerror=null;this.src='<?= e(press_fallback_img($w)) ?>';">
            </div>
            <div class="press-wire-body">
              <span class="press-wire-outlet"><?= e($w['outlet']) ?></span>
              <h4 class="press-wire-headline"><?= e($w['title']) ?></h4>
            </div>
            <span class="press-wire-arrow"><?= icon('fa-solid','fa-arrow-right') ?></span>
          </a>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- ============ TICKER ============ -->
    <div class="press-ticker reveal">
      <span class="press-ticker-label">As featured in</span>
      <div class="press-ticker-viewport">
        <div class="press-ticker-track">
          <?php for ($i = 0; $i < 2; $i++): ?>
            <?php foreach ($press['outlets'] as $outlet): ?>
              <span><?= e($outlet) ?></span><i>&#9670;</i>
            <?php endforeach; ?>
          <?php endfor; ?>
        </div>
      </div>
    </div>

  </div>
</section>