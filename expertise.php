<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/init.php';

$pageTitle      = 'Expertise — ' . $config['profile']['name'];
$pageHeroKicker = 'What I do';
$pageHeroTitle  = 'Areas of <em>expertise.</em>';
$pageHeroLede   = 'Six core competencies built over five-plus years of multilateral engagement, communications, and digital strategy.';
$pageHeroIcon   = 'fa-layer-group';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/preloader.php';
require_once __DIR__ . '/includes/nav.php';
require_once __DIR__ . '/includes/page-hero.php';

require __DIR__ . '/sections/expertise.php';

require_once __DIR__ . '/includes/footer.php';