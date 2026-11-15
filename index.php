<?php
require_once __DIR__ . '/includes/layout.php';
$site    = load_site();
$posts   = load_posts();
$hero    = $site['hero'] ?? [];
$stats   = $site['stats'] ?? [];
$contact = $site['contact'] ?? [];

$jsonLd = '
  <meta name="keywords" content="MAS Consultancy, MAS Corporation, Bangladesh e-procurement, web development Dhaka, business setup Bangladesh, US businesses Bangladesh">
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "MAS Consultancy",
    "url": "https://masconsultancy.org",
    "logo": "https://masconsultancy.org/logo.png",
    "description": "Licensed group of companies under MAS Corporation: e-procurement, web & IT, and foreign business setup in Bangladesh.",
    "foundingDate": "2021",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "' . e(str_replace("\n", ", ", $contact['address'] ?? '')) . '",
      "addressLocality": "Dhaka",
      "addressCountry": "BD"
    },
    "contactPoint": {
      "@type": "ContactPoint",
      "telephone": "' . e($contact['phone_tel'] ?? '') . '",
      "email": "' . e($contact['email1'] ?? '') . '",
      "contactType": "customer service",
      "hoursAvailable": "Su-Th 09:00-18:00"
    },
    "sameAs": ["https://wa.me/' . e($contact['whatsapp'] ?? '') . '"]
  }
  </script>';

page_head([
    'title'       => 'MAS Consultancy | E-Procurement, Web Development & Bangladesh Business Setup',
    'description' => 'MAS Consultancy — Licensed under MAS Corporation. Three specialized firms for e-procurement, IT & web development, and Bangladesh market entry. Serving US businesses since 2021.',
    'canonical'   => 'https://masconsultancy.org/',
    'extra'       => $jsonLd,
]);
site_header('home');
?>

  <!-- ============ HERO ============ -->
  <section class="hero" id="hero">
    <div class="hero-content">
      <p class="hero-badge"><span class="badge-dot"></span> <?php echo e($hero['badge'] ?? ''); ?></p>
      <h1 class="hero-title"><?php echo e($hero['title'] ?? ''); ?> <span class="hero-title-accent"><?php echo e($hero['accent'] ?? ''); ?></span></h1>
      <p class="hero-subtitle"><?php echo rich($hero['subtitle'] ?? ''); ?></p>
      <div class="hero-actions">
        <a href="services.php" class="btn btn-primary">Explore Our Services</a>
        <a href="contact-us.php" class="btn btn-outline">Get in Touch</a>
      </div>
      <div class="hero-proof">
        <span class="hero-stars" aria-label="5 out of 5 stars">★★★★★</span>
        <span>Trusted by 52+ US clients &middot; Since 2021</span>
      </div>
      <div class="hero-meta">
        <?php foreach (($hero['meta'] ?? []) as $item): ?>
        <span><b><?php echo e($item['value'] ?? ''); ?></b> <?php echo e($item['label'] ?? ''); ?></span>
        <?php endforeach; ?>
      </div>
    </div>
    <figure class="hero-figure">
      <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1800&q=80" alt="Modern business district">
      <figcaption class="hero-chip">
        <span class="hero-chip-num"><?php echo e($hero['chip_value'] ?? ''); ?></span>
        <span class="hero-chip-text"><?php echo e_nl($hero['chip_text'] ?? ''); ?></span>
      </figcaption>
    </figure>
  </section>

  <!-- ============ MARQUEE ============ -->
  <div class="marquee" aria-hidden="true">
    <div class="marquee-track">
      <span>E-Procurement</span><span>Web Development</span><span>Business Setup</span><span>IT Infrastructure</span><span>Security &amp; Compliance</span><span>Digital Transformation</span><span>E-Procurement</span><span>Web Development</span><span>Business Setup</span><span>IT Infrastructure</span><span>Security &amp; Compliance</span><span>Digital Transformation</span>
    </div>
  </div>

  <!-- ============ STATS ============ -->
  <section class="stats-band" aria-label="Key figures">
    <div class="container stats-grid">
      <?php foreach ($stats as $stat): ?>
      <div class="stat reveal">
        <span class="stat-number"><span class="counter" data-target="<?php echo (int) ($stat['value'] ?? 0); ?>">0</span><?php echo e($stat['suffix'] ?? ''); ?></span>
        <span class="stat-label"><?php echo e($stat['label'] ?? ''); ?></span>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- ============ ABOUT TEASER ============ -->
  <section class="section" id="about">
    <div class="container">
      <div class="section-head reveal">
        <p class="eyebrow">About Us</p>
        <h2 class="section-title">One Group. Three Specialized Firms. <span class="accent">Complete Solutions.</span></h2>
        <p class="section-sub">Three specialised firms, 175+ projects delivered. Each one leads its own field — and one team coordinates all three for you, so you deal with a single partner from first conversation to finished work.</p>
      </div>
      <div class="cards-grid">
        <article class="card reveal">
          <div class="card-icon" aria-hidden="true">📋</div>
          <p class="card-kicker">MAS Corporation &middot; E-Procurement</p>
          <h3>Government Tenders, Handled End to End</h3>
          <p>We find the tenders worth bidding on, prepare compliant bids, and submit early.</p>
          <a href="e-procurement.php" class="text-link">Meet the firm &rarr;</a>
        </article>
        <article class="card reveal">
          <div class="card-icon" aria-hidden="true">💻</div>
          <p class="card-kicker">MAS Communication &middot; Web &amp; IT</p>
          <h3>Websites and Web Apps, Built and Maintained</h3>
          <p>Business sites, online stores, and custom systems — designed, built, and looked after.</p>
          <a href="web-it.php" class="text-link">Meet the firm &rarr;</a>
        </article>
        <article class="card reveal">
          <div class="card-icon" aria-hidden="true">🌏</div>
          <p class="card-kicker">MAS Consultancy &middot; Market Entry</p>
          <h3>Foreign Companies Set Up and Running</h3>
          <p>Registration, approvals, banking, office, and staffing — one guided sequence.</p>
          <a href="market-entry.php" class="text-link">Meet the firm &rarr;</a>
        </article>
      </div>
      <div class="center reveal">
        <a href="about.php" class="btn btn-outline">More About the Group &rarr;</a>
      </div>
    </div>
  </section>

  <!-- ============ SERVICES TEASER ============ -->
  <section class="section section-alt" id="services">
    <div class="container">
      <div class="section-head reveal">
        <p class="eyebrow">What We Do</p>
        <h2 class="section-title">Services Built Around Your Business</h2>
        <p class="section-sub">Seven service lines across the MAS Group — from winning government tenders to building your sales pipeline in Bangladesh.</p>
      </div>
      <div class="cards-grid">
        <article class="card reveal">
          <div class="card-icon" aria-hidden="true">📋</div>
          <h3>E-Procurement</h3>
          <p>Tenders found, bids prepared, contracts won.</p>
          <a href="services.php#procurement" class="text-link">Learn more &rarr;</a>
        </article>
        <article class="card reveal">
          <div class="card-icon" aria-hidden="true">💻</div>
          <h3>Web &amp; App Development</h3>
          <p>Business sites, stores, and web apps that convert.</p>
          <a href="services.php#webdev" class="text-link">Learn more &rarr;</a>
        </article>
        <article class="card reveal">
          <div class="card-icon" aria-hidden="true">🌏</div>
          <h3>Business Setup</h3>
          <p>Registered, licensed, and trading — without the runaround.</p>
          <a href="services.php#setup" class="text-link">Learn more &rarr;</a>
        </article>
        <article class="card reveal">
          <div class="card-icon" aria-hidden="true">🖥️</div>
          <h3>IT Infrastructure &amp; Cloud</h3>
          <p>Networks, servers, and cloud that stay up.</p>
          <a href="services.php#infrastructure" class="text-link">Learn more &rarr;</a>
        </article>
        <article class="card reveal">
          <div class="card-icon" aria-hidden="true">🔒</div>
          <h3>Security &amp; Compliance</h3>
          <p>Audits, protection, and training for local rules.</p>
          <a href="services.php#security" class="text-link">Learn more &rarr;</a>
        </article>
        <article class="card reveal">
          <div class="card-icon" aria-hidden="true">📊</div>
          <h3>Digital Transformation</h3>
          <p>A clear plan for going digital — then the build.</p>
          <a href="services.php#transformation" class="text-link">Learn more &rarr;</a>
        </article>
      </div>
      <div class="center reveal">
        <a href="services.php" class="btn btn-outline">All Services &rarr;</a>
      </div>
    </div>
  </section>

  <!-- ============ WHY MAS ============ -->
  <section class="section" id="why-mas">
    <div class="container">
      <div class="split-grid">
        <div class="split-copy reveal">
          <p class="eyebrow">Why MAS Group</p>
          <h2 class="section-title">One Partner for Three Jobs at Once</h2>
          <p>Most international companies entering Bangladesh need three things at the same time: a legal local presence, a credible digital presence, and access to public sector work. MAS Group is built so one partner covers all three — you never have to find, brief, and manage three separate providers, or carry the gaps between them.</p>
          <ul class="check-list">
            <li><strong>Specialists, not generalists.</strong> Every engagement is handled by the firm that does that work all day, every day.</li>
            <li><strong>A track record you can check.</strong> Tenders won, websites launched, companies set up — see the results on our <a href="portfolio.php">Portfolio page</a>.</li>
            <li><strong>Built for international clients.</strong> English-first communication, written updates, and schedules aligned for live conversation across US, European, and Middle East time zones.</li>
          </ul>
          <a href="about.php" class="btn btn-primary">How We Work</a>
        </div>
        <div class="split-media reveal">
          <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&q=80" alt="MAS Group team collaborating" loading="lazy">
        </div>
      </div>
    </div>
  </section>

  <!-- ============ NEWS PREVIEW ============ -->
  <section class="section section-alt" id="news">
    <div class="container">
      <div class="section-head reveal">
        <p class="eyebrow">News &amp; Insights</p>
        <h2 class="section-title">Latest from MAS Group</h2>
      </div>
      <div id="newsPreview" class="news-grid reveal">
        <?php if ($posts): ?>
          <?php foreach (array_slice($posts, 0, 3) as $post): ?>
          <?php echo post_card_html($post); ?>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="empty-state" style="grid-column: 1 / -1;">
            <div class="empty-icon" aria-hidden="true">📰</div>
            <h2>No posts yet</h2>
            <p>News and updates will appear here once published. Check back soon — or subscribe below and we&apos;ll send them to you.</p>
          </div>
        <?php endif; ?>
      </div>
      <div class="center reveal">
        <a href="blog.php" class="btn btn-outline">Visit Blog Page &rarr;</a>
      </div>
    </div>
  </section>

<?php
newsletter_block();
site_footer();
