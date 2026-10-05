<section class="section" id="representation">
  <div class="container container-narrow">
    <div class="section-head reveal">
      <p class="section-label">Representation &amp; forums</p>
      <h2 class="section-headline">
        Engagement across<br>
        <em>multilateral settings.</em>
      </h2>
      <div class="divider-rule"></div>
    </div>
    <div class="row g-4">
      <?php foreach ($config['representation'] as $rep): ?>
        <div class="col-md-6 col-lg-3 reveal-item">
          <div class="ucard rep-card">
            <?= icon('fa-solid', $rep['icon']) ?>
            <h4><?= e($rep['title']) ?></h4>
            <span><?= e($rep['loc']) ?></span>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>