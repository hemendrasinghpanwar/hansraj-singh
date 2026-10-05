<?php
/* ============================================================
   contact.php — Contact section with AJAX form
   Sends via contact-handler.php → PHPMailer SMTP
   ============================================================ */
?>
<section class="section contact-section" id="contact">
  <div class="container container-narrow">
    <div class="contact-card row gy-5 reveal">

      <!-- ============================================================
           LEFT COLUMN — contact info
           ============================================================ -->
      <div class="col-lg-5">
        <span class="contact-rail">
          <span class="contact-rail-dot"></span>
          Get In Touch
        </span>

        <h2>Let's coordinate.</h2>

        <p>
          Open to discussions on multilateral coordination, institutional
          partnerships, and ECOSOC-related engagement. Send a message and
          it'll reach my inbox directly.
        </p>

        <!-- ---------- Quick stats ---------- -->
        <div class="contact-stats">
          <div class="contact-stat">
            <b>&lt;24h</b>
            <span>Avg. Reply</span>
          </div>
          <div class="contact-stat">
            <b>Remote</b>
            <span>Availability</span>
          </div>
          <div class="contact-stat">
            <b><?= e($config['profile']['timezone']) ?></b>
            <span>Timezone</span>
          </div>
        </div>

        <!-- ---------- Quick contact links ---------- -->
        <div class="quick-contacts">
          <a href="mailto:<?= e($config['profile']['email']) ?>">
            <?= icon('fa-solid','fa-envelope') ?>
            <?= e($config['profile']['email']) ?>
          </a>

          <a href="tel:<?= e(preg_replace('/\s+/', '', $config['profile']['phone'])) ?>">
            <?= icon('fa-solid','fa-phone') ?>
            <?= e($config['profile']['phone']) ?>
          </a>

          <a href="<?= e($config['profile']['linkedin']) ?>" target="_blank" rel="noopener">
            <?= icon('fa-brands','fa-linkedin-in') ?>
            linkedin.com/in/hansraj-mba-socialworker
          </a>
        </div>

        <!-- ---------- Visa / availability note ---------- -->
        <p class="contact-note">
          <?= icon('fa-solid','fa-passport') ?>
          Holds a valid Schengen visa (through Aug 2026) &amp; open to remote collaboration.
        </p>

        <!-- ---------- Social row ---------- -->
        <div class="social-row">
          <a href="<?= e($config['profile']['linkedin']) ?>"
             target="_blank" rel="noopener"
             aria-label="LinkedIn">
            <?= icon('fa-brands','fa-linkedin-in') ?>
          </a>
          <a href="mailto:<?= e($config['profile']['email']) ?>"
             aria-label="Email">
            <?= icon('fa-solid','fa-envelope') ?>
          </a>
        </div>
      </div>

      <!-- ============================================================
           RIGHT COLUMN — contact form
           ============================================================ -->
      <div class="col-lg-7">
        <form class="contact-form"
              id="contactForm"
              method="POST"
              action="contact-handler.php"
              novalidate
              autocomplete="on">

          <div class="row">

            <!-- Name -->
            <div class="col-md-6">
              <div class="form-floating">
                <input type="text"
                       name="name"
                       class="form-control"
                       id="cf-name"
                       placeholder="Your name"
                       autocomplete="name"
                       required>
                <label for="cf-name">Your name</label>
                <div class="invalid-feedback">Please share your name.</div>
              </div>
            </div>

            <!-- Email -->
            <div class="col-md-6">
              <div class="form-floating">
                <input type="email"
                       name="email"
                       class="form-control"
                       id="cf-email"
                       placeholder="Your email"
                       autocomplete="email"
                       required>
                <label for="cf-email">Your email</label>
                <div class="invalid-feedback">A valid email helps me reply.</div>
              </div>
            </div>

          </div>

          <!-- Subject -->
          <div class="form-floating">
            <input type="text"
                   name="subject"
                   class="form-control"
                   id="cf-subject"
                   placeholder="Subject"
                   autocomplete="off"
                   required>
            <label for="cf-subject">Subject</label>
            <div class="invalid-feedback">Please add a short subject.</div>
          </div>

          <!-- Message -->
          <div class="form-floating">
            <textarea class="form-control"
                      name="message"
                      id="cf-message"
                      placeholder="Your message"
                      autocomplete="off"
                      required
                      maxlength="5000"></textarea>
            <label for="cf-message">Your message</label>
            <div class="invalid-feedback">Let me know what you'd like to discuss.</div>
          </div>

          <!-- Honeypot — invisible to humans, catches bots -->
          <div class="contact-honeypot" aria-hidden="true">
            <label for="cf-website">Website (leave empty)</label>
            <input type="text"
                   name="website"
                   id="cf-website"
                   value=""
                   tabindex="-1"
                   autocomplete="off">
          </div>

          <!-- Submit -->
          <button type="submit" class="btn btn-gold" id="cfSubmit">
            <?= icon('fa-solid','fa-paper-plane') ?>
            Send message
          </button>

          <!-- Success message -->
          <div class="form-success" id="formSuccess" role="status" aria-live="polite">
            <?= icon('fa-solid','fa-circle-check') ?>
            <span>Your message has been sent successfully. I'll reply within 24 hours.</span>
          </div>

          <!-- Error message -->
          <div class="form-error" id="formError" role="alert" aria-live="polite">
            <?= icon('fa-solid','fa-circle-exclamation') ?>
            <span>Something went wrong. Please try again or email directly.</span>
          </div>

        </form>
      </div>

    </div>
  </div>
</section>