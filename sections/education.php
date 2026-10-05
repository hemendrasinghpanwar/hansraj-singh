<section class="section" style="background:var(--ivory);">
  <div class="container container-narrow">
    <div class="section-head reveal">
      <p class="section-label">Education</p>
      <h2 class="section-headline">
        Academic<br>
        <em>foundations.</em>
      </h2>
      <div class="divider-rule"></div>
    </div>
    <div class="row g-4">
      <?php foreach ($config['education'] as $edu): ?>
        <div class="col-md-4 reveal-item">
          <div class="ucard edu-card">
            <?= icon('fa-solid', $edu['icon']) ?>
            <h4><?= e($edu['title']) ?></h4>
            <span><?= e($edu['detail']) ?></span>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>