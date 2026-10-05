<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
<title>Cutouts Debug</title>
<style>
  body{font-family:monospace;background:#0A1F44;color:#D9B673;padding:32px;line-height:1.7;}
  h1{color:#fff;font-size:1.3rem;margin-bottom:20px;}
  .row{background:#071630;padding:14px 18px;border-radius:8px;margin-bottom:10px;}
  .ok{color:#4ade80;}
  .fail{color:#f87171;}
  .path{color:#7dd3fc;font-size:0.85rem;}
  img{max-width:200px;border-radius:6px;margin-top:8px;display:block;}
</style>
</head>
<body>

<h1>Cutouts Diagnostic</h1>

<?php
$dir = __DIR__ . '/assets/images/press/cutouts';
echo '<div class="row">';
echo '<strong>Folder:</strong> <span class="path">' . htmlspecialchars($dir) . '</span><br>';
echo 'Exists: ' . (is_dir($dir) ? '<span class="ok">YES ✓</span>' : '<span class="fail">NO ✗</span>') . '<br>';
echo 'Writable: ' . (is_writable($dir) ? '<span class="ok">YES ✓</span>' : '<span class="fail">NO ✗</span>');
echo '</div>';

if (is_dir($dir)) {
    $files = glob($dir . '/*.{jpg,jpeg,png,JPG,JPEG,PNG}', GLOB_BRACE);
    echo '<h1>Files Found: ' . count($files) . '</h1>';

    foreach ($files as $file) {
        $name = basename($file);
        $size = round(filesize($file) / 1024, 1);
        $rel  = 'assets/images/press/cutouts/' . $name;

        echo '<div class="row">';
        echo '<strong>' . htmlspecialchars($name) . '</strong> — ' . $size . ' KB<br>';
        echo '<span class="ok">→ ' . htmlspecialchars($rel) . '</span><br>';
        echo '<img src="' . htmlspecialchars($rel) . '?v=' . time() . '" alt="">';
        echo '</div>';
    }
}
?>

</body>
</html>