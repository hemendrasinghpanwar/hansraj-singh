<?php
declare(strict_types=1);

/**
 * Return a URL for a press thumbnail.
 *  - If a real file exists under /assets/images/, use it.
 *  - Otherwise, generate a branded SVG data-URI with outlet initials.
 *
 * @param string $filename   e.g. 'press-lead.jpg'
 * @param string $label      e.g. 'ThePrint' or short code like 'ANI'
 * @param string $theme      'navy' | 'gold' | 'blue' | 'deep'
 */
function press_thumb(string $filename, string $label, string $theme = 'navy'): string
{
    // 1. Real file wins — check under assets/images/
    $relative = 'assets/images/' . ltrim($filename, '/');
    $full     = __DIR__ . '/../' . $relative;
    if (is_file($full)) {
        return $relative;
    }

    // 2. Fall back to a generated SVG placeholder
    return press_placeholder_svg($label, $theme);
}

/**
 * Build a branded SVG placeholder as a base64 data-URI.
 */
function press_placeholder_svg(string $label, string $theme = 'navy'): string
{
    $palettes = [
        'navy' => ['#0A1F44', '#0072BC'],
        'gold' => ['#B8862F', '#D9B673'],
        'blue' => ['#0072BC', '#4FA8DE'],
        'deep' => ['#071630', '#0A1F44'],
    ];
    [$c1, $c2] = $palettes[$theme] ?? $palettes['navy'];

    // Initials: first letters of up to 2 words
    $words    = preg_split('/\s+/', trim($label)) ?: [];
    $initials = '';
    foreach (array_slice($words, 0, 2) as $w) {
        $initials .= mb_strtoupper(mb_substr($w, 0, 1));
    }
    if ($initials === '') {
        $initials = 'NW';
    }

    // Cap long labels so they don't overflow the SVG
    $displayLabel = mb_strlen($label) > 32
        ? mb_substr($label, 0, 30) . '…'
        : $label;

    $safeLabel    = htmlspecialchars($displayLabel, ENT_QUOTES, 'UTF-8');
    $safeInitials = htmlspecialchars($initials, ENT_QUOTES, 'UTF-8');

    $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 600" preserveAspectRatio="xMidYMid slice">
  <defs>
    <linearGradient id="g" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0%" stop-color="{$c1}"/>
      <stop offset="100%" stop-color="{$c2}"/>
    </linearGradient>
    <pattern id="dots" width="32" height="32" patternUnits="userSpaceOnUse">
      <circle cx="2" cy="2" r="1.6" fill="rgba(255,255,255,0.10)"/>
    </pattern>
  </defs>
  <rect width="800" height="600" fill="url(#g)"/>
  <rect width="800" height="600" fill="url(#dots)"/>
  <g fill="none" stroke="rgba(255,255,255,0.12)" stroke-width="1">
    <circle cx="400" cy="300" r="180"/>
    <circle cx="400" cy="300" r="240"/>
  </g>
  <text x="400" y="330"
        text-anchor="middle"
        font-family="Bricolage Grotesque, Manrope, sans-serif"
        font-weight="800"
        font-size="200"
        fill="rgba(255,255,255,0.22)"
        letter-spacing="-4">{$safeInitials}</text>
  <text x="400" y="520"
        text-anchor="middle"
        font-family="Manrope, sans-serif"
        font-weight="700"
        font-size="22"
        letter-spacing="4"
        fill="rgba(255,255,255,0.85)">{$safeLabel}</text>
</svg>
SVG;

    return 'data:image/svg+xml;base64,' . base64_encode($svg);
}