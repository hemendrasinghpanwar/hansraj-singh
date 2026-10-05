<?php
/* ============================================================
   INSIGHTS — Field notes, writing, opinion
   ============================================================ */
$insights = [
    [
        'tag'     => 'Advocacy',
        'date'    => 'Sep 2024',
        'read'    => '6 min read',
        'title'   => 'How NGOs Get Heard at the UN',
        'excerpt' => 'Practical lessons on drafting statements that actually get selected, building delegate relationships, and timing submissions for maximum impact.',
        'url'     => '#',
    ],
    [
        'tag'     => 'Strategy',
        'date'    => 'Jul 2024',
        'read'    => '4 min read',
        'title'   => 'The Case for Digital-First NGOs',
        'excerpt' => 'Why mission-driven organisations that invest early in websites, social strategy, and analytics outperform peers within 18 months.',
        'url'     => '#',
    ],
    [
        'tag'     => 'UNHRC',
        'date'    => 'May 2024',
        'read'    => '8 min read',
        'title'   => 'Writing Statements That Get Selected',
        'excerpt' => 'A field-tested framework for structuring oral statements: evidence, narrative, ask. Drawn from 58 delivered statements.',
        'url'     => '#',
    ],
    [
        'tag'     => 'Comms',
        'date'    => 'Feb 2024',
        'read'    => '5 min read',
        'title'   => 'Impact Reporting Beyond Numbers',
        'excerpt' => 'Why annual reports that tell stories outperform data-only reports — and how to combine the two into one document.',
        'url'     => '#',
    ],
    [
        'tag'     => 'Field',
        'date'    => 'Nov 2023',
        'read'    => '7 min read',
        'title'   => 'What Rural Rajasthan Taught Me About Scale',
        'excerpt' => 'Reflections on the Together We Can campaign — reaching 3.5M people without a corporate budget.',
        'url'     => '#',
    ],
    [
        'tag'     => 'Leadership',
        'date'    => 'Aug 2023',
        'read'    => '6 min read',
        'title'   => 'Managing 25 People Without a Handbook',
        'excerpt' => 'Lessons from leading a communications team of 25+ at a national NGO — what worked, what didn\'t, and what I\'d do differently.',
        'url'     => '#',
    ],
];
?>
<section class="section" id="insights" style="background:var(--ivory);">
  <div class="container container-narrow">

    <!-- ============ HEADER ============ -->
    <div class="section-head reveal">
      <h2 class="section-headline">Field <em>notes.</em></h2>
      <p>Short writing on multilateral affairs, digital strategy, and social impact — drawn from the field and the negotiating room.</p>
    </div>

    <!-- ============ INSIGHTS GRID ============ -->
    <div class="insight-grid">
      <?php foreach ($insights as $i): ?>
        <a class="insight-card reveal-item"
           href="<?= e($i['url']) ?>">

          <div class="insight-header">
            <span class="insight-tag"><?= e($i['tag']) ?></span>
            <span class="insight-date"><?= e($i['date']) ?></span>
          </div>

          <h4 class="insight-title"><?= e($i['title']) ?></h4>
          <p class="insight-excerpt"><?= e($i['excerpt']) ?></p>

          <div class="insight-foot">
            <span class="insight-read">
              <i class="fa-regular fa-clock"></i>
              <?= e($i['read']) ?>
            </span>
            <span class="insight-cta">
              Read
              <i class="fa-solid fa-arrow-right"></i>
            </span>
          </div>

        </a>
      <?php endforeach; ?>
    </div>

  </div>
</section>