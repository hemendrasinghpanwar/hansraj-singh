<footer class="site-footer">
  <div class="container container-narrow">
    &copy; <span id="year"></span>
    <?= e($config['profile']['name']) ?> —
    <span><?= e($config['profile']['title']) ?></span>
  </div>
</footer>

<button id="backToTop" aria-label="Back to top">
  <?= icon('fa-solid','fa-arrow-up') ?>
</button>

<!-- ============================================================
     APP CONFIG — must load BEFORE main.js
     ============================================================ -->
<script>
window.APP_CONFIG = <?= json_encode([
    'roles'      => $config['profile']['roles'],
    'contactUrl' => 'contact-handler.php',
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
</script>

<!-- ============================================================
     CORE LIBRARIES
     ============================================================ -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>

<!-- ============================================================
     SOCIAL FEEDS — optional (only if the files exist)
     ============================================================ -->
<?php if (file_exists(__DIR__ . '/../assets/css/social.css')): ?>
  <link rel="stylesheet" href="assets/css/social.css">
<?php endif; ?>

<?php if (file_exists(__DIR__ . '/../assets/js/social.js')): ?>
  <script src="assets/js/social.js" defer></script>
<?php endif; ?>

<!-- ============================================================
     PLATFORM SDKs — load only if the page has social embeds
     ============================================================ -->
<?php if ($currentPage === 'home' || $currentPage === 'social'): ?>

  <!-- LinkedIn SDK -->
  <script src="https://platform.linkedin.com/in.js" type="text/javascript"></script>

  <!-- Facebook SDK -->
  <div id="fb-root"></div>
  <script async defer crossorigin="anonymous"
          src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v25.0&appId=YOUR_FACEBOOK_APP_ID&autoLogAppEvents=1"></script>

  <!-- Instagram SDK -->
  <script async src="https://www.instagram.com/embed.js"></script>

<?php endif; ?>

</body>
</html>