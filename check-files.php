<?php
header('Content-Type: text/plain; charset=utf-8');

echo "=== FILE SYSTEM CHECK ===\n\n";

$dir = __DIR__ . '/assets/images/press/cutouts';
echo "Looking in folder:\n  $dir\n\n";

echo "Folder exists?      " . (is_dir($dir) ? "YES" : "NO") . "\n";
echo "Folder readable?    " . (is_readable($dir) ? "YES" : "NO") . "\n\n";

if (is_dir($dir)) {
    echo "Contents of the folder:\n";
    $files = scandir($dir);
    $count = 0;
    foreach ($files as $f) {
        if ($f === '.' || $f === '..') continue;
        $full = $dir . '/' . $f;
        $size = is_file($full) ? filesize($full) . ' bytes' : 'DIRECTORY';
        echo "  - $f  ($size)\n";
        $count++;
    }
    echo "\nTotal items: $count\n\n";

    // Test specific files
    echo "=== TESTING EXPECTED FILES ===\n\n";
    for ($i = 1; $i <= 7; $i++) {
        $name = "cutout-$i.jpg";
        $full = $dir . '/' . $name;
        $exists = file_exists($full);
        $size = $exists ? filesize($full) : 0;
        echo "$name: " . ($exists ? "✓ EXISTS ($size bytes)" : "✗ MISSING") . "\n";
    }
}

echo "\n=== WEB URL TEST ===\n\n";
echo "Try opening these URLs in your browser:\n\n";
for ($i = 1; $i <= 7; $i++) {
    echo "http://localhost:8080/portfolio/assets/images/press/cutouts/cutout-$i.jpg\n";
}