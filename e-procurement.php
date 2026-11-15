<?php
require_once __DIR__ . '/includes/layout.php';

page_head([
    'title'       => 'E-Procurement in Bangladesh | MAS Corporation — 86% Bid Success',
    'description' => 'MAS Corporation manages the full public procurement process in Bangladesh — tender tracking, eligibility checks, BOQ pricing, double-verified compliance and early submission, with an 86% bid success rate across 175+ projects.',
    'canonical'   => 'https://masconsultancy.org/e-procurement.php',
]);
site_header('e-procurement', true);
?>

  <!-- ============ PAGE HERO ============ -->
  <section class="page-hero">
    <div class="container">
      <p class="eyebrow eyebrow-light">MAS Corporation &middot; E-Procurement</p>
      <h1>Win Government &amp; Corporate Tenders</h1>
      <p>MAS Corporation manages the full public procurement process in Bangladesh for its clients — from finding the right tender to submitting a compliant, realistically priced bid.</p>
    </div>
  </section>

  <!-- ============ INTRO ============ -->
  <section class="section">
    <div class="container">
      <div class="split-grid">
        <div class="split-copy reveal">
          <p class="eyebrow">How It Works</p>
          <h2 class="section-title">A Disciplined Sequence, on Every Tender</h2>
          <p>Bangladesh&apos;s e-procurement ecosystem — managed through CPTU and e-GP platforms — is the gateway to billions in government contracts. But winning takes more than spotting a notice: eligibility, pricing, paperwork, and timing all have to be right.</p>
          <p>Our specialist team runs the same disciplined sequence on every tender — track, check eligibility, review, price, verify, submit early — and sustains an <strong>86% bid success rate across 175+ projects</strong>. Clients don&apos;t need to learn the e-GP system, chase deadlines, or risk disqualification on a technicality.</p>
          <a href="contact-us.php" class="btn btn-primary">Discuss Your Next Tender</a>
        </div>
        <div class="split-media reveal">
          <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&q=80" alt="E-procurement analytics dashboard" loading="lazy">
          <div class="media-stat"><span>86%</span> Bid Success Rate</div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============ WHAT WE DO IN DETAIL ============ -->
  <section class="section section-alt">
    <div class="container">
      <div class="section-head reveal">
        <p class="eyebrow">What We Do, in Detail</p>
        <h2 class="section-title">Six Things That Decide a Bid</h2>
      </div>
      <div class="process-grid">
        <div class="process-step reveal"><span class="process-num">01</span><h3>Tender Tracking</h3><p>Continuous monitoring of Bangladesh&apos;s public procurement portals, so suitable opportunities are never missed.</p></div>
        <div class="process-step reveal"><span class="process-num">02</span><h3>Eligibility Checks</h3><p>Every opportunity is screened against your licences, experience, and capacity before any time or money is spent on a bid.</p></div>
        <div class="process-step reveal"><span class="process-num">03</span><h3>Full Document Review</h3><p>Tender documents are reviewed in full and turned into clear checklists, so every requirement is visible and nothing is left to assumption.</p></div>
        <div class="process-step reveal"><span class="process-num">04</span><h3>Realistic BOQ Pricing</h3><p>Prices are built from the bill of quantities and actual costs — bids that are competitive and deliverable, not guesswork.</p></div>
        <div class="process-step reveal"><span class="process-num">05</span><h3>Compliance Verified Twice</h3><p>Licences, certificates, and bank documents are checked twice before submission, because a single missing paper can disqualify an otherwise winning bid.</p></div>
        <div class="process-step reveal"><span class="process-num">06</span><h3>Early Submission</h3><p>Bids go in well before the deadline, leaving room to resolve any portal or document issue without risk.</p></div>
      </div>
    </div>
  </section>

  <!-- ============ PORTALS / CONTRACTS / SECTORS ============ -->
  <section class="section">
    <div class="container">
      <div class="section-head reveal">
        <p class="eyebrow">Coverage</p>
        <h2 class="section-title">Portals, Contracts &amp; Sectors</h2>
      </div>
      <div class="split-grid">
        <div class="reveal">
          <div class="portals">
            <p class="portals-title">Portals we work with</p>
            <ul class="chip-list">
              <li>e-GP Bangladesh <span>Government Portal</span></li>
              <li>CPTU <span>Central Procurement</span></li>
              <li>BMET Portal <span>Ministry of Labour</span></li>
              <li>DESCO Procurement <span>Utility Sector</span></li>
              <li>BIWTA <span>Transport Authority</span></li>
              <li>LGED Tender <span>Engineering Works</span></li>
            </ul>
          </div>
        </div>
        <div class="reveal">
          <div class="portals">
            <p class="portals-title">Contract types</p>
            <ul class="chip-list">
              <li>Works contracts</li>
              <li>Supply of goods</li>
              <li>Consultancy &amp; services</li>
            </ul>
          </div>
          <div class="portals" style="margin-top: 28px;">
            <p class="portals-title">Sectors covered</p>
            <ul class="chip-list">
              <li>Local government infrastructure</li>
              <li>Roads &amp; highways</li>
              <li>Water development</li>
              <li>Public health engineering</li>
              <li>Education &amp; health programmes</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

<?php
cta_band(
    'Have a Tender Coming Up?',
    'Send us the notice — or just tell us your sector — and we\'ll tell you honestly whether it\'s one you can win.'
);
site_footer();
