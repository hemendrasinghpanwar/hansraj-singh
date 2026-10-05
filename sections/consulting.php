<?php
/* ============================================================
   CONSULTING — Advisory services for mission-driven orgs
   ============================================================ */
$services = [
    [
        'icon'   => 'fa-globe',
        'title'  => 'Multilateral Strategy',
        'text'   => 'Preparing delegations for UNHRC, ECOSOC, and treaty-body engagements — from statement drafting to negotiation support.',
        'points' => ['UNHRC statement drafting', 'ECOSOC positioning', 'Delegation prep', 'Negotiation support'],
    ],
    [
        'icon'   => 'fa-bullhorn',
        'title'  => 'Communications & Reporting',
        'text'   => 'Annual reports, impact publications, and institutional storytelling that turn programme data into persuasive advocacy.',
        'points' => ['Annual report design', 'Impact storytelling', 'Policy briefs', 'Donor communications'],
    ],
    [
        'icon'   => 'fa-laptop-code',
        'title'  => 'Digital & Web',
        'text'   => 'Website development, CMS setup, and digital platform strategy for mission-driven organisations.',
        'points' => ['Website development', 'CMS integration', 'Digital strategy', 'Analytics setup'],
    ],
    [
        'icon'   => 'fa-hashtag',
        'title'  => 'Social Media Strategy',
        'text'   => 'Content calendars, channel strategy, and analytics for institutional accounts on LinkedIn, Instagram, and X.',
        'points' => ['Content calendar', 'Channel strategy', 'Paid campaigns', 'Performance analytics'],
    ],
];
?>
<section class="section" id="consulting">
  <div class="container container-narrow">

    <!-- ============ HEADER ============ -->
    <div class="section-head reveal">
      <h2 class="section-headline">Advisory &amp; <em>consulting.</em></h2>
      <p>Working with NGOs, institutions, and social-impact organisations on multilateral strategy, communications, and digital transformation.</p>
    </div>

    <!-- ============ SERVICES GRID ============ -->
    <div class="consulting-grid">
      <?php foreach ($services as $s): ?>
        <div class="consulting-card reveal-item">
          <div class="consulting-icon">
            <?= icon('fa-solid', $s['icon']) ?>
          </div>
          <h3 class="consulting-title"><?= e($s['title']) ?></h3>
          <p class="consulting-text"><?= e($s['text']) ?></p>

          <ul class="consulting-list">
            <?php foreach ($s['points'] as $p): ?>
              <li>
                <i class="fa-solid fa-check"></i>
                <?= e($p) ?>
              </li>
            <?php endforeach; ?>
          </ul>

          <a href="#contact" class="consulting-cta">
            Discuss this service
            <i class="fa-solid fa-arrow-right"></i>
          </a>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- ============ CTA STRIP ============ -->
    <div class="consulting-cta-strip reveal">
      <div class="consulting-cta-content">
        <h3>Have a project in mind?</h3>
        <p>Let's discuss how I can help your organisation achieve its goals.</p>
      </div>
      <a href="#contact" class="btn-gold">Start a conversation <?= icon('fa-solid','fa-arrow-right') ?></a>
    </div>

  </div>
</section>