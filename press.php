<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/init.php';

// 1. Override the default title from init.php
$pageTitle      = 'Press & Media — ' . $config['profile']['name'];

// 2. Set the variables for the Hero banner
$pageHeroKicker = 'In the news';
$pageHeroTitle  = 'Press &amp; <em>media.</em>';
$pageHeroLede   = 'Coverage of engagements at the United Nations, national media features, and field stories from Rajasthan and beyond.';
$pageHeroIcon   = 'fa-newspaper';

// 3. Load the top parts of the site
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/preloader.php';
require_once __DIR__ . '/includes/nav.php';

// 4. Render the top banner (Hero section)
require_once __DIR__ . '/includes/page-hero.php';

// 5. Render the main content (Newspaper clippings, Lead story, etc.)
require __DIR__ . '/sections/press-creative.php';

// 6. Load the footer
require_once __DIR__ . '/includes/footer.php';