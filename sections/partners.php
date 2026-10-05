<?php
/* ============================================================
   sections/partners.php — Partner logos with name text
   Uses Clearbit Logo API + Google favicon fallback.
   ============================================================ */

/* ---------- Partner data ---------- */
$partnerData = [
    'strategic' => [
        ['name' => 'United Nations',   'domain' => 'un.org',        'url' => 'https://www.un.org/'],
        ['name' => 'UN Human Rights',  'domain' => 'ohchr.org',     'url' => 'https://www.ohchr.org/'],
        ['name' => 'ECOSOC',           'domain' => 'ecosoc.un.org', 'url' => 'https://ecosoc.un.org/'],
        ['name' => 'Obama Foundation', 'domain' => 'obama.org',     'url' => 'https://www.obama.org/'],
        ['name' => 'UN Web TV',        'domain' => 'webtv.un.org',  'url' => 'https://webtv.un.org/'],
    ],
    'institutional' => [
        ['name' => 'Sambhali Trust',   'domain' => 'sambhali.org',  'url' => 'https://www.sambhali.org/'],
        ['name' => 'RSKS India',       'domain' => 'rsksindia.org', 'url' => 'https://www.rsksindia.org/'],
        ['name' => 'UNESCO',           'domain' => 'unesco.org',    'url' => 'https://www.unesco.org/'],
        ['name' => 'UNDP',             'domain' => 'undp.org',      'url' => 'https://www.undp.org/'],
        ['name' => 'Choyal Group',     'domain' => 'choyal.com',    'url' => 'https://www.choyal.com/'],
        ['name' => 'UNICEF',           'domain' => 'unicef.org',    'url' => 'https://www.unicef.org/'],
    ],
    'media' => [
        ['name' => 'ThePrint',            'domain' => 'theprint.in',                    'url' => 'https://theprint.in/'],
        ['name' => 'ANI News',            'domain' => 'aninews.in',                     'url' => 'https://aninews.in/'],
        ['name' => 'Times of India',      'domain' => 'timesofindia.indiatimes.com',    'url' => 'https://timesofindia.indiatimes.com/'],
        ['name' => 'London Channel News', 'domain' => 'londonchannelnews.com',          'url' => 'https://www.londonchannelnews.com/'],
        ['name' => 'Dainik Bhaskar',      'domain' => 'bhaskar.com',                    'url' => 'https://www.bhaskar.com/'],
        ['name' => 'Hindustan Times',     'domain' => 'hindustantimes.com',             'url' => 'https://www.hindustantimes.com/'],
    ],
];

/* ---------- Logo URL helpers ---------- */
function partner_logo_url(string $domain): string
{
    return 'https://logo.clearbit.com/' . $domain;
}

function partner_favicon_url(string $domain): string
{
    return 'https://www.google.com/s2/favicons?domain=' . $domain . '&sz=128';
}
?>
<section class="section partners-section" id="partners">
  <div class="container container-narrow">

    <!-- ============ HEADER ============ -->
    <div class="partners-head reveal">
      <p class="partners-kicker">
        <span class="partners-kicker-dot"></span>
        Trusted by
      </p>
      <h2 class="section-headline partners-title">
        Partners &amp; <em>collaborators.</em>
      </h2>
      <p class="partners-lede">
        Working alongside international institutions, civil-society networks, and media platforms on multilateral engagement and field programmes.
      </p>
    </div>

  </div>

  <!-- ============ MARQUEE STACK ============ -->
  <div class="partners-marquee reveal">

    <!-- Row 1 · Strategic -->
    <div class="partner-row partner-row--strategic">
      <div class="partner-row-inner">
        <?php for ($i = 0; $i < 2; $i++): ?>
          <?php foreach ($partnerData['strategic'] as $p): ?>
            <a class="partner-logo partner-logo--lg"
               href="<?= e($p['url']) ?>"
               target="_blank" rel="noopener"
               aria-label="<?= e($p['name']) ?>">
              <span class="partner-logo-mark">
                <img src="<?= e(partner_logo_url($p['domain'])) ?>"
                     alt="<?= e($p['name']) ?>"
                     loading="lazy"
                     onerror="this.onerror=null;this.src='<?= e(partner_favicon_url($p['domain'])) ?>';">
              </span>
              <span class="partner-logo-name"><?= e($p['name']) ?></span>
            </a>
          <?php endforeach; ?>
        <?php endfor; ?>
      </div>
    </div>

    <!-- Row 2 · Institutional -->
    <div class="partner-row partner-row--institutional">
      <div class="partner-row-inner">
        <?php for ($i = 0; $i < 2; $i++): ?>
          <?php foreach ($partnerData['institutional'] as $p): ?>
            <a class="partner-logo partner-logo--md"
               href="<?= e($p['url']) ?>"
               target="_blank" rel="noopener"
               aria-label="<?= e($p['name']) ?>">
              <span class="partner-logo-mark">
                <img src="<?= e(partner_logo_url($p['domain'])) ?>"
                     alt="<?= e($p['name']) ?>"
                     loading="lazy"
                     onerror="this.onerror=null;this.src='<?= e(partner_favicon_url($p['domain'])) ?>';">
              </span>
              <span class="partner-logo-name"><?= e($p['name']) ?></span>
            </a>
          <?php endforeach; ?>
        <?php endfor; ?>
      </div>
    </div>

    <!-- Row 3 · Media -->
    <div class="partner-row partner-row--media">
      <div class="partner-row-inner">
        <?php for ($i = 0; $i < 2; $i++): ?>
          <?php foreach ($partnerData['media'] as $p): ?>
            <a class="partner-logo partner-logo--sm"
               href="<?= e($p['url']) ?>"
               target="_blank" rel="noopener"
               aria-label="<?= e($p['name']) ?>">
              <span class="partner-logo-mark">
                <img src="<?= e(partner_logo_url($p['domain'])) ?>"
                     alt="<?= e($p['name']) ?>"
                     loading="lazy"
                     onerror="this.onerror=null;this.src='<?= e(partner_favicon_url($p['domain'])) ?>';">
              </span>
              <span class="partner-logo-name"><?= e($p['name']) ?></span>
            </a>
          <?php endforeach; ?>
        <?php endfor; ?>
      </div>
    </div>

  </div>

  <!-- ============ BADGE ============ -->
  <div class="container container-narrow">
    <div class="partners-badge reveal">
      <i class="fa-solid fa-circle-check"></i>
      <span>
        <strong>17+</strong> institutional &amp; media partners across <strong>4</strong> countries
      </span>
    </div>
  </div>

</section>