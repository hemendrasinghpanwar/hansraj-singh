<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/init.php';

$pageTitle      = 'Publications — ' . $config['profile']['name'];
$pageHeroKicker = 'Downloads';
$pageHeroTitle  = 'Reports &amp; <em>publications.</em>';
$pageHeroLede   = 'Institutional reports, policy briefs, and impact publications authored or designed for mission-driven organisations.';
$pageHeroIcon   = 'fa-file-lines';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/preloader.php';
require_once __DIR__ . '/includes/nav.php';
require_once __DIR__ . '/includes/page-hero.php';

require __DIR__ . '/sections/publications.php';

require_once __DIR__ . '/includes/footer.php';