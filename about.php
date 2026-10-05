<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/init.php';

$pageTitle      = 'About — ' . $config['profile']['name'];
$pageHeroKicker = 'Who I am';
$pageHeroTitle  = 'About <em>Hansraj.</em>';
$pageHeroLede   = 'Coordinator for UN Affairs & ECOSOC liaison, communications strategist, and digital consultant working with mission-driven institutions.';
$pageHeroIcon   = 'fa-user';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/preloader.php';
require_once __DIR__ . '/includes/nav.php';
require_once __DIR__ . '/includes/page-hero.php';

require __DIR__ . '/sections/about.php';

require_once __DIR__ . '/includes/footer.php';