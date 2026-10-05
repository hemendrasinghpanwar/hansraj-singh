<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/init.php';

$pageTitle      = 'FAQ — ' . $config['profile']['name'];
$pageHeroKicker = 'Common questions';
$pageHeroTitle  = 'Questions &amp; <em>answers.</em>';
$pageHeroLede   = 'Quick answers on collaboration, scope, rates, and how engagements typically work.';
$pageHeroIcon   = 'fa-circle-question';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/preloader.php';
require_once __DIR__ . '/includes/nav.php';
require_once __DIR__ . '/includes/page-hero.php';

require __DIR__ . '/sections/faq.php';

require_once __DIR__ . '/includes/footer.php';