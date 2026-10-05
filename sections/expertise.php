<section class="section" id="expertise" style="background:#fff;">
  <div class="container container-narrow">
    <div class="section-head reveal">
      <p class="section-label">Areas of expertise</p>
      <h2 class="section-headline">
        Where coordination<br>
        <em>meets policy.</em>
      </h2>
      <div class="divider-rule"></div>
    </div>
    <div class="bento">
      <?php foreach ($config['expertise'] as $item): ?>
        <div class="span-<?= (int) $item['span'] ?> reveal-item">
          <div class="ucard<?= !empty($item['featured']) ? ' featured' : '' ?>">
            <div class="ucard-icon"><?= icon('fa-solid', $item['icon']) ?></div>
            <h4><?= e($item['title']) ?></h4>
            <p><?= e($item['text']) ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>