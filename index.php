<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/init.php';

$pageTitle = $config['profile']['name'] . ' — ' . $config['profile']['title'];

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/preloader.php';
require_once __DIR__ . '/includes/nav.php';
?>

<!-- HOME ANCHOR -->
<div id="home"></div>

<?php require __DIR__ . '/sections/hero.php';    ?>
<?php require __DIR__ . '/sections/marquee.php'; ?>

<!-- ABOUT ANCHOR -->
<div id="about">
  <?php require __DIR__ . '/sections/about.php'; ?>
</div>

<!-- PARTNERS ANCHOR -->
<div id="partners">
  <?php require __DIR__ . '/sections/partners.php'; ?>
</div>

<?php require __DIR__ . '/sections/expertise.php';  ?>
<?php require __DIR__ . '/sections/experience.php'; ?>
<?php require __DIR__ . '/sections/press.php';      ?>
<?php require __DIR__ . '/sections/gallery.php';    ?>
<!-- TESTIMONIALS (STALWART SAYS) ANCHOR -->
<div id="testimonials">
  <?php require __DIR__ . '/sections/testimonials.php'; ?>
</div>
<?php require __DIR__ . '/sections/social.php';     ?>



<!-- CONTACT ANCHOR -->
<div id="contact">
  <?php require __DIR__ . '/sections/contact.php'; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>