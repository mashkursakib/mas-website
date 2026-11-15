<?php
require_once __DIR__ . '/includes/layout.php';

page_head([
    'title'       => 'Our Work | MAS Group — Selected Engagements',
    'description' => 'Selected MAS Group engagements: government tenders won, websites and stores built, and foreign companies set up. Client names withheld.',
    'canonical'   => 'https://masconsultancy.org/portfolio.php',
]);
site_header('portfolio', true);
?>

  <!-- ============ PAGE HERO ============ -->
  <section class="page-hero">
    <div class="container">
      <p class="eyebrow eyebrow-light">Our Work</p>
      <h1>Results Across the MAS Group</h1>
      <p>Selected engagements, firm by firm. Client names are withheld for confidentiality — the work below is representative of what each firm delivers.</p>
    </div>
  </section>

  <!-- ============ ENGAGEMENTS ============ -->
  <section class="section">
    <div class="container">
      <div class="cards-grid">
        <article class="card reveal">
          <div class="card-icon" aria-hidden="true">📋</div>
          <p class="card-kicker">MAS Corporation &middot; Works Tender</p>
          <h3>Infrastructure Works Tender</h3>
          <p><strong>What MAS did:</strong> Tracked the opportunity on e-GP, screened the client against the eligibility criteria, turned the full tender document into a working checklist, priced the bill of quantities from real costs, verified licenses, certificates, and bank documents twice, and submitted well ahead of the deadline.</p>
          <p><strong>Outcome:</strong> Contract awarded on a compliant, realistically priced bid.</p>
        </article>
        <article class="card reveal">
          <div class="card-icon" aria-hidden="true">📦</div>
          <p class="card-kicker">MAS Corporation &middot; Goods Supply</p>
          <h3>Goods Supply Tender</h3>
          <p><strong>What MAS did:</strong> Monitored the DPHE and BWDB portals for a matching opportunity, confirmed eligibility before bidding, checked the specification line by line against what the client could supply, prepared the full document set, and priced from actual supply costs.</p>
          <p><strong>Outcome:</strong> Fully compliant bid submitted early, with no disqualification risk on paperwork.</p>
        </article>
        <article class="card reveal">
          <div class="card-icon" aria-hidden="true">💻</div>
          <p class="card-kicker">MAS Communication &middot; Corporate Website</p>
          <h3>Business Website with CMS &amp; Blog</h3>
          <p><strong>What MAS did:</strong> Took the brief and goals, produced a custom design for the client brand, built the site cleanly with a CMS, admin panel, and blog the client can update directly, structured the pages for on-page SEO, and launched with handover and support.</p>
          <p><strong>Outcome:</strong> A live, searchable website the client manages day to day without developer help.</p>
        </article>
        <article class="card reveal">
          <div class="card-icon" aria-hidden="true">🛒</div>
          <p class="card-kicker">MAS Communication &middot; Online Sales</p>
          <h3>E-Commerce Store</h3>
          <p><strong>What MAS did:</strong> Designed and built the store around how the business sells, set up the product catalogue, integrated payments, configured order management so orders, payments, and fulfilment sit in one flow, and tested the full purchase journey before launch.</p>
          <p><strong>Outcome:</strong> The business trades online with payments and orders handled in a single system.</p>
        </article>
        <article class="card reveal">
          <div class="card-icon" aria-hidden="true">🌏</div>
          <p class="card-kicker">MAS Consultancy &middot; New Entity</p>
          <h3>Full Foreign Company Setup</h3>
          <p><strong>What MAS did:</strong> Handled the complete sequence end to end — RJSC incorporation from name clearance to registration, BIDA registration, trade license, TIN and VAT registration, corporate bank account support, and practical office setup.</p>
          <p><strong>Outcome:</strong> A fully registered, licensed, and banked company, ready to trade from day one.</p>
        </article>
        <article class="card reveal">
          <div class="card-icon" aria-hidden="true">🏢</div>
          <p class="card-kicker">MAS Consultancy &middot; Branch Presence</p>
          <h3>Branch Office Setup with Work Permits</h3>
          <p><strong>What MAS did:</strong> Secured the BIDA branch office approval, completed the supporting registrations and licensing, arranged work permit recommendations for foreign staff placed in Bangladesh, and supported banking and office setup, with ongoing compliance help after opening.</p>
          <p><strong>Outcome:</strong> An approved branch office with staff placed compliantly and local support still on hand.</p>
        </article>
      </div>
    </div>
  </section>

<?php
cta_band(
    'Want Results Like These?',
    'Tell us what you\'re planning — a tender, a website, or a full market entry — and we\'ll reply with the next steps.'
);
site_footer();
