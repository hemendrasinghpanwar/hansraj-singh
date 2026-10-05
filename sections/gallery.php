<?php
/* ============================================================
   sections/gallery.php — Photo Gallery Section
   ============================================================ */

/**
 * Helper to ensure the image path is correct.
 * If the path doesn't already contain 'assets/', prepend it.
 */
function gallery_img_path(string $path): string
{
    if (empty($path)) {
        return '';
    }
    // If it's already a full URL or contains 'assets/', return as-is.
    if (preg_match('#^https?://#i', $path) || strpos($path, 'assets/') === 0) {
        return $path;
    }
    // Otherwise, prepend the default local assets path.
    return 'assets/images/gallery/' . ltrim($path, '/');
}
?>
<section class="section" id="gallery" style="background:#fff;">
  <div class="container container-narrow">
    <div class="section-head reveal">
      <p class="section-label">Gallery</p>
      <h2 class="section-headline">
        Moments from<br>
        <em>the field.</em>
      </h2>
      <div class="divider-rule"></div>
    </div>
    <div class="gallery-grid">
      <?php foreach ($config['gallery'] as $item): ?>
        <?php if (($item['type'] ?? 'photo') === 'photo'): ?>
          <?php 
            $imgPath = gallery_img_path($item['img'] ?? '');
            // Skip if no image path is defined
            if (empty($imgPath)) continue; 
          ?>
          <div class="gallery-item reveal-item"
               data-type="photo"
               data-cap="<?= e($item['cap']) ?>"
               data-loc="<?= e($item['loc']) ?>">
            <div class="gallery-media">
              <img src="<?= e($imgPath) ?>" 
                   alt="<?= e($item['cap']) ?>" 
                   loading="lazy">
            </div>
            <div class="gallery-overlay">
              <span class="gallery-cap"><?= e($item['cap']) ?></span>
              <span class="gallery-loc"><?= e($item['loc']) ?></span>
            </div>
            <div class="gallery-expand"><?= icon('fa-solid','fa-expand') ?></div>
          </div>
        <?php else: ?>
          <!-- Fallback for icon items (if you still want to use them) -->
          <div class="gallery-item reveal-item"
               data-type="icon"
               data-icon="<?= e($item['icon']) ?>"
               data-cap="<?= e($item['cap']) ?>"
               data-loc="<?= e($item['loc']) ?>">
            <div class="gallery-media <?= e($item['tile']) ?>"><?= icon('fa-solid', $item['icon']) ?></div>
            <div class="gallery-overlay">
              <span class="gallery-cap"><?= e($item['cap']) ?></span>
              <span class="gallery-loc"><?= e($item['loc']) ?></span>
            </div>
            <div class="gallery-expand"><?= icon('fa-solid','fa-expand') ?></div>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Gallery lightbox -->
<div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content gallery-modal-content">
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      <div id="modalMediaWrap"></div>
      <div class="modal-caption">
        <h5 id="modalCap"></h5>
        <span id="modalLoc"></span>
      </div>
    </div>
  </div>
</div>