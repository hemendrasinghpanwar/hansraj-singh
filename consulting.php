<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/init.php';

$pageTitle      = 'Consulting — ' . $config['profile']['name'];
$pageHeroKicker = 'Advisory services';
$pageHeroTitle  = 'Consulting &amp; <em>advisory.</em>';
$pageHeroLede   = 'Working with NGOs, institutions, and social-impact organisations on multilateral strategy, communications, and digital transformation.';
$pageHeroIcon   = 'fa-handshake-angle';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/preloader.php';
require_once __DIR__ . '/includes/nav.php';
require_once __DIR__ . '/includes/page-hero.php';

require __DIR__ . '/sections/consulting.php';

require_once __DIR__ . '/includes/footer.php';