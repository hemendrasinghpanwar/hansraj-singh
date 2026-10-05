<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/init.php';

$pageTitle      = 'Gallery — ' . $config['profile']['name'];
$pageHeroKicker = 'Visual record';
$pageHeroTitle  = 'Photo <em>gallery.</em>';
$pageHeroLede   = 'Moments from the UN Human Rights Council, field programmes, and community engagements.';
$pageHeroIcon   = 'fa-images';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/preloader.php';
require_once __DIR__ . '/includes/nav.php';
require_once __DIR__ . '/includes/page-hero.php';

require __DIR__ . '/sections/gallery.php';

require_once __DIR__ . '/includes/footer.php';