<?php
require_once __DIR__ . '/includes/functions.php';
$site    = load_site();
$posts   = load_posts();
$hero    = $site['hero'] ?? [];
$stats   = $site['stats'] ?? [];
$contact = $site['contact'] ?? [];
$about   = $site['about'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MAS Consultancy | E-Procurement, Web Development & Bangladesh Business Setup</title>
  <meta name="description" content="MAS Consultancy — Licensed under MAS Corporation. Three specialized firms for e-procurement, IT & web development, and Bangladesh market entry. Serving US businesses since 2021.">
  <meta name="keywords" content="MAS Consultancy, MAS Corporation, Bangladesh e-procurement, web development Dhaka, business setup Bangladesh, US businesses Bangladesh">
  <meta name="author" content="MAS Consultancy">
  <meta name="theme-color" content="#faf8f2">
  <meta property="og:type" content="website">
  <meta property="og:title" content="MAS Consultancy | E-Procurement, Web Development & Bangladesh Business Setup">
  <meta property="og:description" content="One group, complete solutions. E-procurement, web & IT, and foreign business setup in Bangladesh — trusted by 52+ US clients since 2021.">
  <meta property="og:url" content="https://masconsultancy.org/">
  <meta property="og:image" content="https://masconsultancy.org/logo.png">
  <link rel="icon" type="image/png" href="logo.png">
  <link rel="canonical" href="https://masconsultancy.org/">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,400;1,9..144,500;1,9..144,600&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
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
      "streetAddress": "<?php echo e(str_replace("\n", ", ", $contact['address'] ?? '')); ?>",
      "addressLocality": "Dhaka",
      "addressCountry": "BD"
    },
    "contactPoint": {
      "@type": "ContactPoint",
      "telephone": "<?php echo e($contact['phone_tel'] ?? ''); ?>",
      "email": "<?php echo e($contact['email1'] ?? ''); ?>",
      "contactType": "customer service",
      "hoursAvailable": "Su-Th 09:00-18:00"
    },
    "sameAs": ["https://wa.me/<?php echo e($contact['whatsapp'] ?? ''); ?>"]
  }
  </script>
</head>
<body>
  <a class="skip-link" href="#about">Skip to content</a>

  <!-- ============ NAVBAR ============ -->
  <header class="navbar" id="navbar">
    <div class="nav-inner">
      <a href="#" class="nav-logo" aria-label="MAS Consultancy — home">
        <img src="logo-wordmark.png" alt="MAS Consultancy" class="nav-wordmark" height="42">
      </a>
      <nav aria-label="Primary">
        <ul class="nav-links" id="navLinks">
          <li><a href="#about" data-spy="about">About</a></li>
          <li><a href="#services" data-spy="services">Services</a></li>
          <li><a href="#eprocurement" data-spy="eprocurement">E-Procurement</a></li>
          <li><a href="#webdev" data-spy="webdev">Web Dev</a></li>
          <li><a href="#operational" data-spy="operational">Market Entry</a></li>
          <li><a href="#portfolio" data-spy="portfolio">Portfolio</a></li>
          <li><a href="blog.php">Blog</a></li>
          <li><a href="#contact" class="nav-cta">Get in Touch</a></li>
        </ul>
      </nav>
      <button class="nav-hamburger" id="hamburger" aria-label="Open menu" aria-expanded="false" aria-controls="mobileMenu">
        <span></span><span></span><span></span>
      </button>
    </div>
  </header>

  <!-- Mobile drawer -->
  <div class="mobile-menu" id="mobileMenu" aria-hidden="true">
    <button class="mobile-close" id="mobileClose" aria-label="Close menu">&times;</button>
    <nav aria-label="Mobile">
      <a href="#about">About Us</a>
      <a href="#services">Services</a>
      <a href="#eprocurement">E-Procurement</a>
      <a href="#webdev">Web Development</a>
      <a href="#operational">Market Entry</a>
      <a href="#portfolio">Portfolio</a>
      <a href="blog.php">News &amp; Blog</a>
      <a href="#contact" class="mobile-cta">Get in Touch</a>
    </nav>
    <div class="mobile-contact">
      <a href="tel:<?php echo e($contact['phone_tel'] ?? ''); ?>"><?php echo e($contact['phone_display'] ?? ''); ?></a>
      <a href="mailto:<?php echo e($contact['email1'] ?? ''); ?>"><?php echo e($contact['email1'] ?? ''); ?></a>
    </div>
  </div>
  <div class="menu-overlay" id="menuOverlay"></div>

  <!-- ============ HERO ============ -->
  <section class="hero" id="hero">
    <div class="hero-content">
      <p class="hero-badge"><span class="badge-dot"></span> <?php echo e($hero['badge'] ?? ''); ?></p>
      <h1 class="hero-title"><?php echo e($hero['title'] ?? ''); ?> <span class="hero-title-accent"><?php echo e($hero['accent'] ?? ''); ?></span></h1>
      <p class="hero-subtitle"><?php echo rich($hero['subtitle'] ?? ''); ?></p>
      <div class="hero-actions">
        <a href="#services" class="btn btn-primary">Explore Our Services</a>
        <a href="#contact" class="btn btn-outline">Get in Touch</a>
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

  <!-- ============ ABOUT ============ -->
  <section class="section" id="about">
    <div class="container about-grid">
      <div class="about-media reveal">
        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=800&q=80" alt="MAS Group team at work" loading="lazy">
        <div class="about-badge-card">
          <span class="about-badge-year"><?php echo e($about['badge_year'] ?? ''); ?></span>
          <span class="about-badge-text"><?php echo e_nl($about['badge_text'] ?? ''); ?></span>
        </div>
      </div>
      <div class="about-copy reveal">
        <p class="eyebrow">About Us</p>
        <h2 class="section-title">One Group. Three Specialized Firms. <span class="accent">Complete Solutions.</span></h2>
        <p><strong>MAS Consultancy</strong> is a licensed group of companies under <strong>MAS Corporation</strong>, headquartered at 73, Eastern Commercial Complex, Kakrail, Dhaka, Bangladesh. Since 2021, the MAS Group has been the trusted partner for US and international businesses seeking excellence in <strong>e-procurement</strong>, digital transformation, and Bangladesh market entry.</p>
        <p>With a team of <strong>30+ professionals</strong>, our three sister concerns operate in dedicated domains — serving <strong>52+ US clients</strong> and businesses from <strong>20+ countries</strong>.</p>
        <ul class="about-points">
          <li><strong>86% bid success rate</strong> across 175+ completed projects</li>
          <li><strong>Preferred vendor</strong> for government and enterprise clients</li>
          <li><strong>Certified professionals</strong> across all IT and business disciplines</li>
        </ul>
        <a href="#contact" class="btn btn-primary">Work With Us</a>
      </div>
    </div>
  </section>

  <!-- ============ FIRMS (interactive tabs) ============ -->
  <section class="section section-alt" id="firms">
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
            <h3>Government &amp; Corporate Procurement</h3>
            <p>End-to-end e-procurement management — from tender registration and bid preparation to contract execution on CPTU, e-GP, and private portals. 86% bid success rate across 175+ projects.</p>
            <a href="#eprocurement" class="text-link">Explore e-procurement &rarr;</a>
          </div>
          <div class="tab-panel-metric"><span>86%</span> bid success rate</div>
        </article>
        <article class="tab-panel" id="firm-comm" role="tabpanel">
          <div class="tab-panel-text">
            <p class="tab-kicker">Web &amp; IT</p>
            <h3>Custom Web, Apps &amp; Infrastructure</h3>
            <p>Bespoke corporate websites, e-commerce platforms, enterprise portals, and mobile applications — plus IT infrastructure, cloud, and security — built for US and global businesses.</p>
            <a href="#webdev" class="text-link">Explore web &amp; IT &rarr;</a>
          </div>
          <div class="tab-panel-metric"><span>52+</span> US clients served</div>
        </article>
        <article class="tab-panel" id="firm-cons" role="tabpanel">
          <div class="tab-panel-text">
            <p class="tab-kicker">Market Entry</p>
            <h3>Foreign Business Setup in Bangladesh</h3>
            <p>Comprehensive support for US companies entering Bangladesh — company registration, BIDA approval, licensing, office setup, local staffing, and banking setup.</p>
            <a href="#operational" class="text-link">See how market entry works &rarr;</a>
          </div>
          <div class="tab-panel-metric"><span>30+</span> companies set up</div>
        </article>
      </div>
    </div>
  </section>

  <!-- ============ SERVICES ============ -->
  <section class="section" id="services">
    <div class="container">
      <div class="section-head reveal">
        <p class="eyebrow">What We Do</p>
        <h2 class="section-title">Services Built Around Your Business</h2>
        <p class="section-sub">Six service lines across the MAS Group — from winning government tenders to running your Bangladesh operation.</p>
      </div>
      <div class="cards-grid">
        <article class="card reveal">
          <div class="card-icon" aria-hidden="true">📋</div>
          <p class="card-kicker">MAS Corporation &middot; E-Procurement</p>
          <h3>Government &amp; Corporate Procurement</h3>
          <p>End-to-end e-procurement management — from tender registration and bid preparation to contract execution on CPTU, e-GP, and private portals.</p>
          <a href="#eprocurement" class="text-link">Learn more &rarr;</a>
        </article>
        <article class="card reveal">
          <div class="card-icon" aria-hidden="true">💻</div>
          <p class="card-kicker">MAS Communication &middot; Web &amp; IT</p>
          <h3>Custom Web &amp; App Development</h3>
          <p>Bespoke corporate websites, e-commerce platforms, enterprise portals, and mobile applications built with cutting-edge technologies.</p>
          <a href="#webdev" class="text-link">Learn more &rarr;</a>
        </article>
        <article class="card reveal">
          <div class="card-icon" aria-hidden="true">🌏</div>
          <p class="card-kicker">MAS Consultancy &middot; Market Entry</p>
          <h3>Foreign Business Setup in Bangladesh</h3>
          <p>Company registration, BIDA approval, licensing, office setup, local staffing, and banking setup for US companies entering Bangladesh.</p>
          <a href="#operational" class="text-link">Learn more &rarr;</a>
        </article>
        <article class="card reveal">
          <div class="card-icon" aria-hidden="true">🖥️</div>
          <p class="card-kicker">MAS Communication &middot; Infrastructure</p>
          <h3>IT Infrastructure &amp; Cloud</h3>
          <p>Network design, server management, cloud migration, and IT infrastructure consulting for enterprise-grade reliability across Bangladesh operations.</p>
          <a href="#contact" class="text-link">Learn more &rarr;</a>
        </article>
        <article class="card reveal">
          <div class="card-icon" aria-hidden="true">🔒</div>
          <p class="card-kicker">MAS Communication &middot; Security</p>
          <h3>Security &amp; Compliance</h3>
          <p>Cybersecurity audits, data protection compliance, vulnerability assessments, and security training tailored to Bangladesh regulatory requirements.</p>
          <a href="#contact" class="text-link">Learn more &rarr;</a>
        </article>
        <article class="card reveal">
          <div class="card-icon" aria-hidden="true">📊</div>
          <p class="card-kicker">MAS Consultancy &middot; Strategy</p>
          <h3>Digital Transformation Advisory</h3>
          <p>Strategic roadmapping, technology selection, process digitization, and change management to accelerate your digital journey in the Bangladesh market.</p>
          <a href="#contact" class="text-link">Learn more &rarr;</a>
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
            <h3>How do we navigate Bangladesh's government e-procurement system?</h3>
            <p>We handle the entire e-procurement lifecycle on your behalf — from CPTU and e-GP portal registration, to bid document preparation, technical compliance, and contract negotiation. Our experts have managed <strong>175+ successful projects</strong> with an industry-leading <strong>86% bid success rate</strong>.</p>
            <a href="#eprocurement" class="btn btn-outline-light btn-sm">See the process</a>
          </article>
          <article class="concern-panel" id="c2" role="tabpanel">
            <p class="concern-tag">Operational Support</p>
            <h3>What does it take to set up a business in Bangladesh?</h3>
            <p>Registration, BIDA approval, trade licenses, TIN/BIN, office space, staffing, and banking — we manage the full setup in six guided steps, so your team can focus on the business, not the bureaucracy.</p>
            <a href="#operational" class="btn btn-outline-light btn-sm">See the 6 steps</a>
          </article>
          <article class="concern-panel" id="c3" role="tabpanel">
            <p class="concern-tag">Web Development</p>
            <h3>How do we build a digital presence that wins clients?</h3>
            <p>Corporate websites, e-commerce platforms, enterprise portals, and mobile apps — designed, built, and maintained by MAS Communication, optimized for speed, SEO, and conversions.</p>
            <a href="#webdev" class="btn btn-outline-light btn-sm">See web services</a>
          </article>
          <article class="concern-panel" id="c4" role="tabpanel">
            <p class="concern-tag">Cyber Security</p>
            <h3>How do we stay secure and compliant in Bangladesh?</h3>
            <p>Cybersecurity audits, data protection compliance, vulnerability assessments, and security training — tailored to Bangladesh regulatory requirements, with a 100% compliance rate across our engagements.</p>
            <a href="#contact" class="btn btn-outline-light btn-sm">Talk to us</a>
          </article>
          <article class="concern-panel" id="c5" role="tabpanel">
            <p class="concern-tag">Operational Support</p>
            <h3>How do we find the right people locally?</h3>
            <p>We recruit qualified local professionals — engineers, managers, analysts, and support staff — through our extensive professional network across Bangladesh's major business hubs.</p>
            <a href="#operational" class="btn btn-outline-light btn-sm">See how we hire</a>
          </article>
          <article class="concern-panel" id="c6" role="tabpanel">
            <p class="concern-tag">IT Advisory</p>
            <h3>How do we keep costs and vendors under control?</h3>
            <p>Strategic roadmapping, technology selection, and vendor management from our advisory team — so you invest in the right tools, at the right price, with no surprises.</p>
            <a href="#contact" class="btn btn-outline-light btn-sm">Talk to us</a>
          </article>
        </div>
      </div>
    </div>
  </section>

  <!-- ============ E-PROCUREMENT ============ -->
  <section class="section" id="eprocurement">
    <div class="container">
      <div class="split-grid">
        <div class="split-copy reveal">
          <p class="eyebrow">E-Procurement</p>
          <h2 class="section-title">Win Government &amp; Corporate Tenders with MAS Corporation</h2>
          <p><strong>MAS Corporation</strong> is the dedicated e-procurement arm of the MAS Group. Bangladesh's <strong>e-procurement</strong> ecosystem — managed through CPTU and e-GP platforms — is the gateway to billions in government contracts. Our specialist team maintains an <strong>86% bid success rate</strong> across 175+ completed projects.</p>
          <p>Whether you're a US multinational or a local enterprise, MAS Corporation provides the technical expertise, documentation support, and strategic guidance that transforms your <strong>procurement</strong> capability into a sustainable competitive advantage in the Bangladesh market.</p>
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
        <div class="split-media reveal">
          <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&q=80" alt="E-procurement analytics dashboard" loading="lazy">
          <div class="media-stat"><span>86%</span> Bid Success Rate</div>
        </div>
      </div>
      <div class="process-grid">
        <div class="process-step reveal"><span class="process-num">01</span><h3>e-GP Portal Registration</h3><p>Complete setup and verification on all government e-procurement portals.</p></div>
        <div class="process-step reveal"><span class="process-num">02</span><h3>Tender Identification</h3><p>Real-time monitoring and smart matching of tenders to your business profile.</p></div>
        <div class="process-step reveal"><span class="process-num">03</span><h3>Bid Document Preparation</h3><p>Expert preparation of technical and financial bids with full compliance review.</p></div>
        <div class="process-step reveal"><span class="process-num">04</span><h3>Technical Compliance</h3><p>Ensuring all submissions meet regulatory and procurement authority requirements.</p></div>
        <div class="process-step reveal"><span class="process-num">05</span><h3>Contract Negotiation</h3><p>Strategic negotiation support for award and post-award contract management.</p></div>
        <div class="process-step reveal"><span class="process-num">06</span><h3>Performance Reporting</h3><p>Detailed analytics on bid performance, success rates, and market opportunities.</p></div>
      </div>
    </div>
  </section>

  <!-- ============ WEB DEV ============ -->
  <section class="section section-alt" id="webdev">
    <div class="container">
      <div class="section-head reveal">
        <p class="eyebrow">MAS Communication &middot; Web &amp; IT</p>
        <h2 class="section-title">Web &amp; App Development That Converts</h2>
        <p class="section-sub">Four ways we build your digital presence — each one responsive, SEO-ready, and built for speed.</p>
      </div>
      <div class="dev-grid">
        <article class="dev-card reveal">
          <img src="https://images.unsplash.com/photo-1547658719-da2b51169166?w=800&q=80" alt="Corporate website design" loading="lazy">
          <div class="dev-card-body">
            <h3>Corporate Websites</h3>
            <p>High-impact corporate websites that establish brand authority, communicate your value proposition, and convert visitors into clients. Fully responsive, SEO-optimized, and built for speed.</p>
            <ul class="check-list">
              <li>Brand-aligned UI/UX design</li>
              <li>CMS integration (WordPress/Headless)</li>
              <li>Multi-language support</li>
              <li>Google Analytics &amp; SEO optimization</li>
              <li>Hosting &amp; maintenance included</li>
            </ul>
            <a href="#contact" class="btn btn-green btn-sm">Start a Project &rarr;</a>
          </div>
        </article>
        <article class="dev-card reveal">
          <img src="https://images.unsplash.com/photo-1563013544-824ae1b704d3?w=800&q=80" alt="E-commerce platform" loading="lazy">
          <div class="dev-card-body">
            <h3>E-Commerce Platforms</h3>
            <p>Full-featured online stores built on WooCommerce, Shopify, or custom frameworks — optimized for conversions, payment processing, and seamless user experience across all devices.</p>
            <ul class="check-list">
              <li>Custom storefront design</li>
              <li>Payment gateway integration</li>
              <li>Inventory management system</li>
              <li>Order tracking &amp; fulfillment</li>
              <li>Performance &amp; conversion optimization</li>
            </ul>
            <a href="#contact" class="btn btn-green btn-sm">Start a Project &rarr;</a>
          </div>
        </article>
        <article class="dev-card reveal">
          <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?w=800&q=80" alt="Enterprise portal development" loading="lazy">
          <div class="dev-card-body">
            <h3>Enterprise Portals</h3>
            <p>Custom-built enterprise web applications including HR portals, client dashboards, data management systems, and workflow automation tools designed for scale and security.</p>
            <ul class="check-list">
              <li>Role-based access control</li>
              <li>API integration &amp; microservices</li>
              <li>Real-time data dashboards</li>
              <li>Enterprise-grade security</li>
              <li>24/7 technical support</li>
            </ul>
            <a href="#contact" class="btn btn-green btn-sm">Start a Project &rarr;</a>
          </div>
        </article>
        <article class="dev-card reveal">
          <img src="https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=800&q=80" alt="Mobile application development" loading="lazy">
          <div class="dev-card-body">
            <h3>Mobile Applications</h3>
            <p>Native and cross-platform mobile apps for iOS and Android — from concept and UX design through development, testing, and App Store deployment with ongoing maintenance.</p>
            <ul class="check-list">
              <li>iOS &amp; Android development</li>
              <li>React Native / Flutter</li>
              <li>Push notifications &amp; analytics</li>
              <li>Offline functionality support</li>
              <li>App Store optimization</li>
            </ul>
            <a href="#contact" class="btn btn-green btn-sm">Start a Project &rarr;</a>
          </div>
        </article>
      </div>
    </div>
  </section>

  <!-- ============ MARKET ENTRY ============ -->
  <section class="section" id="operational">
    <div class="container">
      <div class="section-head reveal">
        <p class="eyebrow">MAS Consultancy &middot; Market Entry</p>
        <h2 class="section-title">From First Meeting to Fully Operational in Six Steps</h2>
        <p class="section-sub">A guided path for US companies entering Bangladesh — we handle the setup, you run the business.</p>
      </div>
      <ol class="journey">
        <li class="journey-step reveal">
          <span class="journey-num">01</span>
          <div><h3>Market Research &amp; Feasibility</h3><p>We analyze your target sector, identify opportunities, assess competition, and provide a comprehensive market entry report tailored to your US business model for the Bangladesh market.</p></div>
        </li>
        <li class="journey-step reveal">
          <span class="journey-num">02</span>
          <div><h3>Company Registration &amp; Licensing</h3><p>Full management of RJSC registration, BIDA approval, trade license, TIN/BIN registration, and all sector-specific permits and regulatory approvals required to operate in Bangladesh.</p></div>
        </li>
        <li class="journey-step reveal">
          <span class="journey-num">03</span>
          <div><h3>Office Setup &amp; Infrastructure</h3><p>Identifying and securing office space in prime Dhaka locations, setting up IT infrastructure, internet connectivity, and all operational utilities for your Bangladesh headquarters.</p></div>
        </li>
        <li class="journey-step reveal">
          <span class="journey-num">04</span>
          <div><h3>Local Staffing &amp; Recruitment</h3><p>Recruiting qualified local professionals — engineers, managers, analysts, and support staff — through our extensive professional network across Bangladesh's major business hubs.</p></div>
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
      <div class="center reveal">
        <a href="#contact" class="btn btn-primary">Start Your Market Entry</a>
      </div>
    </div>
  </section>

  <!-- ============ PORTFOLIO ============ -->
  <section class="section section-alt" id="portfolio">
    <div class="container">
      <div class="section-head reveal">
        <p class="eyebrow">Our Work</p>
        <h2 class="section-title">Results Across the MAS Group</h2>
        <p class="section-sub">A snapshot of what the three firms have delivered for clients in Bangladesh and the US.</p>
      </div>
      <div class="cards-grid">
        <article class="card reveal">
          <div class="card-icon" aria-hidden="true">📋</div>
          <p class="card-kicker">MAS Corporation &middot; E-Procurement</p>
          <h3>Government Tender Management</h3>
          <p>End-to-end management of 175+ government tenders across CPTU, e-GP, LGED, and BIWTA portals for multiple enterprise clients.</p>
          <p class="card-metric">86% Success Rate</p>
        </article>
        <article class="card reveal">
          <div class="card-icon" aria-hidden="true">💻</div>
          <p class="card-kicker">MAS Communication &middot; Web Dev</p>
          <h3>US Business Digital Presence</h3>
          <p>Designed and developed corporate websites, e-commerce platforms, and enterprise portals for 52+ US-based clients entering the Bangladesh market.</p>
          <p class="card-metric">52+ US Clients</p>
        </article>
        <article class="card reveal">
          <div class="card-icon" aria-hidden="true">🌏</div>
          <p class="card-kicker">MAS Consultancy &middot; Market Entry</p>
          <h3>Foreign Business Setup</h3>
          <p>Successfully helped 30+ international companies register, license, and fully operationalize their Bangladesh offices including staffing and banking setup.</p>
          <p class="card-metric">30+ Companies Setup</p>
        </article>
        <article class="card reveal">
          <div class="card-icon" aria-hidden="true">🔒</div>
          <p class="card-kicker">MAS Communication &middot; Security</p>
          <h3>IT Security &amp; Compliance</h3>
          <p>Comprehensive cybersecurity audits, data protection compliance implementation, and security training for enterprise clients across multiple industries.</p>
          <p class="card-metric">100% Compliance Rate</p>
        </article>
        <article class="card reveal">
          <div class="card-icon" aria-hidden="true">📱</div>
          <p class="card-kicker">MAS Communication &middot; Mobile</p>
          <h3>Enterprise Mobile Applications</h3>
          <p>Built and deployed cross-platform mobile applications for logistics, HR management, and field operations for international corporations in Bangladesh.</p>
          <p class="card-metric">15+ Apps Deployed</p>
        </article>
        <article class="card reveal">
          <div class="card-icon" aria-hidden="true">📊</div>
          <p class="card-kicker">MAS Consultancy &middot; Advisory</p>
          <h3>Digital Transformation Projects</h3>
          <p>Strategic digital transformation advisory and implementation for traditional Bangladeshi businesses modernizing their operations for global competitiveness.</p>
          <p class="card-metric">20+ Transformations</p>
        </article>
      </div>
    </div>
  </section>

  <!-- ============ FAQ ============ -->
  <section class="section" id="faq">
    <div class="container container-narrow">
      <div class="section-head reveal">
        <p class="eyebrow">FAQ</p>
        <h2 class="section-title">Frequently Asked Questions</h2>
      </div>
      <div class="faq-list reveal">
        <div class="faq-item">
          <button class="faq-q" aria-expanded="false">What is the MAS Group, and how are the three firms different? <span class="faq-icon">+</span></button>
          <div class="faq-a"><p>MAS Consultancy is a licensed group of companies under MAS Corporation. <strong>MAS Corporation</strong> handles e-procurement, <strong>MAS Communication</strong> delivers web development and IT solutions, and <strong>MAS Consultancy</strong> provides end-to-end operational support for US businesses expanding into Bangladesh.</p></div>
        </div>
        <div class="faq-item">
          <button class="faq-q" aria-expanded="false">Which e-procurement portals do you work with? <span class="faq-icon">+</span></button>
          <div class="faq-a"><p>We work across e-GP Bangladesh, CPTU, the BMET Portal, DESCO Procurement, BIWTA, and LGED tenders — covering government, utility, transport, and engineering contracts.</p></div>
        </div>
        <div class="faq-item">
          <button class="faq-q" aria-expanded="false">What does setting up a business in Bangladesh involve? <span class="faq-icon">+</span></button>
          <div class="faq-a"><p>Six steps: market research and feasibility, company registration and licensing (RJSC, BIDA, trade license, TIN/BIN), office setup and infrastructure, local staffing, banking and financial setup, and ongoing support and compliance. We manage the full journey.</p></div>
        </div>
        <div class="faq-item">
          <button class="faq-q" aria-expanded="false">Do you work with US-based businesses? <span class="faq-icon">+</span></button>
          <div class="faq-a"><p>Yes — US businesses are our core focus. We serve 52+ US clients, from market entry and company setup to web development and e-procurement support, and our team works across US time zones.</p></div>
        </div>
        <div class="faq-item">
          <button class="faq-q" aria-expanded="false">What are your business hours? <span class="faq-icon">+</span></button>
          <div class="faq-a"><p>Sunday to Thursday, 9:00 AM – 6:00 PM (Bangladesh Time). We are closed Friday and Saturday. You can reach us anytime by email at <?php echo e($contact['email1'] ?? ''); ?> or on WhatsApp at <?php echo e($contact['phone_display'] ?? ''); ?>.</p></div>
        </div>
        <div class="faq-item">
          <button class="faq-q" aria-expanded="false">How quickly will I hear back after contacting you? <span class="faq-icon">+</span></button>
          <div class="faq-a"><p>We reply within 24 hours on business days. For urgent inquiries, WhatsApp is the fastest way to reach us.</p></div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============ NEWSLETTER ============ -->
  <section class="section section-alt" id="newsletter">
    <div class="container container-narrow">
      <div class="newsletter-box reveal">
        <p class="eyebrow">Stay Updated</p>
        <h2 class="section-title">Get Business Insights for the Bangladesh Market</h2>
        <p>Subscribe to receive the latest updates on Bangladesh e-procurement opportunities, market insights, and business news from the MAS Group.</p>
        <form class="newsletter-form" id="newsletterForm" novalidate>
          <label class="sr-only" for="newsletterEmail">Business email</label>
          <input type="email" id="newsletterEmail" name="email" class="newsletter-input" placeholder="Enter your business email" required>
          <button type="submit" class="btn btn-primary">Subscribe</button>
        </form>
        <p class="form-note" id="newsletterMsg" role="status">No spam. Unsubscribe anytime. We respect your privacy.</p>
      </div>
    </div>
  </section>

  <!-- ============ NEWS PREVIEW ============ -->
  <section class="section" id="news">
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

  <!-- ============ CONTACT ============ -->
  <section class="section section-dark" id="contact">
    <div class="container">
      <div class="section-head reveal">
        <p class="eyebrow eyebrow-light">Contact Us</p>
        <h2 class="section-title section-title-light">Let's Talk About Your Project</h2>
        <p class="section-sub section-sub-light">Tell us what you're planning — we'll get back to you within 24 hours.</p>
      </div>
      <div class="contact-grid">
        <div class="contact-info reveal">
          <div class="info-card">
            <span class="info-icon" aria-hidden="true">📍</span>
            <div><h3>Office Address</h3><p><?php echo e_nl($contact['address'] ?? ''); ?></p></div>
          </div>
          <div class="info-card">
            <span class="info-icon" aria-hidden="true">📞</span>
            <div><h3>Phone &amp; WhatsApp</h3><p><a href="tel:<?php echo e($contact['phone_tel'] ?? ''); ?>"><?php echo e($contact['phone_display'] ?? ''); ?></a> (BD Office)<br><a href="https://wa.me/<?php echo e($contact['whatsapp'] ?? ''); ?>" target="_blank" rel="noopener">Chat on WhatsApp</a></p></div>
          </div>
          <div class="info-card">
            <span class="info-icon" aria-hidden="true">✉️</span>
            <div><h3>Email</h3><p><a href="mailto:<?php echo e($contact['email1'] ?? ''); ?>"><?php echo e($contact['email1'] ?? ''); ?></a><br><a href="mailto:<?php echo e($contact['email2'] ?? ''); ?>"><?php echo e($contact['email2'] ?? ''); ?></a></p></div>
          </div>
          <div class="info-card">
            <span class="info-icon" aria-hidden="true">🕐</span>
            <div><h3>Business Hours</h3><p><?php echo e_nl($contact['hours'] ?? ''); ?></p></div>
          </div>
          <div class="map-wrap">
            <iframe title="MAS Consultancy office location map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.9!2d90.4074!3d23.7315!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjPCsDQzJzUzLjQiTiA5MMKwMjQnMjYuNiJF!5e0!3m2!1sen!2sbd!4v1" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
          </div>
        </div>
        <form class="contact-form reveal" id="contactForm" novalidate>
          <div class="form-row">
            <div class="form-field">
              <label for="cfName">Your Name *</label>
              <input type="text" id="cfName" name="name" class="form-input" placeholder="John Smith" required autocomplete="name">
            </div>
            <div class="form-field">
              <label for="cfEmail">Email *</label>
              <input type="email" id="cfEmail" name="email" class="form-input" placeholder="john@company.com" required autocomplete="email">
            </div>
          </div>
          <div class="form-row">
            <div class="form-field">
              <label for="cfCompany">Company</label>
              <input type="text" id="cfCompany" name="company" class="form-input" placeholder="Your Company Inc." autocomplete="organization">
            </div>
            <div class="form-field">
              <label for="cfPhone">Phone</label>
              <input type="tel" id="cfPhone" name="phone" class="form-input" placeholder="+1 (347) 000-0000" autocomplete="tel">
            </div>
          </div>
          <div class="form-field">
            <label for="cfService">Service Needed *</label>
            <select id="cfService" name="service" class="form-select" required>
              <option value="">Select a service...</option>
              <option>E-Procurement Management (MAS Corporation)</option>
              <option>Web Development &amp; IT (MAS Communication)</option>
              <option>IT Infrastructure &amp; Cloud</option>
              <option>Security &amp; Compliance</option>
              <option>Bangladesh Business Setup (MAS Consultancy)</option>
              <option>Digital Transformation Advisory</option>
              <option>Market Entry Feasibility Study</option>
              <option>Other / General Inquiry</option>
            </select>
          </div>
          <div class="form-field">
            <label for="cfMessage">Your Message * <span class="char-count"><span id="charCount">0</span>/500</span></label>
            <textarea id="cfMessage" name="message" class="form-textarea" placeholder="Tell us about your project, business goals, or inquiry..." maxlength="500" rows="5" required></textarea>
          </div>
          <!-- Honeypot (leave empty): spam protection -->
          <div class="hp-field" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
          <p class="form-status" id="contactMsg" role="status" aria-live="polite"></p>
          <button type="submit" class="btn btn-primary btn-block" id="contactSubmit">Send Message</button>
        </form>
      </div>
    </div>
  </section>

  <!-- ============ FOOTER ============ -->
  <footer class="footer">
    <div class="container footer-grid">
      <div class="footer-brand">
        <a href="#" class="nav-logo"><img src="logo.png" alt="MAS Consultancy logo" height="40"><span class="nav-logo-text">MAS <em>Consultancy</em></span></a>
        <p>One group, complete solutions. E-procurement, web &amp; IT, and foreign business setup in Bangladesh — trusted by US businesses since 2021.</p>
        <a class="footer-whatsapp" href="https://wa.me/<?php echo e($contact['whatsapp'] ?? ''); ?>" target="_blank" rel="noopener">💬 WhatsApp Us</a>
      </div>
      <nav class="footer-col" aria-label="Firms">
        <h3>Our Firms</h3>
        <a href="#eprocurement">MAS Corporation</a>
        <a href="#webdev">MAS Communication</a>
        <a href="#operational">MAS Consultancy</a>
        <a href="#portfolio">Portfolio</a>
      </nav>
      <nav class="footer-col" aria-label="Services">
        <h3>Services</h3>
        <a href="#eprocurement">E-Procurement</a>
        <a href="#webdev">Web Development</a>
        <a href="#operational">Business Setup</a>
        <a href="#services">IT &amp; Security</a>
      </nav>
      <div class="footer-col">
        <h3>Contact</h3>
        <p><?php echo e_nl($contact['address'] ?? ''); ?></p>
        <a href="mailto:<?php echo e($contact['email1'] ?? ''); ?>"><?php echo e($contact['email1'] ?? ''); ?></a>
        <a href="mailto:<?php echo e($contact['email2'] ?? ''); ?>"><?php echo e($contact['email2'] ?? ''); ?></a>
        <a href="tel:<?php echo e($contact['phone_tel'] ?? ''); ?>"><?php echo e($contact['phone_display'] ?? ''); ?></a>
      </div>
    </div>
    <div class="footer-wordmark" aria-hidden="true">MAS Consultancy</div>
    <div class="footer-bottom">
      <div class="container footer-bottom-inner">
        <p>&copy; <span id="year">2026</span> MAS Consultancy. Licensed under MAS Corporation. All rights reserved.</p>
        <p><a href="blog.php">News &amp; Blog</a> &middot; <a href="#contact">Contact Us</a></p>
      </div>
    </div>
  </footer>

  <!-- Floating buttons -->
  <a href="https://wa.me/<?php echo e($contact['whatsapp'] ?? ''); ?>" target="_blank" rel="noopener" class="whatsapp-btn" aria-label="Chat with us on WhatsApp">
    <span class="whatsapp-tooltip">Chat with us!</span>
    <svg viewBox="0 0 32 32" aria-hidden="true"><path d="M16 3C9.4 3 4 8.4 4 15c0 2.1.6 4.1 1.6 5.8L4 27l6.4-1.5c1.6.9 3.5 1.4 5.6 1.4 6.6 0 12-5.4 12-12S22.6 3 16 3zm0 22.1c-1.8 0-3.6-.5-5.1-1.4l-.4-.2-3.8.9.9-3.7-.2-.4c-1-1.6-1.6-3.5-1.6-5.4 0-5.6 4.6-10.2 10.2-10.2S26.2 9.3 26.2 15 21.6 25.1 16 25.1zm5.6-7.6c-.3-.2-1.8-.9-2.1-1-.3-.1-.5-.2-.7.2-.2.3-.8 1-.9 1.2-.2.2-.3.2-.6.1-.3-.2-1.3-.5-2.4-1.5-.9-.8-1.5-1.8-1.7-2.1-.2-.3 0-.5.1-.6.1-.1.3-.3.4-.5.1-.2.2-.3.3-.5.1-.2 0-.4 0-.6-.1-.2-.7-1.7-.9-2.3-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.5.1-.8.4-.3.3-1 1-1 2.5s1.1 2.9 1.2 3.1c.1.2 2.1 3.2 5.1 4.5.7.3 1.3.5 1.7.6.7.2 1.4.2 1.9.1.6-.1 1.8-.7 2-1.4.3-.7.3-1.3.2-1.4-.1-.1-.3-.2-.6-.3z"/></svg>
  </a>
  <button class="back-to-top" id="backToTop" aria-label="Back to top">&uarr;</button>

  <script src="js/main.js"></script>
</body>
</html>
