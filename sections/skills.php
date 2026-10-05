<section class="section" id="skills">
  <div class="container container-narrow">

    <div class="caps-head reveal">
      <div class="caps-rail">
        <span class="caps-rail-tag"><span class="caps-tag-dot"></span>Capabilities</span>
        <span class="caps-rail-line"></span>
        <span class="caps-rail-meta">Skill Index</span>
      </div>
      <div class="caps-head-grid">
        <div class="caps-head-left">
          <h2 class="caps-title">What he brings to the <span class="caps-title-accent">table</span>.</h2>
          <p class="caps-intro">A working mix of institutional communications, public-facing leadership, and the digital tools that keep both running smoothly.</p>
        </div>
        <div class="caps-head-right">
          <div class="caps-meta-block">
            <span class="caps-meta-num"><?= count($config['skills']) ?></span>
            <span class="caps-meta-label">Core Skills</span>
          </div>
          <div class="caps-meta-block">
            <span class="caps-meta-num"><?= count($config['languages']) ?></span>
            <span class="caps-meta-label">Languages</span>
          </div>
        </div>
      </div>
    </div>

    <div class="caps-grid">
      <div class="caps-panel reveal-item">
        <div class="caps-panel-head">
          <h4>Core skills</h4>
          <span class="caps-panel-count"><?= count($config['skills']) ?> Total</span>
        </div>
        <div class="skill-tile-grid">
          <?php foreach ($config['skills'] as $skill): ?>
            <div class="skill-tile">
              <span class="skill-tile-icon">
                <?= icon(!empty($skill['brand']) ? 'fa-brands' : 'fa-solid', $skill['icon']) ?>
              </span>
              <span><?= e($skill['label']) ?></span>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="caps-stack">
        <div class="caps-panel reveal-item">
          <div class="caps-panel-head">
            <h4>Languages</h4>
            <span class="caps-panel-count"><?= count($config['languages']) ?> Total</span>
          </div>
          <div class="lang-list">
            <?php foreach ($config['languages'] as $lang): ?>
              <div class="lang-row">
                <span class="lang-name">
                  <?= e($lang['name']) ?>
                  <?php if (!empty($lang['note'])): ?>
                    <small>(<?= e($lang['note']) ?>)</small>
                  <?php endif; ?>
                </span>
                <span class="lang-level">
                  <?php for ($i = 1; $i <= 5; $i++): ?>
                    <i class="<?= $i <= $lang['level'] ? 'on' : '' ?>"></i>
                  <?php endfor; ?>
                </span>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="caps-panel reveal-item">
          <div class="caps-panel-head">
            <h4>Beyond work</h4>
            <span class="caps-panel-count"><?= count($config['interests']) ?> Total</span>
          </div>
          <div class="interest-tag-wrap">
            <?php foreach ($config['interests'] as $interest): ?>
              <span class="interest-tag"><?= icon('fa-solid', $interest['icon']) ?><?= e($interest['label']) ?></span>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>