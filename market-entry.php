<?php
require_once __DIR__ . '/includes/layout.php';

// Service schema for the market entry firm page.
$extra = "\n  <script type=\"application/ld+json\">\n" . json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Service',
    'name' => 'Business Setup & Market Entry in Bangladesh',
    'description' => 'MAS Consultancy helps foreign companies set up and run in Bangladesh — RJSC registration, BIDA approval, licensing, banking, office setup and staffing.',
    'provider' => ['@type' => 'Organization', 'name' => 'MAS Consultancy', 'url' => 'https://masconsultancy.org/market-entry.php'],
    'areaServed' => ['@type' => 'Country', 'name' => 'Bangladesh'],
    'url' => 'https://masconsultancy.org/market-entry.php',
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . "\n  </script>";

page_head([
    'title'       => 'Start a Business in Bangladesh | MAS Consultancy',
    'description' => 'MAS Consultancy helps foreign companies set up and run in Bangladesh — RJSC registration, BIDA approval, licensing, banking, office setup and staffing.',
    'canonical'   => 'https://masconsultancy.org/market-entry.php',
    'extra'       => $extra,
]);
site_header('market-entry', true);
?>

  <!-- ============ PAGE HERO ============ -->
  <section class="page-hero">
    <div class="container">
      <p class="eyebrow eyebrow-light">MAS Consultancy &middot; Market Entry</p>
      <h1>Set Up in Bangladesh, Properly</h1>
      <p>MAS Consultancy helps foreign companies establish and run a legal, working presence in Bangladesh — serving 52+ US clients and businesses from 20+ countries, from first meeting to fully operational.</p>
    </div>
  </section>

  <!-- ============ JOURNEY ============ -->
  <section class="section">
    <div class="container">
      <div class="section-head reveal">
        <p class="eyebrow">The Guided Path</p>
        <h2 class="section-title">From First Meeting to Fully Operational in Six Steps</h2>
        <p class="section-sub">A guided path for US companies entering Bangladesh — we handle the setup, you run the business.</p>
      </div>
      <ol class="journey">
        <li class="journey-step reveal">
          <span class="journey-num">01</span>
          <div><h3>Market Research &amp; Feasibility</h3><p>We analyze your target sector, identify opportunities, assess competition, and provide a comprehensive market entry report tailored to your business model for the Bangladesh market — so you commit with evidence, not hope.</p></div>
        </li>
        <li class="journey-step reveal">
          <span class="journey-num">02</span>
          <div><h3>Company Registration &amp; Licensing</h3><p>Full management of RJSC incorporation from name clearance to registration, BIDA registration including branch and liaison office approvals for foreign companies, trade license, TIN and VAT registration, and all sector-specific permits required to operate.</p></div>
        </li>
        <li class="journey-step reveal">
          <span class="journey-num">03</span>
          <div><h3>Office Setup &amp; Infrastructure</h3><p>Identifying and securing office space in prime business locations, setting up IT infrastructure, internet connectivity, and all operational utilities — so the operation is real, not just registered.</p></div>
        </li>
        <li class="journey-step reveal">
          <span class="journey-num">04</span>
          <div><h3>Local Staffing &amp; Recruitment</h3><p>We recruit and vet local professionals — engineers, managers, analysts, and support staff — through our network across Bangladesh&apos;s major business hubs, and support work permit recommendations for foreign staff you place in Bangladesh.</p></div>
        </li>
        <li class="journey-step reveal">
          <span class="journey-num">05</span>
          <div><h3>Banking &amp; Financial Setup</h3><p>Corporate bank account opening, foreign currency account management, and liaison with Bangladesh Bank for remittance approvals and foreign investment compliance.</p></div>
        </li>
        <li class="journey-step reveal">
          <span class="journey-num">06</span>
          <div><h3>Ongoing Support &amp; Compliance</h3><p>Continued advisory services, annual compliance management, local government liaison, and dedicated account management for your Bangladesh operations throughout the year.</p></div>
        </li>
      </ol>
    </div>
  </section>

  <!-- ============ BUSINESS DEVELOPMENT ============ -->
  <section class="section section-alt">
    <div class="container">
      <div class="split-grid">
        <div class="split-copy reveal">
          <p class="eyebrow">Beyond Setup</p>
          <h2 class="section-title">Once You&apos;re Set Up, We Build Your Pipeline Too</h2>
          <p>Registration is the beginning, not the business. Our team can also build your sales pipeline while you run the operation — B2B lead generation, LinkedIn outreach, and appointment setting, delivered to agreed targets with regular reporting.</p>
          <a href="services.php#lead-generation" class="btn btn-primary">See Lead Generation</a>
        </div>
        <div class="split-media reveal">
          <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?w=800&q=80" alt="Modern office space" loading="lazy">
        </div>
      </div>
    </div>
  </section>

<?php
cta_band(
    'Start Your Market Entry',
    'Tell us about your company and your plans for Bangladesh — we\'ll reply with the next steps and a realistic timeline.'
);
site_footer();
