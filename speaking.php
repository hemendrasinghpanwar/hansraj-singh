<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/init.php';

$pageTitle      = 'Speaking — ' . $config['profile']['name'];
$pageHeroKicker = 'Engagements';
$pageHeroTitle  = 'On the <em>podium.</em>';
$pageHeroLede   = 'Panels, keynote addresses, formal statements, and workshops delivered at international convenings and civil-society platforms.';
$pageHeroIcon   = 'fa-microphone-lines';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/preloader.php';
require_once __DIR__ . '/includes/nav.php';
require_once __DIR__ . '/includes/page-hero.php';

require __DIR__ . '/sections/speaking.php';

require_once __DIR__ . '/includes/footer.php';