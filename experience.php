<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/init.php';

$pageTitle      = 'Experience — ' . $config['profile']['name'];
$pageHeroKicker = 'Career record';
$pageHeroTitle  = 'Professional <em>record.</em>';
$pageHeroLede   = 'Five-plus years across multilateral affairs, institutional communications, and digital strategy — from Rajasthan to Geneva.';
$pageHeroIcon   = 'fa-briefcase';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/preloader.php';
require_once __DIR__ . '/includes/nav.php';
require_once __DIR__ . '/includes/page-hero.php';

require __DIR__ . '/sections/experience.php';

require_once __DIR__ . '/includes/footer.php';