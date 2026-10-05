<section class="impact section">
  <div class="container container-narrow">
    <div class="row text-center gy-4">
      <?php foreach ($config['stats'] as $stat): ?>
        <div class="col-6 col-md-3">
          <div class="stat-num" data-count="<?= e((string) $stat['value']) ?>" data-suffix="<?= e($stat['suffix']) ?>">0</div>
          <div class="stat-label"><?= e($stat['label']) ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>