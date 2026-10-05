<?php
declare(strict_types=1);

/* ============================================================
   functions.php — Shared helper functions
   Loaded once by init.php on every page.
   ============================================================ */

/* ---------- Load press image helpers ----------
   press-image.php must define:
     • press_thumb($filename, $label, $theme)
     • press_placeholder_svg($label, $theme)
*/
$pressHelper = __DIR__ . '/press-image.php';
if (is_file($pressHelper)) {
    require_once $pressHelper;
} else {
    /* Soft fallback — define stubs so the site doesn't crash */
    if (!function_exists('press_thumb')) {
        function press_thumb(string $filename, string $label = '', string $theme = 'navy'): string {
            if (preg_match('#^https?://#i', $filename)) return $filename;
            return 'assets/images/' . ltrim($filename, '/');
        }
    }
    if (!function_exists('press_placeholder_svg')) {
        function press_placeholder_svg(string $label, string $theme = 'navy'): string {
            return 'data:image/svg+xml;base64,' . base64_encode(
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><rect width="100" height="100" fill="#0A1F44"/></svg>'
            );
        }
    }
}


/* ============================================================
   OUTPUT HELPERS
   ============================================================ */

/**
 * Escape HTML output safely. Accepts null, int, string, etc.
 * Usage: <h1><?= e($name) ?></h1>
 */
function e($value): string
{
    if ($value === null) return '';
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Return a config value by dot-path.
 * Usage: cfg('profile.email')
 *        cfg('profile.phone', 'N/A')
 */
function cfg(string $path, $default = null)
{
    static $config = null;
    if ($config === null) {
        $config = require __DIR__ . '/config.php';
    }

    $parts = explode('.', $path);
    $val   = $config;

    foreach ($parts as $p) {
        if (!is_array($val) || !array_key_exists($p, $val)) {
            return $default;
        }
        $val = $val[$p];
    }
    return $val;
}


/* ============================================================
   ICON HELPER
   ============================================================ */

/**
 * Render a Font Awesome icon.
 * Usage: icon('fa-solid', 'fa-user')
 *        icon('fa-brands', 'fa-linkedin-in', 'extra-class')
 */
function icon(string $style, string $name, string $class = ''): string
{
    $classes = trim($style . ' ' . $name . ($class !== '' ? ' ' . $class : ''));
    return '<i class="' . e($classes) . '" aria-hidden="true"></i>';
}


/* ============================================================
   ASSET URL HELPER
   ============================================================ */

/**
 * Build an asset URL, cache-busted by file modification time.
 * If the file doesn't exist, the raw path is returned so the
 * browser shows a 404 — easier to debug than a silent failure.
 */
function asset(string $path): string
{
    $path = ltrim($path, '/');
    $full = __DIR__ . '/../' . $path;

    if (!is_file($full)) {
        return $path;
    }

    return $path . '?v=' . filemtime($full);
}


/* ============================================================
   URL / LINK HELPERS
   ============================================================ */

/**
 * Build an absolute URL from a relative path.
 * Useful for og:image, canonical tags, sitemaps.
 */
function absolute_url(string $path = ''): string
{
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $base   = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? '/'), '/\\');

    return $scheme . '://' . $host . $base . '/' . ltrim($path, '/');
}

/**
 * Return true if the given page slug is the current page.
 * Usage: is_page('contact')
 */
function is_page(string $slug): bool
{
    $current = basename($_SERVER['PHP_SELF'] ?? 'index.php', '.php');
    if ($current === 'index') $current = 'home';
    return $current === $slug;
}

/**
 * Return true if the current page is any of the given slugs.
 * Usage: is_page_in(['expertise', 'experience', 'speaking'])
 */
function is_page_in(array $slugs): bool
{
    $current = basename($_SERVER['PHP_SELF'] ?? 'index.php', '.php');
    if ($current === 'index') $current = 'home';
    return in_array($current, $slugs, true);
}


/* ============================================================
   STRING / DISPLAY HELPERS
   ============================================================ */

/**
 * Shorten a string to a maximum length, adding an ellipsis.
 * Usage: excerpt('Long text goes here…', 80)
 */
function excerpt(string $text, int $limit = 160): string
{
    $text = trim(strip_tags($text));
    if (mb_strlen($text) <= $limit) return $text;
    return rtrim(mb_substr($text, 0, $limit - 1)) . '…';
}

/**
 * Format a phone number for tel: links.
 * Usage: tel_href('+91 89497 10393')  →  '+918949710393'
 */
function tel_href(string $phone): string
{
    return preg_replace('/[^0-9+]/', '', $phone);
}

/**
 * Build a mailto: link with optional subject and body.
 * Usage: mailto('hello@example.com')
 */
function mailto(string $email, string $subject = '', string $body = ''): string
{
    $url = 'mailto:' . rawurlencode($email);
    $qs  = [];
    if ($subject !== '') $qs[] = 'subject=' . rawurlencode($subject);
    if ($body !== '')    $qs[] = 'body='    . rawurlencode($body);
    if ($qs) $url .= '?' . implode('&', $qs);
    return $url;
}


/* ============================================================
   IMAGE HELPERS — press section
   ============================================================ */

/**
 * Resolve a press image path.
 *
 * Accepts:
 *   • Full URLs       →  returned as-is
 *   • Relative paths  →  prefixed with assets/images/ if needed
 *   • Bare filenames  →  prefixed with assets/images/
 *
 * Falls back to a generated SVG placeholder if the file is
 * missing and no label was provided.
 *
 * Usage:
 *   press_image('https://cdn.example.com/img.jpg', 'ThePrint')
 *   press_image('press/1.jpg', 'ThePrint')
 *   press_image('1.jpg', 'ThePrint')
 */
function press_image(string $path, string $label = 'Press', string $theme = 'navy'): string
{
    if ($path === '') {
        return function_exists('press_placeholder_svg')
            ? press_placeholder_svg($label, $theme)
            : '';
    }

    /* Full URL — return untouched */
    if (preg_match('#^https?://#i', $path)) {
        return $path;
    }

    /* Data URI — return untouched */
    if (strpos($path, 'data:') === 0) {
        return $path;
    }

    /* Path that already includes assets/ */
    if (strpos($path, 'assets/') === 0) {
        return $path;
    }

    /* Path that includes press/ or another known subfolder */
    if (strpos($path, 'press/') === 0
        || strpos($path, 'partners/') === 0
        || strpos($path, 'social/') === 0
        || strpos($path, 'banners/') === 0) {
        return 'assets/images/' . $path;
    }

    /* Bare filename — assume assets/images/press/ */
    return 'assets/images/press/' . ltrim($path, '/');
}

/**
 * Return a cache-busted version of a local image URL.
 * External URLs pass through untouched.
 */
function cache_bust_image(string $url): string
{
    if (preg_match('#^https?://#i', $url)) {
        return $url;
    }

    $full = __DIR__ . '/../' . ltrim($url, '/');
    if (is_file($full)) {
        $sep = strpos($url, '?') !== false ? '&' : '?';
        return $url . $sep . 'v=' . filemtime($full);
    }

    return $url;
}


/* ============================================================
   DATE / NUMBER HELPERS
   ============================================================ */

/**
 * Format a date in a readable way.
 * Usage: fmt_date('2024-09-18')  →  'Sep 18, 2024'
 */
function fmt_date(?string $date, string $format = 'M j, Y'): string
{
    if ($date === null || $date === '') return '';
    $ts = strtotime($date);
    return $ts ? date($format, $ts) : $date;
}

/**
 * Format a large number with thousands separators.
 * Usage: fmt_num(3500000)  →  '3,500,000'
 */
function fmt_num($n): string
{
    return number_format((float) $n);
}

/**
 * Shorten a large number for display.
 * Usage: fmt_short(3500000)  →  '3.5M'
 *        fmt_short(1200)     →  '1.2K'
 */
function fmt_short($n): string
{
    $n = (float) $n;
    if ($n >= 1_000_000) return rtrim(rtrim(number_format($n / 1_000_000, 1), '0'), '.') . 'M';
    if ($n >= 1_000)     return rtrim(rtrim(number_format($n / 1_000, 1), '0'), '.') . 'K';
    return (string) $n;
}


/* ============================================================
   SEO / META HELPERS
   ============================================================ */

/**
 * Return the current page's full canonical URL.
 */
function current_url(): string
{
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $uri    = $_SERVER['REQUEST_URI'] ?? '/';
    return $scheme . '://' . $host . $uri;
}

/**
 * Build an Open Graph meta tag.
 * Usage: og_tag('og:title', 'Hansraj Singh Rawat')
 */
function og_tag(string $property, string $content): string
{
    return '<meta property="' . e($property) . '" content="' . e($content) . '">';
}