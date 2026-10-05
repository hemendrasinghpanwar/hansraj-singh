<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/init.php';

$pageTitle      = 'Videos — ' . $config['profile']['name'];
$pageHeroKicker = 'Broadcasts & interviews';
$pageHeroTitle  = 'Watch &amp; <em>listen.</em>';
$pageHeroLede   = 'Recorded statements, interviews, panel discussions, and field documentaries.';
$pageHeroIcon   = 'fa-video';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/preloader.php';
require_once __DIR__ . '/includes/nav.php';
require_once __DIR__ . '/includes/page-hero.php';

require __DIR__ . '/sections/videos.php';

require_once __DIR__ . '/includes/footer.php';