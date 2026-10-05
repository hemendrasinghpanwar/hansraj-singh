<?php
declare(strict_types=1);

/* ============================================================
   sections/press-creative.php — Press page
   ============================================================ */

$press = $config['press'] ?? null;

if (!$press) {
    return;
}

/* ------------------------------------------------------------
   SITE BASE URL
   Builds e.g.  http://localhost/portfolio
   from the current request, so image URLs always come out as:
   http://localhost/portfolio/assets/images/press/cutouts/cutout-1.jpg
   ------------------------------------------------------------ */
if (!function_exists('press_origin')) {

    function press_origin(): string
    {
        $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || ((int)($_SERVER['SERVER_PORT'] ?? 0) === 443);

        return ($https ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost');
    }
}

if (!function_exists('press_site_base')) {

    function press_site_base(): string
    {
        $dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/'));

        return press_origin() . rtrim($dir, '/');
    }
}

/* ------------------------------------------------------------
   CUTOUTS FOLDER LOCATION
   Walks up from this file until it finds
   assets/images/press/cutouts  (works whether this file sits in
   /sections or in the project root), then builds the web URL
   from the folder's real position under the web server root, e.g.
   C:/xampp/htdocs/portfolio  ->  http://localhost/portfolio
   ------------------------------------------------------------ */
if (!function_exists('press_cutout_location')) {

    function press_cutout_location(): array
    {
        static $loc = null;

        if ($loc !== null) {
            return $loc;
        }

        $rel   = 'assets/images/press/cutouts';
        $root  = null;
        $probe = __DIR__;

        for ($n = 0; $n < 4; $n++) {

            if (is_dir($probe . '/' . $rel)) {
                $root = $probe;
                break;
            }

            $parent = dirname($probe);

            if ($parent === $probe) {
                break;
            }

            $probe = $parent;
        }

        if ($root === null) {
            return $loc = [
                'dir' => null,
                'url' => press_site_base() . '/' . $rel . '/',
            ];
        }

        $rootN = str_replace('\\', '/', (string)realpath($root));
        $docN  = str_replace('\\', '/', (string)realpath($_SERVER['DOCUMENT_ROOT'] ?? ''));

        if ($docN !== '' && stripos($rootN, $docN) === 0) {
            $url = press_origin() . substr($rootN, strlen($docN)) . '/' . $rel . '/';
        } else {
            $url = press_site_base() . '/' . $rel . '/';
        }

        return $loc = [
            'dir' => $root . '/' . $rel . '/',
            'url' => $url,
        ];
    }
}

/* All image files that are physically inside the cutouts folder */
if (!function_exists('press_cutout_files')) {

    function press_cutout_files(): array
    {
        $loc = press_cutout_location();

        if ($loc['dir'] === null) {
            return [];
        }

        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'jfif', 'gif', 'avif'];
        $out     = [];

        foreach (scandir($loc['dir']) ?: [] as $f) {

            if (is_file($loc['dir'] . $f)
                && in_array(strtolower(pathinfo($f, PATHINFO_EXTENSION)), $allowed, true)) {
                $out[] = $f;
            }
        }

        natcasesort($out);

        return array_values($out);
    }
}

/* ------------------------------------------------------------
   PLACEHOLDER (inline SVG — no extra file needed)
   Shows the file name it was looking for, so a wrong name or
   extension is easy to spot.
   ------------------------------------------------------------ */
if (!function_exists('press_missing_img')) {

    function press_missing_img(string $label): string
    {
        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="600" height="800" viewBox="0 0 600 800">'
             . '<rect width="600" height="800" fill="#1a1a1a"/>'
             . '<text x="300" y="390" fill="#c9a24b" font-family="Arial" font-size="26" text-anchor="middle">Image not found</text>'
             . '<text x="300" y="430" fill="#999" font-family="Arial" font-size="20" text-anchor="middle">'
             . htmlspecialchars($label, ENT_QUOTES)
             . '</text></svg>';

        return 'data:image/svg+xml;charset=utf-8,' . rawurlencode($svg);
    }
}

/* ------------------------------------------------------------
   NEWSPAPER CUTOUT IMAGE
   Folder: assets/images/press/cutouts/

   - Uses 'img_local' from config (e.g. cutout-1.jpg)
   - If empty, falls back to cutout-{number}.jpg
   - If that exact file is missing, finds the same name with
     another extension / letter-case (.jpeg .png .webp .jfif ...)
   ------------------------------------------------------------ */
if (!function_exists('press_cutout_find')) {

    /* Returns the real file name inside the cutouts folder, or null */
    function press_cutout_find(array $item, int $index = 0): ?string
    {
        $loc = press_cutout_location();

        if ($loc['dir'] === null) {
            return null;
        }

        $files = press_cutout_files();

        /* clean the configured name (hidden / non-ASCII characters) */
        $local = basename((string)($item['img_local'] ?? ''));
        $local = trim(preg_replace('/[^\x20-\x7E]/', '', $local) ?? '');

        if ($local === '') {
            $local = 'cutout-' . ($index + 1) . '.jpg';
        }

        /* 1. exact name */
        if (is_file($loc['dir'] . $local)) {
            return $local;
        }

        /* 2. same name, any extension / letter-case */
        $stem = strtolower(pathinfo($local, PATHINFO_FILENAME));

        foreach ($files as $f) {
            if (strtolower(pathinfo($f, PATHINFO_FILENAME)) === $stem) {
                return $f;
            }
        }

        /* 3. same number: cutout-7 matches cutout-07.png etc. */
        if (preg_match('/(\d+)/', $stem, $m)) {

            foreach ($files as $f) {
                if (preg_match('/^cutout-0*' . (int)$m[1] . '\.[a-z0-9]+$/i', $f)) {
                    return $f;
                }
            }
        }

        /* 4. last resort: same position in the folder */
        return $files[$index] ?? null;
    }
}

if (!function_exists('press_cutout_img')) {

    function press_cutout_img(array $item, int $index = 0): string
    {
        $found = press_cutout_find($item, $index);

        if ($found !== null) {
            return press_cutout_location()['url'] . rawurlencode($found);
        }

        $label = basename(trim((string)($item['img_local'] ?? ''))) ?: 'cutout-' . ($index + 1) . '.jpg';

        return press_missing_img($label);
    }
}

/* ------------------------------------------------------------
   OTHER PRESS IMAGES (lead, cards, wire)
   Local file in assets/images/ first, remote URL as fallback.
   ------------------------------------------------------------ */
if (!function_exists('press_creative_img')) {

    function press_creative_img(array $item): string
    {
        $local = trim((string)($item['img_local'] ?? ''));

        if ($local !== '') {

            if (preg_match('#^https?://#i', $local)) {
                return $local;
            }

            $local = ltrim($local, '/');

            if (is_file(dirname(__DIR__) . '/assets/images/' . $local)) {
                return 'assets/images/' . $local;
            }
        }

        return (string)($item['img'] ?? '');
    }
}
?>

<section class="press-page" id="press-creative">

    <div class="container container-narrow">

        <!-- STATS BAR -->

        <div class="press-stats-bar reveal">

            <?php foreach (($press['stats'] ?? []) as $s): ?>

                <div class="press-hero-stat">

                    <span class="press-hero-stat-num" data-count="<?= (int)($s['value'] ?? 0) ?>">
                        <?= (int)($s['value'] ?? 0) ?>
                    </span>

                    <span class="press-hero-stat-label">
                        <?= e($s['label'] ?? '') ?>
                    </span>

                </div>

            <?php endforeach; ?>

        </div>


        <!-- LEAD STORY -->

        <?php if (!empty($press['lead'])): ?>

            <a
                class="press-feature reveal"
                href="<?= e($press['lead']['url'] ?? '#') ?>"
                target="_blank"
                rel="noopener noreferrer"
            >

                <div class="press-feature-media">

                    <img
                        src="<?= e(press_creative_img($press['lead'])) ?>"
                        alt="<?= e($press['lead']['outlet'] ?? 'Press coverage') ?>"
                        loading="eager"
                        referrerpolicy="no-referrer"
                    >

                    <span class="press-feature-badge">
                        <?= icon('fa-solid', 'fa-star') ?>
                        Featured Story
                    </span>

                    <span class="press-feature-index">01</span>

                </div>

                <div class="press-feature-body">

                    <div class="press-feature-meta">
                        <span class="press-outlet-pill"><?= e($press['lead']['outlet'] ?? '') ?></span>
                        <span class="press-meta-sep">&middot;</span>
                        <span class="press-meta-text"><?= e($press['lead']['type'] ?? '') ?></span>
                    </div>

                    <h2 class="press-feature-title"><?= e($press['lead']['title'] ?? '') ?></h2>

                    <p class="press-feature-excerpt"><?= e($press['lead']['excerpt'] ?? '') ?></p>

                    <span class="press-feature-cta">
                        Read the full story
                        <?= icon('fa-solid', 'fa-arrow-right') ?>
                    </span>

                </div>

            </a>

        <?php endif; ?>


        <!-- MORE COVERAGE -->

        <div class="press-section-head reveal">
            <div class="press-section-line"></div>
            <h3 class="press-section-title">More coverage</h3>
            <div class="press-section-line"></div>
        </div>

        <div class="press-article-grid">

            <?php foreach (($press['cards'] ?? []) as $i => $c): ?>

                <a
                    class="press-article reveal-item"
                    href="<?= e($c['url'] ?? '#') ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                >

                    <div class="press-article-media">

                        <img
                            src="<?= e(press_creative_img($c)) ?>"
                            alt="<?= e($c['outlet'] ?? 'Press coverage') ?>"
                            loading="lazy"
                            referrerpolicy="no-referrer"
                        >

                        <span class="press-article-num">
                            <?= str_pad((string)($i + 2), 2, '0', STR_PAD_LEFT) ?>
                        </span>

                    </div>

                    <div class="press-article-body">

                        <span class="press-outlet-pill small<?= !empty($c['accent']) ? ' accent' : '' ?>">
                            <?= e($c['outlet'] ?? '') ?>
                        </span>

                        <h4 class="press-article-title"><?= e($c['title'] ?? '') ?></h4>

                        <span class="press-article-cta">
                            Read
                            <?= icon('fa-solid', 'fa-arrow-right') ?>
                        </span>

                    </div>

                </a>

            <?php endforeach; ?>

        </div>


        <!-- NEWSPAPER CLIPPINGS -->

        <div class="press-section-head reveal">
            <div class="press-section-line"></div>
            <h3 class="press-section-title">Newspaper clippings</h3>
            <div class="press-section-line"></div>
        </div>

        <div class="press-clippings reveal">

            <?php
            /*
             * Config entries first (keeps your outlet / date / headline),
             * then every other image found in the cutouts folder.
             */
            $cutouts = $press['cutouts'] ?? [];
            $used    = [];

            foreach ($cutouts as $ci => $c) {
                $f = press_cutout_find($c, (int)$ci);
                if ($f !== null) {
                    $used[strtolower($f)] = true;
                }
            }

            $showExtras = false; /* true = also add unlisted folder images as extra cards */

            foreach ($showExtras ? press_cutout_files() : [] as $f) {
                if (!isset($used[strtolower($f)])) {
                    $cutouts[] = [
                        'outlet'    => 'Press clipping',
                        'date'      => '',
                        'headline'  => 'Newspaper clipping',
                        'img_local' => $f,
                    ];
                }
            }

            if (isset($_GET['debug'])) {
                $loc = press_cutout_location();
                echo '<pre style="grid-column:1/-1;background:#111;color:#9f9;padding:12px;font-size:12px">'
                   . 'dir: ' . e((string)$loc['dir']) . "\n"
                   . 'url: ' . e($loc['url']) . "\n"
                   . 'files: ' . e(implode(', ', press_cutout_files()))
                   . '</pre>';
            }
            ?>

            <?php foreach ($cutouts as $i => $cut): ?>

                <?php
                $clipImg     = press_cutout_img($cut, (int)$i);
                $clipMissing = press_missing_img(basename((string)($cut['img_local'] ?? 'cutout-' . ($i + 1) . '.jpg')));
                ?>

                <button
                    type="button"
                    class="press-clip"
                    data-bs-toggle="modal"
                    data-bs-target="#clippingModal"
                    data-img="<?= e($clipImg) ?>"
                    data-outlet="<?= e($cut['outlet'] ?? '') ?>"
                    data-date="<?= e($cut['date'] ?? '') ?>"
                    data-headline="<?= e($cut['headline'] ?? '') ?>"
                >

                    <div class="press-clip-media">

                        <img
                            src="<?= e($clipImg) ?>"
                            alt="<?= e($cut['headline'] ?? 'Newspaper clipping') ?>"
                            loading="lazy"
                            referrerpolicy="no-referrer"
                            onerror="this.onerror=null;this.src='<?= $clipMissing ?>';"
                        >

                        <div class="press-clip-overlay">
                            <span class="press-clip-expand">
                                <?= icon('fa-solid', 'fa-expand') ?>
                            </span>
                        </div>

                        <span class="press-clip-outlet">
                            <?= e($cut['outlet'] ?? '') ?>
                        </span>

                    </div>

                    <div class="press-clip-body">

                        <span class="press-clip-date"><?= e($cut['date'] ?? '') ?></span>

                        <h4 class="press-clip-headline"><?= e($cut['headline'] ?? '') ?></h4>

                    </div>

                </button>

            <?php endforeach; ?>

        </div>


        <!-- HEADLINES TICKER -->

        <div class="press-headlines reveal">

            <span class="press-headlines-label">
                <?= icon('fa-solid', 'fa-bolt') ?>
                Live wire
            </span>

            <div class="press-headlines-viewport">

                <div class="press-headlines-track">

                    <?php for ($i = 0; $i < 2; $i++): ?>

                        <?php foreach (($press['outlets'] ?? []) as $outlet): ?>

                            <span class="press-headline-item">
                                <i class="fa-solid fa-circle"></i>
                                <?= e($outlet) ?>
                            </span>

                        <?php endforeach; ?>

                    <?php endfor; ?>

                </div>

            </div>

        </div>


        <!-- FROM THE WIRE -->

        <div class="press-section-head reveal">
            <div class="press-section-line"></div>
            <h3 class="press-section-title">From the wire</h3>
            <div class="press-section-line"></div>
        </div>

        <div class="press-wire-grid">

            <?php foreach (($press['wire'] ?? []) as $i => $w): ?>

                <a
                    class="press-wire-item reveal-item"
                    href="<?= e($w['url'] ?? '#') ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                >

                    <span class="press-wire-num">
                        <?= str_pad((string)($i + 6), 2, '0', STR_PAD_LEFT) ?>
                    </span>

                    <div class="press-wire-thumb">
                        <img
                            src="<?= e(press_creative_img($w)) ?>"
                            alt=""
                            loading="lazy"
                            referrerpolicy="no-referrer"
                        >
                    </div>

                    <div class="press-wire-body">
                        <span class="press-wire-outlet"><?= e($w['outlet'] ?? '') ?></span>
                        <h4 class="press-wire-headline"><?= e($w['title'] ?? '') ?></h4>
                    </div>

                    <span class="press-wire-arrow">
                        <?= icon('fa-solid', 'fa-arrow-right') ?>
                    </span>

                </a>

            <?php endforeach; ?>

        </div>


        <!-- PRESS KIT CTA -->

        <div class="press-kit reveal">

            <div class="press-kit-icon">
                <?= icon('fa-solid', 'fa-paper-plane') ?>
            </div>

            <div class="press-kit-body">
                <h3>Media enquiries &amp; press kit</h3>
                <p>Downloadable assets, high-res photos, and direct contact for journalists.</p>
            </div>

            <a href="#contact" class="btn-gold">
                Request press kit
                <?= icon('fa-solid', 'fa-arrow-right') ?>
            </a>

        </div>

    </div>

</section>


<!-- NEWSPAPER CLIPPING LIGHTBOX -->

<div class="modal fade clipping-modal" id="clippingModal" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-xl">

        <div class="modal-content">

            <button type="button" class="clipping-modal-close" data-bs-dismiss="modal" aria-label="Close">
                <?= icon('fa-solid', 'fa-xmark') ?>
            </button>

            <div class="clipping-modal-image">
                <img src="" alt="" id="clippingModalImg">
            </div>

            <div class="clipping-modal-meta">
                <span class="clipping-modal-outlet" id="clippingModalOutlet"></span>
                <span class="clipping-modal-date" id="clippingModalDate"></span>
                <h4 class="clipping-modal-headline" id="clippingModalHeadline"></h4>
            </div>

        </div>

    </div>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const modal = document.getElementById('clippingModal');

    if (!modal) {
        return;
    }

    const img      = modal.querySelector('#clippingModalImg');
    const outlet   = modal.querySelector('#clippingModalOutlet');
    const date     = modal.querySelector('#clippingModalDate');
    const headline = modal.querySelector('#clippingModalHeadline');

    modal.addEventListener('show.bs.modal', function (event) {

        const btn = event.relatedTarget;

        if (!btn) {
            return;
        }

        const text = btn.getAttribute('data-headline') || '';

        if (img) {
            img.src = btn.getAttribute('data-img') || '';
            img.alt = text;
        }

        if (outlet)   { outlet.textContent   = btn.getAttribute('data-outlet') || ''; }
        if (date)     { date.textContent     = btn.getAttribute('data-date') || ''; }
        if (headline) { headline.textContent = text; }
    });

    modal.addEventListener('hidden.bs.modal', function () {

        if (img) {
            img.src = '';
            img.alt = '';
        }
    });
});
</script>