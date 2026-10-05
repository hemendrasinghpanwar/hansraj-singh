<?php
$experience = $config['experience'];
?>
<section class="dossier" id="experience">
  <div class="container container-narrow">

    <!-- ============ HEADER — manila folder tab ============ -->
    <div class="dossier-head reveal">
      <div class="dossier-file-tab">
        <span class="dossier-file-tab-dot"></span>
        Mission Log
        <span class="dossier-file-tab-ref">Ref. HSR / 2025</span>
      </div>

      <div class="dossier-head-row">
        <div class="dossier-head-left">
          <p class="dossier-kicker">Career Record &middot; Since 2019</p>
          <h2 class="dossier-title">
            Diplomatic<br>
            <em>service record.</em>
          </h2>
          <p class="dossier-intro">
            A dossier of five assignments across grassroots NGO communications, UN advocacy,
            and institutional coordination &mdash; each logged with role, remit, and impact.
          </p>
        </div>

        <div class="dossier-head-right">
          <div class="dossier-stat">
            <span class="dossier-stat-num">05</span>
            <span class="dossier-stat-label">Missions</span>
          </div>
          <div class="dossier-stat">
            <span class="dossier-stat-num">06</span>
            <span class="dossier-stat-label">Years</span>
          </div>
          <div class="dossier-stat">
            <span class="dossier-stat-num">02</span>
            <span class="dossier-stat-label">Active</span>
          </div>
        </div>
      </div>
    </div>

    <!-- ============ DOSSIER ENTRIES ============ -->
    <div class="dossier-log">

      <?php
      $allEntries = array_merge(
          array_map(fn($r) => $r + ['status' => 'current'], $experience['current']),
          array_map(fn($r) => $r + ['status' => 'history'], $experience['history'])
      );

      foreach ($allEntries as $i => $role):
        $isCurrent = $role['status'] === 'current';
        $loc = 'Geneva · CH'; // default
        // crude location derivation for the footer code
        if (stripos($role['org'], 'Choyal') !== false)         $loc = 'Jodhpur · IN';
        elseif (stripos($role['org'], 'Sambhali') !== false)   $loc = 'Jodhpur · IN';
        elseif (stripos($role['org'], 'RSKS') !== false)       $loc = 'Ajmer · IN';
        elseif (stripos($role['org'], 'Human Rights') !== false) $loc = 'Geneva · CH';
        elseif (stripos($role['org'], 'Athens') !== false)     $loc = 'Athens · GR';
      ?>
        <article class="dossier-entry reveal-item<?= $isCurrent ? ' is-current' : '' ?>">

          <!-- Left · number block -->
          <div class="dossier-number">
            <span class="dossier-number-vertical">Mission</span>
            <span class="dossier-number-value"><?= e($role['num']) ?></span>
            <span class="dossier-number-dot"></span>
          </div>

          <!-- Right · body -->
          <div class="dossier-body">

            <!-- Meta strip -->
            <div class="dossier-meta">
              <span class="dossier-meta-range"><?= e($role['years']) ?></span>
              <span class="dossier-meta-rule"></span>
              <?php if ($isCurrent): ?>
                <span class="dossier-status is-active">
                  <span></span>Active
                </span>
              <?php else: ?>
                <span class="dossier-status">Logged</span>
              <?php endif; ?>
            </div>

            <!-- Title row -->
            <div class="dossier-title-row">
              <span class="dossier-icon"><?= icon('fa-solid', $role['icon']) ?></span>
              <div class="dossier-title-text">
                <h3 class="dossier-role"><?= e($role['title']) ?></h3>
                <span class="dossier-org"><?= e($role['org']) ?></span>
              </div>
            </div>

            <!-- Description -->
            <p class="dossier-desc"><?= e($role['desc']) ?></p>

            <!-- Footer · tags + location -->
            <div class="dossier-footer">
              <div class="dossier-tags">
                <?php foreach ($role['tags'] as $tag): ?>
                  <span class="dossier-tag"><?= e($tag) ?></span>
                <?php endforeach; ?>
              </div>
              <span class="dossier-loc"><?= e($loc) ?></span>
            </div>

          </div>
        </article>
      <?php endforeach; ?>

    </div>

    <!-- ============ FOOTER NOTE ============ -->
    <div class="dossier-signoff reveal">
      <span class="dossier-signoff-mark"><?= icon('fa-solid','fa-circle-check') ?></span>
      <p>
        <strong>End of record.</strong>
        Full references and portfolio available on request through official correspondence.
      </p>
    </div>

  </div>
</section>