<?php
require_once __DIR__ . '/includes/layout.php';

page_head([
    'title'       => 'Services | MAS Group — E-Procurement, Web & IT, Market Entry, Lead Generation',
    'description' => 'Seven service lines across the MAS Group: e-procurement management, web & app development, foreign business setup, IT infrastructure, security & compliance, digital transformation, and B2B lead generation.',
    'canonical'   => 'https://masconsultancy.org/services.php',
]);
site_header('services', true);
?>

  <!-- ============ PAGE HERO ============ -->
  <section class="page-hero">
    <div class="container">
      <p class="eyebrow eyebrow-light">What We Do</p>
      <h1>Services Across the MAS Group</h1>
      <p>Seven service lines, three specialist firms, one accountable team. Every service below is delivered by the firm that does that work all day, every day.</p>
    </div>
  </section>

  <!-- ============ SERVICE LINES ============ -->
  <section class="section">
    <div class="container">
      <div class="cards-grid">
        <article class="card reveal" id="procurement">
          <div class="card-icon" aria-hidden="true">📋</div>
          <p class="card-kicker">MAS Corporation &middot; E-Procurement</p>
          <h3>Government &amp; Corporate Procurement</h3>
          <p>We manage the full public procurement process — tracking tenders, screening opportunities against what you can genuinely deliver, preparing compliant bids, and submitting early. Clients get a shortlist of tenders they can win, not a pile of notices.</p>
          <ul class="check-list">
            <li>e-GP &amp; CPTU portal registration</li>
            <li>Tender tracking &amp; shortlists</li>
            <li>Bid preparation &amp; BOQ pricing</li>
            <li>Compliance review before submission</li>
          </ul>
          <a href="e-procurement.php" class="text-link">Deep dive &rarr;</a>
        </article>
        <article class="card reveal" id="webdev">
          <div class="card-icon" aria-hidden="true">💻</div>
          <p class="card-kicker">MAS Communication &middot; Web &amp; IT</p>
          <h3>Custom Web &amp; App Development</h3>
          <p>Corporate websites, online stores, enterprise portals, and mobile apps — designed for your brand and audience, built cleanly, and supported after launch. Your team can update content through a straightforward admin panel.</p>
          <ul class="check-list">
            <li>Custom design, no generic templates</li>
            <li>CMS with admin panel &amp; blog</li>
            <li>On-page SEO built in</li>
            <li>Maintenance &amp; support after launch</li>
          </ul>
          <a href="web-it.php" class="text-link">Deep dive &rarr;</a>
        </article>
        <article class="card reveal" id="setup">
          <div class="card-icon" aria-hidden="true">🌏</div>
          <p class="card-kicker">MAS Consultancy &middot; Market Entry</p>
          <h3>Foreign Business Setup in Bangladesh</h3>
          <p>One guided sequence takes you from first meeting to fully operational: registration, approvals, licensing, office, staffing, and banking. One local team knows which approval comes before which, so nothing stalls.</p>
          <ul class="check-list">
            <li>RJSC registration &amp; BIDA approval</li>
            <li>Trade licence, TIN &amp; VAT</li>
            <li>Corporate bank account support</li>
            <li>Office setup &amp; local staffing</li>
          </ul>
          <a href="market-entry.php" class="text-link">Deep dive &rarr;</a>
        </article>
        <article class="card reveal" id="infrastructure">
          <div class="card-icon" aria-hidden="true">🖥️</div>
          <p class="card-kicker">MAS Communication &middot; Infrastructure</p>
          <h3>IT Infrastructure &amp; Cloud</h3>
          <p>Network design, server management, and cloud migration for Bangladesh operations — set up properly from day one, then monitored and supported so your team is never stuck waiting on IT.</p>
          <ul class="check-list">
            <li>Network &amp; server setup</li>
            <li>Cloud migration</li>
            <li>Ongoing monitoring &amp; support</li>
            <li>Local IT help for your office</li>
          </ul>
          <a href="contact-us.php" class="text-link">Talk to us &rarr;</a>
        </article>
        <article class="card reveal" id="security">
          <div class="card-icon" aria-hidden="true">🔒</div>
          <p class="card-kicker">MAS Communication &middot; Security</p>
          <h3>Security &amp; Compliance</h3>
          <p>We find the gaps before anyone else does: audits, vulnerability assessments, data protection work, and training for your team — all shaped around Bangladesh regulatory requirements.</p>
          <ul class="check-list">
            <li>Cybersecurity audits</li>
            <li>Data protection compliance</li>
            <li>Vulnerability assessments</li>
            <li>Security training for staff</li>
          </ul>
          <a href="contact-us.php" class="text-link">Talk to us &rarr;</a>
        </article>
        <article class="card reveal" id="transformation">
          <div class="card-icon" aria-hidden="true">📊</div>
          <p class="card-kicker">MAS Consultancy &middot; Strategy</p>
          <h3>Digital Transformation Advisory</h3>
          <p>Before you buy software or rebuild systems, know what you actually need. We review where you are, map where technology helps, and plan the change in steps your team can absorb.</p>
          <ul class="check-list">
            <li>Current-state review</li>
            <li>Technology roadmap</li>
            <li>Process digitization</li>
            <li>Vendor &amp; tool selection</li>
          </ul>
          <a href="contact-us.php" class="text-link">Talk to us &rarr;</a>
        </article>
        <article class="card reveal" id="lead-generation">
          <div class="card-icon" aria-hidden="true">🎯</div>
          <p class="card-kicker">MAS Consultancy &middot; Business Development</p>
          <h3>B2B Lead Generation &amp; Appointment Setting</h3>
          <p>Our team builds your sales pipeline while you run the business: targeted prospect research, LinkedIn outreach, and appointment setting — delivered to agreed targets, with regular reporting on every campaign.</p>
          <ul class="check-list">
            <li>Targeted prospect lists</li>
            <li>LinkedIn outreach</li>
            <li>Appointment setting</li>
            <li>Pipeline reporting</li>
          </ul>
          <a href="contact-us.php" class="text-link">Talk to us &rarr;</a>
        </article>
      </div>
    </div>
  </section>

  <!-- ============ CHALLENGES (interactive) ============ -->
  <section class="section section-dark" id="concerns">
    <div class="container">
      <div class="section-head reveal">
        <p class="eyebrow eyebrow-light">Challenges We Solve</p>
        <h2 class="section-title section-title-light">The Problems We Remove for You</h2>
        <p class="section-sub section-sub-light">Select a challenge to see how the MAS Group handles it.</p>
      </div>
      <div class="concerns-wrap reveal">
        <div class="concerns-list" role="tablist" aria-label="Business challenges">
          <button class="concern-btn active" role="tab" aria-selected="true" data-concern="c1"><span aria-hidden="true">📋</span> Complex procurement processes</button>
          <button class="concern-btn" role="tab" aria-selected="false" data-concern="c2"><span aria-hidden="true">📈</span> Foreign business entry barriers</button>
          <button class="concern-btn" role="tab" aria-selected="false" data-concern="c3"><span aria-hidden="true">🌐</span> Digital presence &amp; technology gaps</button>
          <button class="concern-btn" role="tab" aria-selected="false" data-concern="c4"><span aria-hidden="true">🛡️</span> IT security &amp; compliance risks</button>
          <button class="concern-btn" role="tab" aria-selected="false" data-concern="c5"><span aria-hidden="true">👥</span> Local talent &amp; staffing</button>
          <button class="concern-btn" role="tab" aria-selected="false" data-concern="c6"><span aria-hidden="true">💰</span> Cost &amp; vendor management</button>
        </div>
        <div class="concerns-detail">
          <article class="concern-panel active" id="c1" role="tabpanel">
            <p class="concern-tag">E-Procurement</p>
            <h3>Government tendering looks complex from the outside</h3>
            <p>Portals, eligibility rules, deposits, deadlines — and one missing paper can disqualify an otherwise winning bid. We screen every opportunity before you spend time on it, prepare the full document set, verify compliance twice, and submit early. You get a shortlist of tenders you can genuinely win.</p>
            <a href="e-procurement.php" class="btn btn-outline-light btn-sm">See the process</a>
          </article>
          <article class="concern-panel" id="c2" role="tabpanel">
            <p class="concern-tag">Operational Support</p>
            <h3>Setting up abroad means registrars, approvals, and banks</h3>
            <p>Each step depends on the one before it, and the sequence is rarely obvious from overseas. We run the full setup in six guided steps — registration, approvals, licensing, office, staffing, banking — so your team can focus on the business, not the bureaucracy.</p>
            <a href="market-entry.php" class="btn btn-outline-light btn-sm">See the 6 steps</a>
          </article>
          <article class="concern-panel" id="c3" role="tabpanel">
            <p class="concern-tag">Web Development</p>
            <h3>A website that brings no enquiries is just a brochure</h3>
            <p>We build sites around what they have to achieve — enquiries, sales, credibility — then design, build, and maintain them. Every build is responsive, structured for search engines, and fast, and your team can update it without developer help.</p>
            <a href="web-it.php" class="btn btn-outline-light btn-sm">See web services</a>
          </article>
          <article class="concern-panel" id="c4" role="tabpanel">
            <p class="concern-tag">Cyber Security</p>
            <h3>Security gaps usually surface at the worst moment</h3>
            <p>We audit your systems, fix what we find, and train your team — with data protection and compliance work shaped around Bangladesh regulations, so risks are handled before they become incidents.</p>
            <a href="contact-us.php" class="btn btn-outline-light btn-sm">Talk to us</a>
          </article>
          <article class="concern-panel" id="c5" role="tabpanel">
            <p class="concern-tag">Operational Support</p>
            <h3>Hiring in a market you don&apos;t know is slow — and a wrong hire costs months</h3>
            <p>We handle the search, screening, and onboarding through our local network, including work permit recommendations for foreign staff you place in Bangladesh. You meet shortlisted candidates; we handle the rest.</p>
            <a href="market-entry.php" class="btn btn-outline-light btn-sm">See how we hire</a>
          </article>
          <article class="concern-panel" id="c6" role="tabpanel">
            <p class="concern-tag">IT Advisory</p>
            <h3>Too many vendors, unclear costs, no single picture</h3>
            <p>We review what you have, plan what you actually need, and manage the vendors — so you invest in the right tools, at the right price, with clear reporting instead of surprises.</p>
            <a href="contact-us.php" class="btn btn-outline-light btn-sm">Talk to us</a>
          </article>
        </div>
      </div>
    </div>
  </section>

  <!-- ============ HOW WE WORK ============ -->
  <section class="section">
    <div class="container">
      <div class="section-head reveal">
        <p class="eyebrow">How We Work</p>
        <h2 class="section-title">Three Steps to Getting Started</h2>
        <p class="section-sub">No long sales process — a conversation, a plan, then delivery.</p>
      </div>
      <div class="process-grid">
        <div class="process-step reveal"><span class="process-num">01</span><h3>Tell Us the Goal</h3><p>A message, a call, or the contact form. We reply within 24 hours on business days with next steps and any questions.</p></div>
        <div class="process-step reveal"><span class="process-num">02</span><h3>We Plan and Deliver</h3><p>One team, clear milestones, and written updates as the work moves — whether it&apos;s a tender, a website, or a full setup.</p></div>
        <div class="process-step reveal"><span class="process-num">03</span><h3>We Stay On</h3><p>Support, reporting, and improvements after delivery — because a launch, a bid, or a registration is a starting point, not the finish.</p></div>
      </div>
    </div>
  </section>

<?php
cta_band(
    'Not Sure Which Service Fits?',
    'Tell us what you\'re trying to achieve and we\'ll point you to the right firm — or the right combination of them.'
);
site_footer();
