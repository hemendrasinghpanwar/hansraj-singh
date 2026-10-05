<?php
declare(strict_types=1);

/* ============================================================
   VIDEOS — Broadcasts, interviews, news videos
   ------------------------------------------------------------
   HOW TO ADD A VIDEO
   - YouTube video : add  'youtube' => 'https://www.youtube.com/watch?v=XXXXXXXXXXX'
                     (thumbnail loads automatically, card plays in a popup)
   - News / web link: add 'url' => 'https://...'
                     (thumbnail = the page's own preview image, saved once
                      to assets/images/videos/cache/)
   - Own thumbnail : add  'thumb' => 'my-image.jpg'  (file in assets/images/videos/)
                     or a full https:// image URL
   ============================================================ */

$videos = [

    [
        'icon'   => 'fa-users',
        'kind'   => 'News',
        'outlet' => 'ANI',
        'type'   => 'News · Geneva, 63rd UNHRC',
        'date'   => 'Sep 2026',
        'title'  => 'Desert Daughters of India 2.0 at the UN Human Rights Council',
        'desc'   => 'Side event at the Palais des Nations on displaced women and girls from Rajasthan, with Hansraj Singh Rawat speaking on UN engagement.',
        'url'    => 'https://www.aninews.in/news/world/europe/sambhali-trust-highlights-plight-of-displaced-women-and-girls-from-rajasthan-at-un-human-rights-council-side-event-in-geneva20260925225341/',
        'thumb'  => 'https://d3lzcn6mbbadaf.cloudfront.net/media/details/ANI-20260925172332.jpg',
    ],

    [
        'icon'   => 'fa-landmark',
        'kind'   => 'News',
        'outlet' => 'ANI',
        'type'   => 'News · Geneva, 61st UNHRC',
        'date'   => 'Mar 2026',
        'title'  => 'Grassroots development in India highlighted at UN Human Rights Council',
        'desc'   => 'Oral statement on education, women\'s empowerment and skill development at community level.',
        'url'    => 'https://www.aninews.in/news/world/europe/geneva-grassroots-development-in-india-highlighted-at-un-human-rights-council20260324124617/',
    ],

    [
        'icon'   => 'fa-microphone',
        'kind'   => 'News',
        'outlet' => 'ANI',
        'type'   => 'News · Geneva, 61st UNHRC',
        'date'   => 'Feb 2026',
        'title'  => 'Deeper human rights integration at the 61st UNHRC session',
        'desc'   => 'Intervention at the Annual High-Level Panel Discussion on Human Rights Mainstreaming.',
        'url'    => 'https://www.aninews.in/news/world/europe/sambhali-trust-calls-for-deeper-human-rights-integration-at-61st-unhrc-session20260225141246/',
    ],

    [
        'icon'   => 'fa-video',
        'kind'   => 'Video',
        'outlet' => 'Times of India',
        'type'   => 'Video Report · UNHRC',
        'date'   => '',
        'title'  => 'Indian NGO urges UNHRC to hold Pahalgam attack sponsors accountable',
        'desc'   => 'Video report on the statement delivered at the UN Human Rights Council.',
        'url'    => 'https://timesofindia.indiatimes.com/videos/news/indian-ngo-targets-pakistan-urges-unhrc-to-hold-sponsors-of-pahalgam-terror-attack-accountable/videoshow/124001416.cms',
    ],

    [
        'icon'   => 'fa-newspaper',
        'kind'   => 'News',
        'outlet' => 'Economic Times',
        'type'   => 'News · UNHRC',
        'date'   => '',
        'title'  => 'Indian NGO urges UNHRC to hold sponsors of Pahalgam terror attack accountable',
        'desc'   => 'Coverage of the oral statement delivered by Sambhali Trust at the Human Rights Council.',
        'url'    => 'https://economictimes.indiatimes.com/news/india/indian-ngo-urges-unhrc-to-hold-sponsors-of-pahalgam-terror-attack-accountable/articleshow/123999461.cms',
    ],

    [
        'icon'   => 'fa-graduation-cap',
        'kind'   => 'News',
        'outlet' => 'ANI',
        'type'   => 'News · Geneva, UNHRC',
        'date'   => 'Sep 2024',
        'title'  => 'Rajasthan NGO calls for global focus on education for peace at UNHRC',
        'desc'   => 'Statement on education as a foundation for peace.',
        'url'    => 'https://www.aninews.in/news/world/asia/geneva-rajasthan-ngo-calls-for-global-focus-on-education-for-peace-at-unhrc20240918204547/',
    ],

    [
        'icon'   => 'fa-venus',
        'kind'   => 'News',
        'outlet' => 'ANI',
        'type'   => 'News · Geneva, UNHRC',
        'date'   => 'Mar 2023',
        'title'  => 'Indian NGO gives message of women empowerment at UNHRC',
        'desc'   => 'Statement on women\'s empowerment delivered in Geneva.',
        'url'    => 'https://www.aninews.in/news/world/europe/indian-ngo-gives-message-of-women-empowerment-at-unhrc20230325023530/',
    ],

    [
        'icon'   => 'fa-newspaper',
        'kind'   => 'News',
        'outlet' => 'Indian Narrative',
        'type'   => 'News · New Delhi',
        'date'   => '',
        'title'  => 'From margins to the UN: Sambhali Trust demands real human rights action',
        'desc'   => 'Feature on the organisation\'s statements at the United Nations.',
        'url'    => 'https://www.indianarrative.com/news/from-margins-to-the-un-sambhali-trust-demands-real-human-rights-action/',
    ],

    /* ---- add your YouTube videos here, for example: ----
    [
        'icon'    => 'fa-landmark',
        'kind'    => 'Video',
        'outlet'  => 'UN Web TV',
        'type'    => 'Broadcast · Geneva',
        'date'    => 'Mar 2026',
        'title'   => 'Oral statement at the 61st UNHRC session',
        'desc'    => 'Short description here.',
        'youtube' => 'https://www.youtube.com/watch?v=XXXXXXXXXXX',
    ],
    ------------------------------------------------------- */
];


/* ============================================================
   HELPERS — thumbnails
   ============================================================ */

if (!function_exists('video_youtube_id')) {

    function video_youtube_id(string $url): string
    {
        if (preg_match('~(?:youtu\.be/|youtube(?:-nocookie)?\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/))([A-Za-z0-9_-]{11})~', $url, $m)) {
            return $m[1];
        }

        return '';
    }
}

if (!function_exists('video_http_get')) {

    /* Small, safe HTTP GET (SSL check relaxed so it also works on XAMPP) */
    function video_http_get(string $url, int $maxBytes = 3145728): ?string
    {
        if (!preg_match('#^https?://#i', $url)) {
            return null;
        }

        $ua = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0 Safari/537.36';

        if (function_exists('curl_init')) {

            $ch = curl_init($url);

            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS      => 4,
                CURLOPT_CONNECTTIMEOUT => 4,
                CURLOPT_TIMEOUT        => 6,
                CURLOPT_USERAGENT      => $ua,
                CURLOPT_ENCODING       => '',
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => 0,
            ]);

            $body = curl_exec($ch);
            $code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if (!is_string($body) || $code !== 200 || strlen($body) > $maxBytes) {
                return null;
            }

            return $body;
        }

        $ctx = stream_context_create([
            'http' => ['timeout' => 6, 'header' => 'User-Agent: ' . $ua . "\r\n"],
            'ssl'  => ['verify_peer' => false, 'verify_peer_name' => false],
        ]);

        $body = @file_get_contents($url, false, $ctx, 0, $maxBytes);

        return is_string($body) ? $body : null;
    }
}

if (!function_exists('video_cache_image')) {

    /* Downloads an image once into assets/images/videos/cache/ and returns its relative path */
    function video_cache_image(string $imgUrl, string $key): string
    {
        $dir = dirname(__DIR__) . '/assets/images/videos/cache/';

        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }

        foreach (glob($dir . $key . '.{jpg,png,gif,webp}', GLOB_BRACE) ?: [] as $hit) {
            return 'assets/images/videos/cache/' . basename($hit);
        }

        /* recent failure -> do not retry for 6 hours */
        $fail = $dir . $key . '.fail';

        if (is_file($fail) && (time() - (int)filemtime($fail)) < 21600) {
            return '';
        }

        $bytes = video_http_get($imgUrl);
        $info  = $bytes !== null ? @getimagesizefromstring($bytes) : false;
        $types = [IMAGETYPE_JPEG => 'jpg', IMAGETYPE_PNG => 'png', IMAGETYPE_GIF => 'gif', IMAGETYPE_WEBP => 'webp'];

        if ($info && isset($types[$info[2]])) {

            $name = $key . '.' . $types[$info[2]];

            if (@file_put_contents($dir . $name, $bytes) !== false) {
                return 'assets/images/videos/cache/' . $name;
            }
        }

        @touch($fail);

        return '';
    }
}

if (!function_exists('video_page_image')) {

    /* Finds the og:image / twitter:image of a web page */
    function video_page_image(string $pageUrl): string
    {
        $html = video_http_get($pageUrl, 2097152);

        if ($html === null) {
            return '';
        }

        $patterns = [
            '~<meta[^>]+(?:property|name)=["\'](?:og:image|twitter:image)["\'][^>]*content=["\']([^"\']+)["\']~i',
            '~<meta[^>]+content=["\']([^"\']+)["\'][^>]*(?:property|name)=["\'](?:og:image|twitter:image)["\']~i',
        ];

        foreach ($patterns as $re) {

            if (preg_match($re, $html, $m)) {

                $img = html_entity_decode($m[1], ENT_QUOTES);

                if (strpos($img, '//') === 0) {
                    return 'https:' . $img;
                }

                if ($img !== '' && $img[0] === '/') {
                    $p = parse_url($pageUrl);
                    return ($p['scheme'] ?? 'https') . '://' . ($p['host'] ?? '') . $img;
                }

                return $img;
            }
        }

        return '';
    }
}

if (!function_exists('video_thumb')) {

    function video_thumb(array $v): string
    {
        /* 1. YouTube */
        $yt = video_youtube_id((string)($v['youtube'] ?? ''));

        if ($yt !== '') {
            return 'https://img.youtube.com/vi/' . $yt . '/hqdefault.jpg';
        }

        /* 2. your own thumbnail (local file or full URL) */
        $thumb = trim((string)($v['thumb'] ?? ''));
        $key   = md5((string)($v['url'] ?? $thumb));

        if ($thumb !== '' && !preg_match('#^https?://#i', $thumb)) {

            $local = 'assets/images/videos/' . ltrim($thumb, '/');

            return is_file(dirname(__DIR__) . '/' . $local) ? $local : '';
        }

        if ($thumb !== '') {

            $cached = video_cache_image($thumb, $key);

            return $cached !== '' ? $cached : $thumb;
        }

        /* 3. the page's own preview image */
        $url = (string)($v['url'] ?? '');

        if (!preg_match('#^https?://#i', $url)) {
            return '';
        }

        $dir = dirname(__DIR__) . '/assets/images/videos/cache/';

        foreach (glob($dir . $key . '.{jpg,png,gif,webp}', GLOB_BRACE) ?: [] as $hit) {
            return 'assets/images/videos/cache/' . basename($hit);
        }

        $fail = $dir . $key . '.fail';

        if (is_file($fail) && (time() - (int)filemtime($fail)) < 21600) {
            return '';
        }

        $img = video_page_image($url);

        return $img !== '' ? video_cache_image($img, $key) : '';
    }
}
?>

<style>
    #videos .video-thumb { position: relative; overflow: hidden; }
    #videos .video-thumb-img {
        position: absolute; inset: 0; width: 100%; height: 100%;
        object-fit: cover; z-index: 0; display: block;
    }
    #videos .video-thumb.has-img::after {
        content: ""; position: absolute; inset: 0; z-index: 1; pointer-events: none;
        background: linear-gradient(180deg, rgba(0,0,0,.05) 40%, rgba(0,0,0,.55) 100%);
    }
    #videos .video-thumb.has-img .video-thumb-icon { display: none; }
    #videos .video-thumb .video-play,
    #videos .video-thumb .video-outlet-badge,
    #videos .video-thumb .video-duration { z-index: 2; }
    #videos .video-date { display: block; font-size: .75rem; opacity: .7; margin-bottom: .25rem; }
    #videoModal .modal-content { background: #000; border: 0; border-radius: 14px; overflow: hidden; }
    #videoModal .ratio { background: #000; }
    #videoModal .video-modal-close {
        position: absolute; top: 10px; right: 10px; z-index: 5; width: 38px; height: 38px;
        border: 0; border-radius: 50%; background: rgba(0,0,0,.6); color: #fff; cursor: pointer;
    }
</style>

<section class="section" id="videos">
  <div class="container container-narrow">

    <!-- ============ HEADER ============ -->
    <div class="section-head reveal">
      <h2 class="section-headline">Watch &amp; <em>listen.</em></h2>
      <p>Broadcasts, news videos, and recorded statements from UN platforms and the media.</p>
    </div>

    <!-- ============ VIDEO GRID ============ -->
    <div class="video-grid">

      <?php foreach ($videos as $v): ?>

        <?php
        $yt    = video_youtube_id((string)($v['youtube'] ?? ''));
        $thumb = video_thumb($v);
        $href  = $yt !== '' ? 'https://www.youtube.com/watch?v=' . $yt : (string)($v['url'] ?? '#');
        $label = (string)($v['kind'] ?? 'Video');
        ?>

        <a class="video-card reveal-item"
           href="<?= e($href) ?>"
           <?php if ($yt !== ''): ?>
             data-bs-toggle="modal"
             data-bs-target="#videoModal"
             data-yt="<?= e($yt) ?>"
             data-title="<?= e($v['title'] ?? '') ?>"
           <?php else: ?>
             target="_blank"
             rel="noopener noreferrer"
           <?php endif; ?>>

          <div class="video-thumb<?= $thumb !== '' ? ' has-img' : '' ?>">

            <?php if ($thumb !== ''): ?>
              <img class="video-thumb-img"
                   src="<?= e($thumb) ?>"
                   alt="<?= e($v['title'] ?? 'Video thumbnail') ?>"
                   loading="lazy"
                   referrerpolicy="no-referrer"
                   onerror="this.style.display='none';this.parentNode.classList.remove('has-img');">
            <?php endif; ?>

            <div class="video-thumb-icon">
              <i class="fa-solid <?= e($v['icon'] ?? 'fa-video') ?>"></i>
            </div>

            <span class="video-play">
              <i class="fa-solid <?= $yt !== '' || $label === 'Video' ? 'fa-play' : 'fa-arrow-up-right-from-square' ?>"></i>
            </span>

            <span class="video-duration"><?= e($label) ?></span>
            <span class="video-outlet-badge"><?= e($v['outlet'] ?? '') ?></span>
          </div>

          <div class="video-body">
            <span class="video-type"><?= e($v['type'] ?? '') ?></span>
            <?php if (!empty($v['date'])): ?>
              <span class="video-date"><?= e($v['date']) ?></span>
            <?php endif; ?>
            <h4 class="video-title"><?= e($v['title'] ?? '') ?></h4>
            <p class="video-desc"><?= e($v['desc'] ?? '') ?></p>
          </div>

        </a>

      <?php endforeach; ?>

    </div>

  </div>
</section>


<!-- ============ YOUTUBE POPUP PLAYER ============ -->
<div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">

      <button type="button" class="video-modal-close" data-bs-dismiss="modal" aria-label="Close">
        <i class="fa-solid fa-xmark"></i>
      </button>

      <div class="ratio ratio-16x9">
        <iframe id="videoModalFrame"
                src=""
                title="Video player"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; fullscreen"
                allowfullscreen></iframe>
      </div>

    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const modal = document.getElementById('videoModal');
    const frame = document.getElementById('videoModalFrame');

    if (!modal || !frame) {
        return;
    }

    modal.addEventListener('show.bs.modal', function (event) {

        const btn = event.relatedTarget;
        const id  = btn ? btn.getAttribute('data-yt') : '';

        if (id) {
            frame.src = 'https://www.youtube-nocookie.com/embed/' + encodeURIComponent(id) + '?autoplay=1&rel=0';
            frame.title = btn.getAttribute('data-title') || 'Video player';
        }
    });

    modal.addEventListener('hidden.bs.modal', function () {
        frame.src = '';
    });
});
</script>