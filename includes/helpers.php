<?php
declare(strict_types=1);

/**
 * HTML-escape a string for safe output.
 */
function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Render a Font Awesome icon.
 */
function icon(string $style, string $name, string $extra = ''): string
{
    $classes = trim($style . ' ' . $name . ($extra !== '' ? ' ' . $extra : ''));
    return '<i class="' . e($classes) . '" aria-hidden="true"></i>';
}

/**
 * Return a URL for a press thumbnail.
 */
function press_thumb(string $filename, string $label, string $theme = 'navy'): string
{
    $relative = 'assets/images/' . ltrim($filename, '/');
    $full     = __DIR__ . '/../' . $relative;
    if (is_file($full)) {
        return $relative;
    }
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

    $words    = preg_split('/\s+/', trim($label)) ?: [];
    $initials = '';
    foreach (array_slice($words, 0, 2) as $w) {
        $initials .= mb_strtoupper(mb_substr($w, 0, 1));
    }
    if ($initials === '') $initials = 'NW';

    $displayLabel = mb_strlen($label) > 32 ? mb_substr($label, 0, 30) . '…' : $label;

    $safeLabel    = htmlspecialchars($displayLabel, ENT_QUOTES, 'UTF-8');
    $safeInitials = htmlspecialchars($initials, ENT_QUOTES, 'UTF-8');

    $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 600" preserveAspectRatio="xMidYMid slice">
  <defs>
    <linearGradient id="g" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0%" stop-color="{$c1}"/>
      <stop offset="100%" stop-color="{$c2}"/>
    </linearGradient>
  </defs>
  <rect width="800" height="600" fill="url(#g)"/>
  <text x="400" y="330" text-anchor="middle" font-family="sans-serif" font-weight="800" font-size="200" fill="rgba(255,255,255,0.22)">{$safeInitials}</text>
  <text x="400" y="520" text-anchor="middle" font-family="sans-serif" font-weight="700" font-size="22" fill="rgba(255,255,255,0.85)">{$safeLabel}</text>
</svg>
SVG;

    return 'data:image/svg+xml;base64,' . base64_encode($svg);
}

/**
 * Fetch a LinkedIn post's OG image URL using Microlink.io.
 * Result cached for 30 days.
 */
function li_post_image(string $url, int $cacheDays = 30): string
{
    if ($url === '') return '';

    /* Cache setup */
    $cacheDir = __DIR__ . '/assets/images/social/cache';
    if (!is_dir($cacheDir)) {
        @mkdir($cacheDir, 0755, true);
    }
    $cacheFile = $cacheDir . '/' . md5($url) . '.txt';

    /* Return cached if fresh */
    if (is_file($cacheFile) && (time() - filemtime($cacheFile)) < $cacheDays * 86400) {
        $cached = trim((string) file_get_contents($cacheFile));
        if ($cached !== '') return $cached;
    }

    /* HTTP context */
    $ctx = stream_context_create([
        'http' => [
            'timeout'         => 12,
            'user_agent'      => 'Mozilla/5.0 (compatible; PortfolioBot/1.0)',
            'follow_location' => true,
            'ignore_errors'   => true,
        ],
        'ssl' => [
            'verify_peer'      => false,
            'verify_peer_name' => false,
        ],
    ]);

    $img = '';

    /* Try Microlink.io first */
    $api  = 'https://api.microlink.io/?url=' . urlencode($url) . '&meta=true';
    $resp = @file_get_contents($api, false, $ctx);
    if ($resp) {
        $data = json_decode($resp, true);
        $img = $data['data']['image']['url']
            ?? $data['data']['logo']['url']
            ?? $data['data']['screenshot']['url']
            ?? '';
    }

    /* Fallback: scrape LinkedIn directly */
    if (!$img) {
        $html = @file_get_contents($url, false, $ctx);
        if ($html && preg_match(
            '/<meta[^>]+(?:property|name)=["\']og:image(?::secure_url)?["\'][^>]+content=["\']([^"\']+)["\']/i',
            $html, $m
        )) {
            $img = html_entity_decode($m[1], ENT_QUOTES, 'UTF-8');
        }
    }

    if ($img) {
        @file_put_contents($cacheFile, $img);
        return $img;
    }

    return '';
}