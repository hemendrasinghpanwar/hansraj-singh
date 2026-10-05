<?php
/* ============================================================
   nav.php — Full navigation with hybrid links
   ─────────────────────────────────────────────
   • Home / About / Partners / Stalwart Says / Contact → anchors back to index.php
   • Work / Media / Resources dropdowns → separate pages
   ============================================================ */

$currentPage = $currentPage ?? 'home';

/* Active-state helper for dropdowns */
$isActive = fn(string $slug) => $currentPage === $slug;

/* Current-page helpers */
$isHomePage   = ($currentPage === 'home');
$homeUrl      = $isHomePage ? '' : 'index.php';

/* Determine if a dropdown should be highlighted */
$workActive      = in_array($currentPage, ['expertise','experience','speaking','consulting'], true);
$mediaActive     = in_array($currentPage, ['press-creative','videos','gallery','social'], true);
$resourcesActive = in_array($currentPage, ['publications','insights','faq'], true);
?>
<nav class="navbar navbar-expand-lg site-nav fixed-top" id="mainNav">
  <div class="container container-narrow">
    <div class="nav-shell">

      <!-- Brand → always home -->
      <a class="navbar-brand brand" href="<?= $homeUrl ?>#home">
        <?= e($config['profile']['name']) ?><span>.</span>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navMenu">
        <div class="nav-links-wrap" id="navLinksWrap">

          <!-- ============ HOME (anchor) ============ -->
          <a class="nav-link<?= $isHomePage ? ' active' : '' ?>"
             href="<?= $homeUrl ?>#home">
            <?= icon('fa-solid','fa-home') ?>Home
          </a>

          <!-- ============ ABOUT (anchor) ============ -->
          <a class="nav-link"
             href="<?= $homeUrl ?>#about">
            <?= icon('fa-solid','fa-user') ?>About
          </a>

          <!-- ============ SERVICES DROPDOWN ============ -->
          <div class="nav-dropdown">
            <button type="button"
                    class="nav-link nav-dropdown-toggle<?= $workActive ? ' active' : '' ?>"
                    aria-expanded="false">
              <?= icon('fa-solid','fa-briefcase') ?>Services
              <?= icon('fa-solid','fa-chevron-down','nav-caret') ?>
            </button>

            <div class="nav-dropdown-menu" role="menu">
              <div class="nav-dropdown-header">
                <span class="nav-dropdown-header-dot"></span>
                Services &amp; Engagements
              </div>

              <a class="nav-dropdown-item" href="expertise.php">
                <span class="nav-dropdown-icon"><?= icon('fa-solid','fa-layer-group') ?></span>
                <span class="nav-dropdown-text">
                  <strong>Expertise</strong>
                  <em>ECOSOC, multilateral, SDG advocacy</em>
                </span>
              </a>

              <a class="nav-dropdown-item" href="experience.php">
                <span class="nav-dropdown-icon"><?= icon('fa-solid','fa-briefcase') ?></span>
                <span class="nav-dropdown-text">
                  <strong>Experience</strong>
                  <em>Full role history &amp; impact</em>
                </span>
              </a>

              <a class="nav-dropdown-item" href="speaking.php">
                <span class="nav-dropdown-icon"><?= icon('fa-solid','fa-microphone-lines') ?></span>
                <span class="nav-dropdown-text">
                  <strong>Speaking</strong>
                  <em>Panels, UNHRC statements, talks</em>
                </span>
              </a>

              <a class="nav-dropdown-item" href="consulting.php">
                <span class="nav-dropdown-icon"><?= icon('fa-solid','fa-handshake-angle') ?></span>
                <span class="nav-dropdown-text">
                  <strong>Consulting</strong>
                  <em>Advisory for mission-driven orgs</em>
                </span>
              </a>
            </div>
          </div>

          <!-- ============ MEDIA DROPDOWN ============ -->
          <div class="nav-dropdown">
            <button type="button"
                    class="nav-link nav-dropdown-toggle<?= $mediaActive ? ' active' : '' ?>"
                    aria-expanded="false">
              <?= icon('fa-solid','fa-photo-film') ?>Media
              <?= icon('fa-solid','fa-chevron-down','nav-caret') ?>
            </button>

            <div class="nav-dropdown-menu" role="menu">
              <div class="nav-dropdown-header">
                <span class="nav-dropdown-header-dot"></span>
                Media &amp; Coverage
              </div>

              <a class="nav-dropdown-item" href="press-creative.php">
                <span class="nav-dropdown-icon"><?= icon('fa-solid','fa-newspaper') ?></span>
                <span class="nav-dropdown-text">
                  <strong>Press &amp; Articles</strong>
                  <em>ThePrint, ANI, Times of India</em>
                </span>
              </a>

              <a class="nav-dropdown-item" href="videos.php">
                <span class="nav-dropdown-icon"><?= icon('fa-solid','fa-video') ?></span>
                <span class="nav-dropdown-text">
                  <strong>Videos &amp; Interviews</strong>
                  <em>UN Web TV, ANI, YouTube</em>
                </span>
              </a>

              <a class="nav-dropdown-item" href="gallery.php">
                <span class="nav-dropdown-icon"><?= icon('fa-solid','fa-images') ?></span>
                <span class="nav-dropdown-text">
                  <strong>Photo Gallery</strong>
                  <em>UN Geneva, field work, events</em>
                </span>
              </a>

              <a class="nav-dropdown-item" href="social.php">
                <span class="nav-dropdown-icon"><?= icon('fa-solid','fa-hashtag') ?></span>
                <span class="nav-dropdown-text">
                  <strong>Social Feed</strong>
                  <em>Live from LinkedIn &amp; Instagram</em>
                </span>
              </a>
            </div>
          </div>

          <!-- ============ RESOURCES DROPDOWN ============ -->
          <div class="nav-dropdown">
            <button type="button"
                    class="nav-link nav-dropdown-toggle<?= $resourcesActive ? ' active' : '' ?>"
                    aria-expanded="false">
              <?= icon('fa-solid','fa-bookmark') ?>Resources
              <?= icon('fa-solid','fa-chevron-down','nav-caret') ?>
            </button>

            <div class="nav-dropdown-menu" role="menu">
              <div class="nav-dropdown-header">
                <span class="nav-dropdown-header-dot"></span>
                Downloads &amp; Writing
              </div>

              <a class="nav-dropdown-item" href="publications.php">
                <span class="nav-dropdown-icon"><?= icon('fa-solid','fa-file-lines') ?></span>
                <span class="nav-dropdown-text">
                  <strong>Publications</strong>
                  <em>Annual reports, policy papers</em>
                </span>
              </a>

              <a class="nav-dropdown-item" href="insights.php">
                <span class="nav-dropdown-icon"><?= icon('fa-solid','fa-lightbulb') ?></span>
                <span class="nav-dropdown-text">
                  <strong>Insights &amp; Writing</strong>
                  <em>Blog posts &amp; field notes</em>
                </span>
              </a>

              <a class="nav-dropdown-item" href="faq.php">
                <span class="nav-dropdown-icon"><?= icon('fa-solid','fa-circle-question') ?></span>
                <span class="nav-dropdown-text">
                  <strong>FAQ</strong>
                  <em>Common questions &amp; collaboration</em>
                </span>
              </a>
            </div>
          </div>

          <!-- ============ PARTNERS (anchor) ============ -->
          <a class="nav-link"
             href="<?= $homeUrl ?>#partners">
            <?= icon('fa-solid','fa-handshake') ?>Partners
          </a>

          <!-- ============ STALWART SAYS (anchor) ============ -->
          <a class="nav-link"
             href="<?= $homeUrl ?>#testimonials">
            <?= icon('fa-solid','fa-quote-left') ?>Stalwart Says
          </a>

          <!-- ============ CONTACT (anchor) ============ -->
          <a class="nav-link"
             href="<?= $homeUrl ?>#contact">
            <?= icon('fa-solid','fa-envelope') ?>Contact
          </a>
        </div>

        <a href="<?= $homeUrl ?>#contact" class="nav-cta">
          <?= icon('fa-solid','fa-paper-plane') ?> Let's talk
        </a>
      </div>
    </div>
  </div>
</nav>