<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/init.php';

$pageTitle      = 'Contact — ' . $config['profile']['name'];
$pageHeroKicker = 'Get in touch';
$pageHeroTitle  = 'Let\'s <em>talk.</em>';
$pageHeroLede   = 'Collaboration, consulting engagements, speaking invitations, or media enquiries — I respond within two business days.';
$pageHeroIcon   = 'fa-envelope';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/preloader.php';
require_once __DIR__ . '/includes/nav.php';
require_once __DIR__ . '/includes/page-hero.php';

require __DIR__ . '/sections/contact.php';

require_once __DIR__ . '/includes/footer.php';