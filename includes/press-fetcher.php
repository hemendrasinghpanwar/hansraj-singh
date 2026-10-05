<?php
declare(strict_types=1);

/* ============================================================
   press-fetcher.php
   Live fetcher for news article thumbnails.
   Downloads the OG image of each article and caches it locally.
   ============================================================ */

/**
 * Fetch raw HTML with browser-like cURL headers.
 */
function pf_fetch_html(string $url): string
{
    if (!function_exists('curl_init')) return '';

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_MAXREDIRS      => 8,
        CURLOPT_TIMEOUT        => 20,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_ENCODING       => '',
        CURLOPT_HTTPHEADER     => [
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Language: en-US,en;q=0.9',
            'Upgrade-Insecure-Requests: 1',
        ],
    ]);

    $html = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return ($code < 400 && $html) ? (string) $html : '';
}


/**
 * Extract the OG image URL from an article page.
 * Caches the URL for 30 days.
 */
function pf_og_url(string $articleUrl, int $cacheDays = 30): string
{
    if ($articleUrl === '') return '';

    $cacheDir = __DIR__ . '/../assets/cache/press';
    if (!is_dir($cacheDir)) @mkdir($cacheDir, 0755, true);

    $cacheFile = $cacheDir . '/' . md5($articleUrl) . '.url.txt';

    if (is_file($cacheFile) && (time() - filemtime($cacheFile)) < $cacheDays * 86400) {
        $cached = trim((string) file_get_contents($cacheFile));
        if ($cached === 'FAILED') return '';
        if ($cached !== '') return $cached;
    }

    $html = pf_fetch_html($articleUrl);
    if (!$html) {
        @file_put_contents($cacheFile, 'FAILED');
        return '';
    }

    $img = '';

    /* og:image */
    if (preg_match(
        '/<meta[^>]+(?:property|name)=["\']og:image(?::secure_url|:url)?["\'][^>]+content=["\']([^"\']+)["\']/i',
        $html, $m
    )) {
        $img = html_entity_decode($m[1], ENT_QUOTES, 'UTF-8');
    }
    /* twitter:image */
    elseif (preg_match(
        '/<meta[^>]+(?:name|property)=["\']twitter:image(?::src)?["\'][^>]+content=["\']([^"\']+)["\']/i',
        $html, $m
    )) {
        $img = html_entity_decode($m[1], ENT_QUOTES, 'UTF-8');
    }
    /* First big content image as last resort */
    elseif (preg_match_all('/<img[^>]+src=["\']([^"\']+\.(?:jpg|jpeg|png|webp))["\']/i', $html, $m)) {
        foreach ($m[1] as $candidate) {
            if (strlen($candidate) > 40
                && !str_contains($candidate, 'logo')
                && !str_contains($candidate, 'icon')
                && !str_contains($candidate, 'avatar')) {
                $img = $candidate;
                break;
            }
        }
    }

    /* Make relative URLs absolute */
    if ($img !== '') {
        if (str_starts_with($img, '//')) {
            $img = 'https:' . $img;
        } elseif (str_starts_with($img, '/')) {
            $parts = parse_url($articleUrl);
            $img = ($parts['scheme'] ?? 'https') . '://' . ($parts['host'] ?? '') . $img;
        }

        @file_put_contents($cacheFile, $img);
        return $img;
    }

    @file_put_contents($cacheFile, 'FAILED');
    return '';
}


/**
 * Download a remote image with browser headers + referer.
 * Returns local path (relative to project root) or ''.
 */
function pf_download(string $remoteUrl, string $slug): string
{
    if ($remoteUrl === '' || $slug === '') return '';

    $dir = __DIR__ . '/../assets/images/press';
    if (!is_dir($dir)) @mkdir($dir, 0755, true);

    $path = parse_url($remoteUrl, PHP_URL_PATH) ?? '';
    $ext  = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) $ext = 'jpg';

    $localFile = $dir . '/' . $slug . '.' . $ext;
    $localRel  = 'assets/images/press/' . $slug . '.' . $ext;

    /* Fresh cache? */
    if (is_file($localFile) && filesize($localFile) > 5000
        && (time() - filemtime($localFile)) < 30 * 86400) {
        return $localRel;
    }

    if (!function_exists('curl_init')) return '';

    $referer = '';
    if (preg_match('#^(https?://[^/]+)/#', $remoteUrl, $m)) {
        $referer = $m[1] . '/';
    }

    $ch = curl_init($remoteUrl);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_MAXREDIRS      => 8,
        CURLOPT_TIMEOUT        => 25,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_ENCODING       => '',
        CURLOPT_HTTPHEADER     => array_filter([
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            'Accept: image/avif,image/webp,image/apng,image/*,*/*;q=0.8',
            'Accept-Language: en-US,en;q=0.9',
            $referer ? 'Referer: ' . $referer : null,
        ]),
    ]);

    $data = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($code < 400 && $data !== false && strlen($data) > 5000) {
        if (@file_put_contents($localFile, $data) !== false) {
            return $localRel;
        }
    }

    if (is_file($localFile) && filesize($localFile) > 5000) {
        return $localRel;
    }

    return '';
}


/**
 * Master resolver — the one function your templates should call.
 *
 * Priority:
 *   1. Local cached image
 *   2. Fetch OG image from the article, download it
 *   3. Proxy through images.weserv.nl (bypasses hotlink blocks)
 *   4. Config fallback URL
 *
 * @param array  $item  ['url' => ..., 'img' => ...]
 * @param string $slug  Unique slug (e.g. "press-lead")
 * @return string       Local path, proxy URL, or config URL
 */
function press_article_image(array $item, string $slug): string
{
    /* 1. Existing local? */
    foreach (['jpg', 'jpeg', 'png', 'webp', 'gif'] as $ext) {
        $path = __DIR__ . '/../assets/images/press/' . $slug . '.' . $ext;
        if (is_file($path) && filesize($path) > 5000) {
            return 'assets/images/press/' . $slug . '.' . $ext;
        }
    }

    /* 2. Fetch OG + download */
    $articleUrl = $item['url'] ?? '';
    if ($articleUrl !== '') {
        $og = pf_og_url($articleUrl);

        if ($og !== '') {
            $local = pf_download($og, $slug);
            if ($local !== '') return $local;

            /* 3. Proxy fallback */
            return 'https://images.weserv.nl/?url=' . urlencode($og) . '&w=1200&h=800&fit=cover&q=80';
        }
    }

    /* 4. Config fallback */
    return $item['img'] ?? '';
}