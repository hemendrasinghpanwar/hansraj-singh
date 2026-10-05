<?php
/* ============================================================
   warm-press.php — downloads all press images at once
   Run once: http://localhost:8080/portfolio/warm-press.php
   Delete after running.
   ============================================================ */

require_once __DIR__ . '/includes/functions.php';
$config = require __DIR__ . '/includes/config.php';

header('Content-Type: text/html; charset=utf-8');

$press = $config['press'] ?? null;
if (!$press) exit('<p>No press config found.</p>');

$articles = [];
$articles[] = ['press-lead', $press['lead']];
foreach ($press['cards'] as $i => $c) {
    $articles[] = ['press-card-' . ($i + 2), $c];
}
foreach ($press['wire'] as $i => $w) {
    $articles[] = ['press-wire-' . ($i + 6), $w];
}

$ok = 0; $fail = 0;
$start = microtime(true);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Press Image Warmer</title>
<style>
  body{font-family:ui-monospace,monospace;background:#0A1F44;color:#D9B673;padding:32px;line-height:1.7;}
  h1{color:#fff;font-size:1.4rem;margin-bottom:20px;}
  .row{margin:8px 0;padding:14px 18px;background:#071630;border-radius:8px;display:flex;align-items:center;gap:18px;}
  .ok{color:#4ade80;}
  .warn{color:#fbbf24;}
  .fail{color:#f87171;}
  .slug{color:#7dd3fc;font-weight:700;min-width:200px;}
  .thumb{width:100px;height:66px;object-fit:cover;border-radius:6px;border:1px solid #1B3060;flex-shrink:0;}
  .done{margin-top:32px;padding:20px;background:#071630;border-left:4px solid #4ade80;border-radius:8px;color:#4ade80;}
  small{color:#93c5fd;font-size:0.72rem;word-break:break-all;display:block;margin-top:2px;}
  a{color:#7dd3fc;}
</style>
</head>
<body>

<h1>📥 Downloading Real News Thumbnails</h1>

<?php foreach ($articles as [$slug, $item]):
    $result = press_article_image($item, $slug);
    $isLocal  = str_starts_with($result, 'assets/');
    $isProxy  = str_starts_with($result, 'https://images.weserv.nl');
    $isRemote = preg_match('#^https?://#i', $result);

    echo '<div class="row">';
    echo '<span class="slug">' . htmlspecialchars($slug) . '</span>';

    if ($isLocal) {
        echo '<span class="ok">✓</span>';
        echo '<img class="thumb" src="' . htmlspecialchars($result) . '?v=' . time() . '" alt="">';
        echo '<small>' . htmlspecialchars($result) . '</small>';
        $ok++;
    } elseif ($isProxy) {
        echo '<span class="warn">↻ proxied</span>';
        echo '<img class="thumb" src="' . htmlspecialchars($result) . '" alt="">';
        echo '<small>' . htmlspecialchars(substr($result, 0, 100)) . '…</small>';
        $ok++;
    } elseif ($isRemote) {
        echo '<span class="warn">→ remote</span>';
        echo '<img class="thumb" src="' . htmlspecialchars($result) . '" alt="">';
        echo '<small>' . htmlspecialchars(substr($result, 0, 100)) . '…</small>';
        $ok++;
    } else {
        echo '<span class="fail">✗ failed — no image found</span>';
        $fail++;
    }

    echo '</div>';
endforeach; ?>

<?php $elapsed = round(microtime(true) - $start, 1); ?>

<div class="done">
  <strong>✅ Done in <?= $elapsed ?>s</strong><br>
  Success: <?= $ok ?><br>
  Failed: <?= $fail ?><br><br>
  Now <strong>delete warm-press.php</strong> and refresh your site.
</div>

</body>
</html>