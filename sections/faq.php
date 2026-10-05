<?php
/* ============================================================
   FAQ — Common questions & collaboration info
   ============================================================ */
$faqs = [
    [
        'q' => 'What kind of organisations do you work with?',
        'a' => 'I focus on NGOs, multilateral institutions, and social-impact organisations — particularly those working in gender equality, education, human rights, or sustainable development. I also advise smaller civil-society groups preparing for their first UN engagement.',
    ],
    [
        'q' => 'Are you available for consulting engagements?',
        'a' => 'Yes — I take on a small number of consulting projects each quarter, usually 2–3 concurrent engagements. Typical projects run 6–12 weeks and focus on multilateral strategy, communications, or digital transformation.',
    ],
    [
        'q' => 'What does a typical engagement look like?',
        'a' => 'We start with a discovery call to understand your goals, constraints, and timeline. Then I prepare a short scope document with deliverables, milestones, and a fixed-fee or retainer quote. Most engagements are collaborative rather than hands-off.',
    ],
    [
        'q' => 'Do you work remotely or on-site?',
        'a' => 'Both. I am based in Rajasthan and available for on-site work across India. For international clients, I work remotely and can travel for key milestones — UN sessions, launches, or intensive workshops.',
    ],
    [
        'q' => 'What are your rates?',
        'a' => 'Rates depend on scope, timeline, and sector. I offer reduced rates for grassroots NGOs and full rates for institutional or government clients. Let\'s discuss your project and I\'ll send a transparent quote with no surprises.',
    ],
    [
        'q' => 'Can you represent our organisation at the UN?',
        'a' => 'I can advise on accreditation, statement drafting, and delegation preparation. Where appropriate, I also represent organisations at UNHRC or ECOSOC sessions as part of a formal engagement. This is usually scoped separately.',
    ],
    [
        'q' => 'What languages do you work in?',
        'a' => 'English, Hindi, and Rajasthani at full professional level. I am currently learning French (A2) and can read/write basic French documents with assistance.',
    ],
    [
        'q' => 'How do we get started?',
        'a' => 'Send a brief note through the contact form describing your project, timeline, and budget range. I respond to all inquiries within 2 business days. From there, we schedule a discovery call.',
    ],
];
?>
<section class="section" id="faq">
  <div class="container container-narrow">

    <!-- ============ HEADER ============ -->
    <div class="section-head reveal">
      <h2 class="section-headline">Common <em>questions.</em></h2>
      <p>Quick answers on collaboration, scope, and how engagements typically work.</p>
    </div>

    <!-- ============ FAQ LIST ============ -->
    <div class="faq-list">
      <?php foreach ($faqs as $i => $f): ?>
        <details class="faq-item reveal-item"<?= $i === 0 ? ' open' : '' ?>>
          <summary class="faq-question">
            <span class="faq-num"><?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <span class="faq-q-text"><?= e($f['q']) ?></span>
            <span class="faq-toggle" aria-hidden="true">
              <i class="fa-solid fa-plus"></i>
              <i class="fa-solid fa-minus"></i>
            </span>
          </summary>
          <div class="faq-answer">
            <p><?= e($f['a']) ?></p>
          </div>
        </details>
      <?php endforeach; ?>
    </div>

    <!-- ============ CTA ============ -->
    <div class="faq-cta reveal">
      <p>Still have a question?</p>
      <a href="#contact" class="btn-gold">Get in touch <?= icon('fa-solid','fa-arrow-right') ?></a>
    </div>

  </div>
</section>