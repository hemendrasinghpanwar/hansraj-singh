<?php
$pageHeroKicker = $pageHeroKicker ?? '';
$pageHeroTitle  = $pageHeroTitle  ?? '';
$pageHeroLede   = $pageHeroLede   ?? '';
$pageHeroIcon   = $pageHeroIcon   ?? 'fa-circle';
?>
<section class="page-hero">
  <div class="container container-narrow">
    <div class="page-hero-inner">
      <span class="page-hero-icon">
        <?= icon('fa-solid', $pageHeroIcon) ?>
      </span>
      <?php if ($pageHeroKicker): ?>
        <p class="page-hero-kicker"><?= e($pageHeroKicker) ?></p>
      <?php endif; ?>
      <h1 class="page-hero-title"><?= $pageHeroTitle ?></h1>
      <?php if ($pageHeroLede): ?>
        <p class="page-hero-lede"><?= e($pageHeroLede) ?></p>
      <?php endif; ?>
    </div>
  </div>
</section>