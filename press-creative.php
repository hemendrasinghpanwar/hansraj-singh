<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/init.php';

$pageTitle      = 'Press & Media — ' . $config['profile']['name'];
$pageHeroKicker = 'In the news';
$pageHeroTitle  = 'Press &amp; <em>media.</em>';
$pageHeroLede   = 'Coverage of engagements at the United Nations...';
$pageHeroIcon   = 'fa-newspaper';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/preloader.php';
require_once __DIR__ . '/includes/nav.php';
require_once __DIR__ . '/includes/page-hero.php';   // ← renders the top banner

require __DIR__ . '/sections/press-creative.php';   // ← was ALSO rendering the same banner

require_once __DIR__ . '/includes/footer.php';