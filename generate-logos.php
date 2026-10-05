<?php
/* ============================================================
   generate-logos.php — creates SVG partner logos
   Open: http://localhost:8080/portfolio/generate-logos.php
   Delete after running.
   ============================================================ */

header('Content-Type: text/html; charset=utf-8');

$dir = __DIR__ . '/assets/images/partners';
if (!is_dir($dir)) @mkdir($dir, 0755, true);

/* ============================================================
   SVG LOGO DEFINITIONS
   Each is a self-contained vector logo with brand colors
   ============================================================ */

$logos = [

    /* ---------- STRATEGIC ---------- */
    'un.svg' => <<<'SVG'
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 200">
  <circle cx="100" cy="100" r="70" fill="none" stroke="#009EDB" stroke-width="3"/>
  <ellipse cx="100" cy="100" rx="70" ry="28" fill="none" stroke="#009EDB" stroke-width="2"/>
  <ellipse cx="100" cy="100" rx="28" ry="70" fill="none" stroke="#009EDB" stroke-width="2"/>
  <line x1="30" y1="100" x2="170" y2="100" stroke="#009EDB" stroke-width="2"/>
  <circle cx="100" cy="30" r="4" fill="#009EDB"/>
  <circle cx="100" cy="170" r="4" fill="#009EDB"/>
  <circle cx="30" cy="100" r="4" fill="#009EDB"/>
  <circle cx="170" cy="100" r="4" fill="#009EDB"/>
  <text x="200" y="90" font-family="Arial, sans-serif" font-size="26" font-weight="700" fill="#009EDB">UNITED</text>
  <text x="200" y="120" font-family="Arial, sans-serif" font-size="26" font-weight="700" fill="#009EDB">NATIONS</text>
</svg>
SVG,

    'unhrc.svg' => <<<'SVG'
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 200">
  <circle cx="80" cy="100" r="55" fill="#1E5FAA"/>
  <path d="M 80 55 A 45 45 0 0 1 80 145 A 45 45 0 0 1 80 55 Z" fill="#fff" opacity="0.15"/>
  <circle cx="80" cy="100" r="35" fill="none" stroke="#fff" stroke-width="2"/>
  <path d="M 60 100 L 75 115 L 100 85" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round"/>
  <text x="155" y="85" font-family="Arial, sans-serif" font-size="22" font-weight="700" fill="#1E5FAA">UN HUMAN</text>
  <text x="155" y="112" font-family="Arial, sans-serif" font-size="22" font-weight="700" fill="#1E5FAA">RIGHTS</text>
  <text x="155" y="135" font-family="Arial, sans-serif" font-size="14" fill="#6B7280">OHCHR</text>
</svg>
SVG,

    'ecosoc.svg' => <<<'SVG'
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 200">
  <rect x="30" y="50" width="100" height="100" rx="10" fill="#009EDB"/>
  <rect x="45" y="65" width="30" height="70" fill="#fff"/>
  <rect x="80" y="85" width="30" height="50" fill="#fff"/>
  <rect x="45" y="65" width="65" height="12" fill="#FFD700"/>
  <text x="155" y="95" font-family="Arial, sans-serif" font-size="28" font-weight="800" fill="#009EDB">ECOSOC</text>
  <text x="155" y="120" font-family="Arial, sans-serif" font-size="12" fill="#6B7280">Economic and Social Council</text>
</svg>
SVG,

    'obama.svg' => <<<'SVG'
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 200">
  <circle cx="80" cy="100" r="55" fill="#0F1E36"/>
  <path d="M 55 110 Q 80 55 105 110 Q 80 90 55 110 Z" fill="#FF6B35"/>
  <path d="M 50 115 Q 80 75 110 115" fill="none" stroke="#fff" stroke-width="2"/>
  <circle cx="80" cy="95" r="6" fill="#fff"/>
  <text x="155" y="90" font-family="Georgia, serif" font-size="26" font-weight="700" fill="#0F1E36">Obama</text>
  <text x="155" y="115" font-family="Georgia, serif" font-size="26" font-weight="400" fill="#0F1E36">Foundation</text>
  <text x="155" y="135" font-family="Arial, sans-serif" font-size="11" fill="#6B7280" letter-spacing="2">LEADERS · ASIA</text>
</svg>
SVG,

    'unwebtv.svg' => <<<'SVG'
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 200">
  <rect x="30" y="55" width="100" height="75" rx="8" fill="#009EDB"/>
  <polygon points="70,80 70,110 95,95" fill="#fff"/>
  <rect x="55" y="135" width="50" height="6" rx="3" fill="#009EDB"/>
  <text x="155" y="95" font-family="Arial, sans-serif" font-size="26" font-weight="800" fill="#009EDB">UN</text>
  <text x="200" y="95" font-family="Arial, sans-serif" font-size="26" font-weight="300" fill="#0A1F44">WEB</text>
  <text x="270" y="95" font-family="Arial, sans-serif" font-size="26" font-weight="800" fill="#009EDB">TV</text>
  <text x="155" y="118" font-family="Arial, sans-serif" font-size="11" fill="#6B7280" letter-spacing="3">LIVE &amp; ON DEMAND</text>
</svg>
SVG,

    /* ---------- INSTITUTIONAL ---------- */
    'sambhali.svg' => <<<'SVG'
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 200">
  <circle cx="80" cy="100" r="55" fill="#B91C5C"/>
  <path d="M 55 90 Q 80 60 105 90 L 105 120 Q 80 135 55 120 Z" fill="#FFD700"/>
  <circle cx="80" cy="85" r="10" fill="#fff"/>
  <path d="M 70 125 Q 80 110 90 125 Q 85 135 75 135 Z" fill="#fff"/>
  <text x="155" y="90" font-family="Georgia, serif" font-size="24" font-weight="700" fill="#B91C5C">Sambhali</text>
  <text x="155" y="116" font-family="Georgia, serif" font-size="24" font-weight="400" fill="#0A1F44">Trust</text>
  <text x="155" y="135" font-family="Arial, sans-serif" font-size="10" fill="#6B7280" letter-spacing="2">JODHPUR · RAJASTHAN</text>
</svg>
SVG,

    'rsks.svg' => <<<'SVG'
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 200">
  <circle cx="80" cy="100" r="55" fill="#166534"/>
  <path d="M 80 55 L 90 85 L 120 85 L 95 105 L 105 135 L 80 115 L 55 135 L 65 105 L 40 85 L 70 85 Z" fill="#FCD34D"/>
  <text x="155" y="90" font-family="Arial, sans-serif" font-size="28" font-weight="800" fill="#166534">RSKS</text>
  <text x="155" y="115" font-family="Arial, sans-serif" font-size="14" fill="#0A1F44">INDIA</text>
  <text x="155" y="135" font-family="Arial, sans-serif" font-size="10" fill="#6B7280">Rajasthan Samgrah Kalyan Sansthan</text>
</svg>
SVG,

    'goa.svg' => <<<'SVG'
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 200">
  <circle cx="80" cy="100" r="55" fill="#7C3AED"/>
  <path d="M 80 55 Q 100 75 100 100 Q 100 130 80 145 Q 60 130 60 100 Q 60 75 80 55 Z" fill="#FBBF24"/>
  <circle cx="80" cy="90" r="8" fill="#7C3AED"/>
  <path d="M 70 105 Q 80 115 90 105" fill="none" stroke="#7C3AED" stroke-width="2"/>
  <text x="155" y="80" font-family="Arial, sans-serif" font-size="18" font-weight="800" fill="#7C3AED">GIRLS</text>
  <text x="155" y="102" font-family="Arial, sans-serif" font-size="18" font-weight="800" fill="#7C3AED">OPPORTUNITY</text>
  <text x="155" y="124" font-family="Arial, sans-serif" font-size="18" font-weight="800" fill="#7C3AED">ALLIANCE</text>
</svg>
SVG,

    'choyal.svg' => <<<'SVG'
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 200">
  <rect x="30" y="55" width="100" height="90" rx="12" fill="#C2410C"/>
  <circle cx="80" cy="100" r="28" fill="none" stroke="#fff" stroke-width="3"/>
  <circle cx="80" cy="100" r="12" fill="#fff"/>
  <path d="M 80 68 L 80 55" stroke="#fff" stroke-width="3"/>
  <path d="M 80 132 L 80 145" stroke="#fff" stroke-width="3"/>
  <path d="M 48 100 L 35 100" stroke="#fff" stroke-width="3"/>
  <path d="M 112 100 L 125 100" stroke="#fff" stroke-width="3"/>
  <text x="155" y="95" font-family="Arial, sans-serif" font-size="28" font-weight="800" fill="#C2410C">Choyal</text>
  <text x="155" y="120" font-family="Arial, sans-serif" font-size="12" fill="#0A1F44">Innovative Grinding Solutions</text>
</svg>
SVG,

    'twc.svg' => <<<'SVG'
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 200">
  <circle cx="80" cy="100" r="55" fill="#0369A1"/>
  <path d="M 55 100 Q 80 65 105 100 Q 105 130 80 140 Q 55 130 55 100 Z" fill="#fff" opacity="0.3"/>
  <path d="M 60 100 Q 80 80 100 100" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round"/>
  <path d="M 60 115 Q 80 95 100 115" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round"/>
  <text x="155" y="90" font-family="Arial, sans-serif" font-size="22" font-weight="800" fill="#0369A1">TOGETHER</text>
  <text x="155" y="118" font-family="Arial, sans-serif" font-size="22" font-weight="800" fill="#0A1F44">WE CAN</text>
  <text x="155" y="140" font-family="Arial, sans-serif" font-size="10" fill="#6B7280" letter-spacing="2">COVID-19 CAMPAIGN</text>
</svg>
SVG,

    'pathshala.svg' => <<<'SVG'
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 200">
  <rect x="30" y="60" width="100" height="80" rx="8" fill="#7C2D12"/>
  <polygon points="80,60 130,60 80,90 30,90" fill="#B45309"/>
  <rect x="45" y="100" width="20" height="40" fill="#fff"/>
  <rect x="72" y="100" width="20" height="40" fill="#fff"/>
  <rect x="99" y="100" width="20" height="40" fill="#fff"/>
  <text x="155" y="95" font-family="Georgia, serif" font-size="26" font-weight="700" fill="#7C2D12">Pathshala</text>
  <text x="155" y="118" font-family="Arial, sans-serif" font-size="11" fill="#6B7280" letter-spacing="2">SCHOOL PROJECT</text>
  <text x="155" y="138" font-family="Arial, sans-serif" font-size="10" fill="#6B7280">Rajasthan, India</text>
</svg>
SVG,

    /* ---------- MEDIA ---------- */
    'theprint.svg' => <<<'SVG'
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 200">
  <rect x="30" y="65" width="100" height="70" rx="4" fill="#DC2626"/>
  <text x="40" y="115" font-family="Georgia, serif" font-size="36" font-weight="800" fill="#fff">TP</text>
  <text x="155" y="95" font-family="Georgia, serif" font-size="26" font-weight="800" fill="#0A1F44">ThePrint</text>
  <text x="155" y="120" font-family="Arial, sans-serif" font-size="11" fill="#6B7280" letter-spacing="2">INDIAN NEWS PORTAL</text>
</svg>
SVG,

    'ani.svg' => <<<'SVG'
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 200">
  <circle cx="80" cy="100" r="50" fill="#DC2626"/>
  <path d="M 60 85 L 90 100 L 60 115 Z" fill="#fff"/>
  <circle cx="95" cy="100" r="6" fill="#fff"/>
  <text x="155" y="95" font-family="Arial, sans-serif" font-size="34" font-weight="900" fill="#DC2626">ANI</text>
  <text x="155" y="120" font-family="Arial, sans-serif" font-size="10" fill="#6B7280" letter-spacing="2">ASIAN NEWS INTERNATIONAL</text>
</svg>
SVG,

    'toi.svg' => <<<'SVG'
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 200">
  <path d="M 30 100 L 60 60 L 90 100 L 60 140 Z" fill="#0F1E36"/>
  <text x="45" y="110" font-family="Georgia, serif" font-size="24" font-weight="800" fill="#fff">T</text>
  <text x="105" y="95" font-family="Georgia, serif" font-size="20" font-weight="800" fill="#0F1E36">THE TIMES</text>
  <text x="105" y="118" font-family="Georgia, serif" font-size="20" font-weight="400" fill="#0F1E36">OF INDIA</text>
  <text x="105" y="138" font-family="Arial, sans-serif" font-size="10" fill="#6B7280" letter-spacing="2">INDIA'S #1 NEWSPAPER</text>
</svg>
SVG,

    'lcn.svg' => <<<'SVG'
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 200">
  <circle cx="80" cy="100" r="50" fill="#1E3A8A"/>
  <circle cx="80" cy="100" r="30" fill="none" stroke="#FBBF24" stroke-width="3"/>
  <circle cx="80" cy="100" r="15" fill="#FBBF24"/>
  <text x="155" y="85" font-family="Arial, sans-serif" font-size="18" font-weight="800" fill="#1E3A8A">LONDON</text>
  <text x="155" y="108" font-family="Arial, sans-serif" font-size="18" font-weight="400" fill="#0A1F44">CHANNEL</text>
  <text x="155" y="130" font-family="Arial, sans-serif" font-size="18" font-weight="800" fill="#1E3A8A">NEWS</text>
</svg>
SVG,

    'bhaskar.svg' => <<<'SVG'
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 200">
  <rect x="30" y="60" width="100" height="80" rx="6" fill="#DC2626"/>
  <text x="40" y="112" font-family="Arial, sans-serif" font-size="42" font-weight="900" fill="#fff">भा</text>
  <text x="155" y="90" font-family="Georgia, serif" font-size="22" font-weight="800" fill="#DC2626">Dainik</text>
  <text x="155" y="116" font-family="Georgia, serif" font-size="22" font-weight="400" fill="#0A1F44">Bhaskar</text>
  <text x="155" y="136" font-family="Arial, sans-serif" font-size="10" fill="#6B7280" letter-spacing="2">HINDI DAILY</text>
</svg>
SVG,
];
?>
<!DOCTYPE html>
<html>
<head>
<title>Logo Generator</title>
<style>
  body{font-family:monospace;background:#0A1F44;color:#D9B673;padding:32px;line-height:1.7;}
  h1{color:#fff;font-size:1.6rem;}
  h2{color:#D9B673;font-size:1.1rem;margin:28px 0 12px;border-bottom:1px solid #1B3060;padding-bottom:6px;}
  .ok{color:#4ade80;}
  .info{color:#93c5fd;}
  .grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:16px;margin:16px 0 32px;}
  .card{background:#fff;border-radius:10px;padding:14px;text-align:center;}
  .card svg{max-width:100%;height:80px;}
  .card .name{color:#0A1F44;font-size:11px;margin-top:8px;font-family:Arial,sans-serif;}
  .row{margin:4px 0;}
  .path{color:#7dd3fc;font-size:0.85rem;}
  .done{background:#071630;padding:16px 20px;border-left:4px solid #4ade80;margin-top:24px;border-radius:6px;color:#4ade80;}
</style>
</head>
<body>

<h1>Partner Logo Generator</h1>
<p class="path">Target folder: <?= htmlspecialchars($dir) ?></p>

<?php
$written = 0;
$failed  = [];

foreach ($logos as $filename => $svg) {
    $path = $dir . '/' . $filename;
    if (@file_put_contents($path, $svg) !== false) {
        $written++;
    } else {
        $failed[] = $filename;
    }
}
?>

<h2>Result</h2>
<div class="row ok">✅ Created <?= $written ?> SVG files</div>
<?php if ($failed): ?>
  <div class="row" style="color:#f87171;">❌ Failed: <?= implode(', ', $failed) ?></div>
<?php endif; ?>

<h2>Preview</h2>
<div class="grid">
  <?php foreach ($logos as $filename => $svg): ?>
    <div class="card">
      <?= $svg ?>
      <div class="name"><?= htmlspecialchars($filename) ?></div>
    </div>
  <?php endforeach; ?>
</div>

<div class="done">
  <strong>✅ All logos generated!</strong><br>
  Files are now at: <code>assets/images/partners/</code><br>
  Delete this script (<code>generate-logos.php</code>) and refresh your portfolio.
</div>

</body>
</html>