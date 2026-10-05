<div class="marquee-strip">
  <div class="marquee-track">
    <?php for ($i = 0; $i < 2; $i++): ?>
      <div class="marquee-group" style="display:flex;"<?= $i ? ' aria-hidden="true"' : '' ?>>
        <?php foreach ($config['marquee'] as $item): ?>
          <span class="marquee-item"><?= icon('fa-solid','fa-diamond') ?><?= e($item) ?></span>
        <?php endforeach; ?>
      </div>
    <?php endfor; ?>
  </div>
</div>