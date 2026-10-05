<?php
/* ============================================================
   SPEAKING — Panels, statements, keynote engagements
   ============================================================ */
$engagements = [
    [
        'icon'  => 'fa-landmark',
        'year'  => '2024',
        'tag'   => 'UNHRC',
        'title' => 'UNHRC 57th Session — Oral Statement',
        'org'   => 'UN Human Rights Council · Geneva',
        'desc'  => 'Delivered an oral statement on gender equality and disability rights, calling for stronger multilateral action on inclusion and social justice.',
        'stats' => ['5 min delivery', '1,200+ viewers'],
    ],
    [
        'icon'  => 'fa-earth-americas',
        'year'  => '2023',
        'tag'   => 'ECOSOC',
        'title' => 'ECOSOC High-Level Segment — Panel',
        'org'   => 'United Nations · New York',
        'desc'  => 'Panel discussion on civil-society engagement and SDG progress with delegates from 40+ member states.',
        'stats' => ['40+ delegations', '3 SDGs covered'],
    ],
    [
        'icon'  => 'fa-star',
        'year'  => '2023',
        'tag'   => 'Recognition',
        'title' => 'Obama Foundation Leaders Convening',
        'org'   => 'Athens, Greece',
        'desc'  => 'Selected as one of the Asia leaders to meet former US President Barack Obama and discuss civic engagement strategy.',
        'stats' => ['Asia leader', '~200 peers'],
    ],
    [
        'icon'  => 'fa-microphone',
        'year'  => '2022',
        'tag'   => 'Education',
        'title' => 'Regional Conference on Rural Education',
        'org'   => 'UNESCO · New Delhi',
        'desc'  => 'Keynote on rural education access and girls\' schooling in Rajasthan, drawing on 5+ years of field programme experience.',
        'stats' => ['Keynote', '300+ attendees'],
    ],
    [
        'icon'  => 'fa-chalkboard-user',
        'year'  => '2022',
        'tag'   => 'Workshop',
        'title' => 'Digital Storytelling for NGOs',
        'org'   => 'RSKS India · Ajmer',
        'desc'  => 'Two-day training workshop for 25+ communications staff on annual report design, social media strategy, and impact storytelling.',
        'stats' => ['25+ staff trained', '2-day workshop'],
    ],
    [
        'icon'  => 'fa-hand-holding-heart',
        'year'  => '2021',
        'tag'   => 'COVID-19',
        'title' => 'Together We Can — Campaign Launch',
        'org'   => 'Rajasthan State Launch · Jodhpur',
        'desc'  => 'Public launch event for the COVID-19 relief campaign that ultimately reached 3.5M people across Rajasthan.',
        'stats' => ['3.5M reached', 'State-wide'],
    ],
];
?>
<section class="section" id="speaking">
  <div class="container container-narrow">

    <!-- ============ HEADER ============ -->
    <div class="section-head reveal">
      <h2 class="section-headline">On the <em>podium.</em></h2>
      <p>Select engagements, panels, and formal statements delivered at international convenings and civil-society platforms.</p>
    </div>

    <!-- ============ ENGAGEMENTS GRID ============ -->
    <div class="exp-grid-history">
      <?php foreach ($engagements as $e): ?>
        <div class="exp-card reveal-item">
          <div class="exp-card-top">
            <div class="exp-icon"><?= icon('fa-solid', $e['icon']) ?></div>
            <span class="exp-year-badge"><?= e($e['year']) ?></span>
          </div>

          <span class="exp-org"><?= e($e['org']) ?></span>
          <h4><?= e($e['title']) ?></h4>
          <p class="exp-desc"><?= e($e['desc']) ?></p>

          <?php if (!empty($e['stats'])): ?>
            <div class="speaking-stats">
              <?php foreach ($e['stats'] as $s): ?>
                <span class="speaking-stat">
                  <i class="fa-solid fa-circle-check"></i>
                  <?= e($s) ?>
                </span>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>