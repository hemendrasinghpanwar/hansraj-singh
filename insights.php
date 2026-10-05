<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/init.php';

$pageTitle      = 'Insights — ' . $config['profile']['name'];
$pageHeroKicker = 'Field notes';
$pageHeroTitle  = 'Writing &amp; <em>insights.</em>';
$pageHeroLede   = 'Short essays on multilateral affairs, digital strategy, and social impact drawn from the field and the negotiating room.';
$pageHeroIcon   = 'fa-lightbulb';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/preloader.php';
require_once __DIR__ . '/includes/nav.php';
require_once __DIR__ . '/includes/page-hero.php';

require __DIR__ . '/sections/insights.php';

require_once __DIR__ . '/includes/footer.php';