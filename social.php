<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/init.php';

$pageTitle      = 'Social — ' . $config['profile']['name'];
$pageHeroKicker = 'Live updates';
$pageHeroTitle  = 'Live from the <em>field.</em>';
$pageHeroLede   = 'Real-time feed across LinkedIn, Facebook, and Instagram — documenting work on multilateral engagement and field programmes.';
$pageHeroIcon   = 'fa-hashtag';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/preloader.php';
require_once __DIR__ . '/includes/nav.php';
require_once __DIR__ . '/includes/page-hero.php';

require __DIR__ . '/sections/social.php';

require_once __DIR__ . '/includes/footer.php';