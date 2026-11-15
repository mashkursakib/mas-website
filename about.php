<?php
require_once __DIR__ . '/includes/layout.php';
$site  = load_site();
$about = $site['about'] ?? [];

page_head([
    'title'       => 'About MAS Group | Built for International Business',
    'description' => 'Founded in 2021, MAS Group is three specialized firms — e-procurement, web & IT, and market entry — working as one accountable team.',
    'canonical'   => 'https://masconsultancy.org/about.php',
]);
site_header('about', true);
?>

  <!-- ============ PAGE HERO ============ -->
  <section class="page-hero">
    <div class="container">
      <p class="eyebrow eyebrow-light">About MAS Group</p>
      <h1>A Team Built for International Business</h1>
      <p>Founded in 2021, MAS Group helps companies from the United States and 20+ countries set up, get online, and win government work in Bangladesh.</p>
    </div>
  </section>

  <!-- ============ STORY ============ -->
  <section class="section">
    <div class="container about-grid">
      <div class="about-media reveal">
        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=800&q=80" alt="MAS Group team at work" loading="lazy">
        <div class="about-badge-card">
          <span class="about-badge-year"><?php echo e($about['badge_year'] ?? ''); ?></span>
          <span class="about-badge-text"><?php echo e_nl($about['badge_text'] ?? ''); ?></span>
        </div>
      </div>
      <div class="about-copy reveal">
        <p class="eyebrow">Our Story</p>
        <h2 class="section-title">Why MAS Exists</h2>
        <p>Bangladesh offers international businesses a large, skilled workforce, competitive operating costs, and one of the world&apos;s fastest-growing domestic markets. It also has its own procurement systems, licensing rules, and business culture.</p>
        <p>MAS exists to bridge that gap. Our clients keep their focus on strategy and growth while we handle registration, compliance, technology, and day-to-day execution locally — through three firms, each run by specialists, with a single point of contact across the group.</p>
        <p>Our head office is at 73, Eastern Commercial Complex, Kakrail, Dhaka, and our team of 30+ professionals serves 52+ US clients and businesses from 20+ countries.</p>
        <a href="contact-us.php" class="btn btn-primary">Work With Us</a>
      </div>
    </div>
  </section>

  <!-- ============ MISSION & VISION ============ -->
  <section class="section section-alt">
    <div class="container">
      <div class="section-head reveal">
        <p class="eyebrow">What Drives Us</p>
        <h2 class="section-title">Mission &amp; Vision</h2>
      </div>
      <div class="duo-grid">
        <article class="card reveal">
          <div class="card-icon" aria-hidden="true">🎯</div>
          <h3>Our Mission</h3>
          <p>To help international companies set up, get online, and win government work in Bangladesh through one accountable local partner.</p>
        </article>
        <article class="card reveal">
          <div class="card-icon" aria-hidden="true">🌅</div>
          <h3>Our Vision</h3>
          <p>A Bangladesh where any international business can establish and grow with confidence.</p>
        </article>
      </div>
    </div>
  </section>

  <!-- ============ FIRMS (interactive tabs) ============ -->
  <section class="section" id="firms">
    <div class="container">
      <div class="section-head reveal">
        <p class="eyebrow">Our Firms</p>
        <h2 class="section-title">Three Firms, One Standard of Excellence</h2>
        <p class="section-sub">Each firm leads its own domain — pick one to see what it delivers.</p>
      </div>
      <div class="tabs reveal" role="tablist" aria-label="MAS Group firms">
        <button class="tab-btn active" role="tab" aria-selected="true" data-tab="firm-corp">MAS Corporation</button>
        <button class="tab-btn" role="tab" aria-selected="false" data-tab="firm-comm">MAS Communication</button>
        <button class="tab-btn" role="tab" aria-selected="false" data-tab="firm-cons">MAS Consultancy</button>
      </div>
      <div class="tab-panels reveal">
        <article class="tab-panel active" id="firm-corp" role="tabpanel">
          <div class="tab-panel-text">
            <p class="tab-kicker">E-Procurement</p>
            <h3>For Companies That Want Public-Sector Work</h3>
            <p>MAS Corporation is the group&apos;s procurement practice. Its team tracks Bangladesh&apos;s public tender portals, screens every opportunity against what a client can genuinely deliver, and prepares bids that are compliant, realistically priced, and submitted early — so clients never have to learn the e-GP system themselves.</p>
            <a href="e-procurement.php" class="text-link">Explore e-procurement &rarr;</a>
          </div>
          <div class="tab-panel-metric"><span>86%</span> bid success rate</div>
        </article>
        <article class="tab-panel" id="firm-comm" role="tabpanel">
          <div class="tab-panel-text">
            <p class="tab-kicker">Web &amp; IT</p>
            <h3>For Companies That Need a Digital Presence That Works</h3>
            <p>MAS Communication designs, builds, and looks after websites and web applications for clients in Bangladesh and abroad. One team takes a client from first brief to a live, searchable website — and stays responsible for it afterwards, so the site keeps working and improving long after launch day.</p>
            <a href="web-it.php" class="text-link">Explore web &amp; IT &rarr;</a>
          </div>
          <div class="tab-panel-metric"><span>20+</span> countries served</div>
        </article>
        <article class="tab-panel" id="firm-cons" role="tabpanel">
          <div class="tab-panel-text">
            <p class="tab-kicker">Market Entry</p>
            <h3>For Companies Setting Up in Bangladesh</h3>
            <p>MAS Consultancy takes foreign companies from first meeting to fully operational in six guided steps — registration, approvals, licensing, office, staffing, and banking — plus ongoing support once the operation is running. The client deals with one local team that knows which approval comes before which.</p>
            <a href="market-entry.php" class="text-link">See how market entry works &rarr;</a>
          </div>
          <div class="tab-panel-metric"><span>6 steps</span> to fully operational</div>
        </article>
      </div>
    </div>
  </section>

  <!-- ============ HOW WE WORK ============ -->
  <section class="section section-alt">
    <div class="container">
      <div class="section-head reveal">
        <p class="eyebrow">How We Work</p>
        <h2 class="section-title">Working With MAS, Day to Day</h2>
        <p class="section-sub">Four habits that shape every engagement across the group.</p>
      </div>
      <div class="cards-grid">
        <article class="card reveal">
          <div class="card-icon" aria-hidden="true">✉️</div>
          <h3>English-First Communication</h3>
          <p>Written updates, video calls, and documented decisions on every engagement — no ambiguity about what was agreed.</p>
        </article>
        <article class="card reveal">
          <div class="card-icon" aria-hidden="true">🤝</div>
          <h3>One Accountable Contact</h3>
          <p>A single team coordinates all three firms on your behalf, so you never chase different people for different work.</p>
        </article>
        <article class="card reveal">
          <div class="card-icon" aria-hidden="true">🕐</div>
          <h3>Working-Hours Overlap</h3>
          <p>Schedules aligned for live conversation with US, European, and Middle East clients — not just end-of-day emails.</p>
        </article>
      </div>
      <div class="cards-grid" style="margin-top: 24px;">
        <article class="card reveal">
          <div class="card-icon" aria-hidden="true">📊</div>
          <h3>Transparent Reporting</h3>
          <p>Clear milestones, deliverables, and performance reporting throughout — you always know where a project stands.</p>
        </article>
        <article class="card reveal">
          <div class="card-icon" aria-hidden="true">🏆</div>
          <h3>175+ Projects Delivered</h3>
          <p>Tenders won, websites launched, and companies set up across 20+ countries — the work speaks for itself.</p>
          <a href="portfolio.php" class="text-link">See the work &rarr;</a>
        </article>
        <article class="card reveal">
          <div class="card-icon" aria-hidden="true">📈</div>
          <h3>Business Development, Handled Locally</h3>
          <p>B2B lead generation, LinkedIn outreach, and appointment setting from our team, so pipeline-building continues alongside setup and operations.</p>
        </article>
      </div>
    </div>
  </section>

<?php
cta_band(
    'Let\'s Talk About Your Project',
    'Tell us what you\'re planning in Bangladesh — a tender, a website, or a full market entry — and we\'ll reply with the next steps.'
);
site_footer();
