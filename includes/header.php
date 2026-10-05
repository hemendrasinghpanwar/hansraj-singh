<?php
if (!isset($config)) { $config = require __DIR__ . '/config.php'; }
if (!function_exists('e')) { require_once __DIR__ . '/functions.php'; }
$pageTitle = $config['profile']['name'] . ' — ' . $config['profile']['title'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="<?= e($config['meta']['description']) ?>">
<title><?= e($pageTitle) ?></title>

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400..800&family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link href="<?= e(asset('assets/css/style.css')) ?>" rel="stylesheet">
</head>
<body>

<div id="scrollProgress"></div>