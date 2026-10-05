<?php
declare(strict_types=1);

/* ============================================================
   init.php — Bootstrap file loaded by every page
   ============================================================ */

/* ---------- Load helpers + config ---------- */
require_once __DIR__ . '/functions.php';
$config = require __DIR__ . '/config.php';

/* ---------- Detect current page ---------- */
// This extracts the filename without the .php extension.
// e.g., 'index.php' becomes 'index', 'press.php' becomes 'press'.
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
if ($currentPage === 'index') {
    $currentPage = 'home';
}

/* ---------- Default page title ---------- */
// This sets a fallback title. If a specific page (like press.php) 
// defines $pageTitle AFTER requiring this file, that will override this.
$pageTitle = $pageTitle ?? ($config['profile']['name'] . ' — ' . $config['profile']['title']);