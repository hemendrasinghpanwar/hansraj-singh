<?php
/* ============================================================
   PUBLICATIONS — Reports, papers, briefs
   ============================================================ */
$publications = [
    [
        'year'   => '2024',
        'type'   => 'Institutional Report',
        'title'  => 'Annual Report — Sambhali Trust',
        'desc'   => 'Comprehensive annual report covering programme impact, financials, and 2024 highlights.',
        'pages'  => '48 pages',
        'url'    => '#',
    ],
    [
        'year'   => '2023',
        'type'   => 'Impact Report',
        'title'  => 'COVID-19 Response: Together We Can',
        'desc'   => 'Documented the campaign that reached 3.5M people across 14 districts in Rajasthan.',
        'pages'  => '32 pages',
        'url'    => '#',
    ],
    [
        'year'   => '2023',
        'type'   => 'Policy Brief',
        'title'  => 'Pathshala: Rural Education Access',
        'desc'   => 'Policy recommendations on girls\' education in rural Rajasthan for state-level stakeholders.',
        'pages'  => '18 pages',
        'url'    => '#',
    ],
    [
        'year'   => '2022',
        'type'   => 'Research Paper',
        'title'  => 'Women in Rajasthan — Opportunity Report',
        'desc'   => 'Field research on women\'s livelihood access, education, and economic participation.',
        'pages'  => '56 pages',
        'url'    => '#',
    ],
    [
        'year'   => '2022',
        'type'   => 'Strategic Document',
        'title'  => 'Communications Strategy Framework',
        'desc'   => 'Internal strategy framework for institutional communications and digital presence.',
        'pages'  => '26 pages',
        'url'    => '#',
    ],
    [
        'year'   => '2021',
        'type'   => 'Guidelines',
        'title'  => 'Field Programme Documentation Standards',
        'desc'   => 'Standard operating procedures for documentation, reporting, and impact measurement.',
        'pages'  => '40 pages',
        'url'    => '#',
    ],
];
?>
<section class="section" id="publications" style="background:var(--ivory);">
  <div class="container container-narrow">

    <!-- ============ HEADER ============ -->
    <div class="section-head reveal">
      <h2 class="section-headline">Reports &amp; <em>publications.</em></h2>
      <p>Institutional reports, policy briefs, and impact publications authored or designed for mission-driven organisations.</p>
    </div>

    <!-- ============ PUBLICATIONS LIST ============ -->
    <div class="pub-list">
      <?php foreach ($publications as $i => $p): ?>
        <a class="pub-item reveal-item"
           href="<?= e($p['url']) ?>"
           target="_blank"
           rel="noopener">

          <span class="pub-num"><?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?></span>

          <div class="pub-body">
            <div class="pub-meta">
              <span class="pub-year"><?= e($p['year']) ?></span>
              <span class="pub-sep">&middot;</span>
              <span class="pub-type"><?= e($p['type']) ?></span>
            </div>
            <h4 class="pub-title"><?= e($p['title']) ?></h4>
            <p class="pub-desc"><?= e($p['desc']) ?></p>
          </div>

          <div class="pub-side">
            <span class="pub-pages"><?= e($p['pages']) ?></span>
            <span class="pub-arrow">
              <i class="fa-solid fa-download"></i>
            </span>
          </div>

        </a>
      <?php endforeach; ?>
    </div>

  </div>
</section>