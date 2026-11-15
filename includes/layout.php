<?php
// MAS Consultancy — shared page layout (multi-page site).
// Every public page uses page_head() + site_header() + site_footer() so the
// tab-bar navigation, footer and newsletter block exist in exactly one place.

require_once __DIR__ . '/functions.php';

// Tab-bar navigation: key => [url, label]. Order is the tab order.
function nav_items(): array
{
    return [
        'home'          => ['index.php', 'Home'],
        'about'         => ['about.php', 'About'],
        'services'      => ['services.php', 'Services'],
        'e-procurement' => ['e-procurement.php', 'E-Procurement'],
        'web-it'        => ['web-it.php', 'Web & IT'],
        'market-entry'  => ['market-entry.php', 'Market Entry'],
        'agency'        => ['agency.php', 'Agency'],
        'portfolio'     => ['portfolio.php', 'Portfolio'],
        'blog'          => ['blog.php', 'Blog'],
    ];
}

// <head> + opening <body>. $opts: title, description, canonical, og_type,
// og_image, extra (raw HTML appended inside <head>, e.g. JSON-LD).
function page_head(array $opts): void
{
    $title   = $opts['title'] ?? 'MAS Consultancy';
    $desc    = $opts['description'] ?? '';
    $canon   = $opts['canonical'] ?? 'https://masconsultancy.org/';
    $ogType  = $opts['og_type'] ?? 'website';
    $ogImage = $opts['og_image'] ?? 'https://masconsultancy.org/logo.png';
    $extra   = $opts['extra'] ?? '';
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Google tag (gtag.js) — GA4, property masconsultancy.org (G-XJDF0DN25M) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-XJDF0DN25M"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-XJDF0DN25M');
  </script>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="google-site-verification" content="RtVPazd3vLeIZ7rx06zuJCmHE-kzX8Y3AJQsRol6EuU">
  <title><?php echo e($title); ?></title>
  <meta name="description" content="<?php echo e($desc); ?>">
  <meta name="author" content="MAS Consultancy">
  <meta name="theme-color" content="#faf8f2">
  <meta property="og:type" content="<?php echo e($ogType); ?>">
  <meta property="og:title" content="<?php echo e($title); ?>">
  <meta property="og:description" content="<?php echo e($desc); ?>">
  <meta property="og:url" content="<?php echo e($canon); ?>">
  <meta property="og:image" content="<?php echo e($ogImage); ?>">
  <link rel="icon" type="image/png" href="logo.png">
  <link rel="canonical" href="<?php echo e($canon); ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preconnect" href="https://images.unsplash.com">
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,400;1,9..144,500;1,9..144,600&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <?php echo $extra; ?>
</head>
<body>
  <a class="skip-link" href="#main">Skip to content</a>
<?php
}

// Tab-bar header + mobile drawer. $active is the nav key of the current page.
// $solid renders the bar with its background from the top (inner pages).
function site_header(string $active, bool $solid = false): void
{
    $site = load_site();
    $contact = $site['contact'] ?? [];
    $navClass = $solid ? 'navbar navbar-solid' : 'navbar';
    ?>
  <header class="<?php echo $navClass; ?>" id="navbar">
    <div class="nav-inner">
      <a href="index.php" class="nav-logo" aria-label="MAS Consultancy — home">
        <img src="logo-wordmark.png" alt="MAS Consultancy" class="nav-wordmark" height="42">
      </a>
      <nav aria-label="Primary">
        <ul class="nav-links" id="navLinks">
          <?php foreach (nav_items() as $key => [$url, $label]): ?>
          <li><a href="<?php echo e($url); ?>"<?php echo $key === $active ? ' class="active" aria-current="page"' : ''; ?>><?php echo e($label); ?></a></li>
          <?php endforeach; ?>
          <li><a href="contact-us.php" class="nav-cta"<?php echo $active === 'contact' ? ' aria-current="page"' : ''; ?>>Get in Touch</a></li>
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
      <?php foreach (nav_items() as $key => [$url, $label]): ?>
      <a href="<?php echo e($url); ?>"><?php echo e($label); ?></a>
      <?php endforeach; ?>
      <a href="faq.php">FAQ</a>
      <a href="contact-us.php" class="mobile-cta">Get in Touch</a>
    </nav>
    <div class="mobile-contact">
      <a href="tel:<?php echo e($contact['phone_tel'] ?? ''); ?>"><?php echo e($contact['phone_display'] ?? ''); ?></a>
      <a href="mailto:<?php echo e($contact['email1'] ?? ''); ?>"><?php echo e($contact['email1'] ?? ''); ?></a>
    </div>
  </div>
  <div class="menu-overlay" id="menuOverlay"></div>
  <main id="main">
<?php
}

// Newsletter signup block (home, blog, article pages).
function newsletter_block(): void
{
    ?>
  <section class="section section-alt section-slim" id="newsletter">
    <div class="container container-narrow">
      <div class="newsletter-box reveal">
        <p class="eyebrow">Stay Updated</p>
        <h2 class="section-title">Get Business Insights That Matter</h2>
        <p>Subscribe to receive the latest updates on e-procurement opportunities, market insights, and business news from the MAS Group.</p>
        <form class="newsletter-form" id="newsletterForm" novalidate>
          <label class="sr-only" for="newsletterEmail">Business email</label>
          <input type="email" id="newsletterEmail" name="email" class="newsletter-input" placeholder="Enter your business email" required>
          <button type="submit" class="btn btn-primary">Subscribe</button>
        </form>
        <p class="form-note" id="newsletterMsg" role="status">No spam. Unsubscribe anytime. We respect your privacy.</p>
      </div>
    </div>
  </section>
<?php
}

// Dark call-to-action band used at the foot of inner pages.
function cta_band(string $title, string $text): void
{
    ?>
  <section class="section">
    <div class="container">
      <div class="cta-band reveal">
        <h2><?php echo e($title); ?></h2>
        <p><?php echo e($text); ?></p>
        <a href="contact-us.php" class="btn btn-primary">Get in Touch</a>
      </div>
    </div>
  </section>
<?php
}

// Footer + floating buttons + scripts + closing tags.
function site_footer(): void
{
    $site = load_site();
    $contact = $site['contact'] ?? [];
    ?>
  </main>
  <footer class="footer">
    <div class="container footer-grid">
      <div class="footer-brand">
        <a href="index.php" class="nav-logo"><img src="logo.png" alt="MAS Consultancy logo" height="40"><span class="nav-logo-text">MAS <em>Consultancy</em></span></a>
        <p>One group, complete solutions. E-procurement, web &amp; IT, foreign business setup, and AI-driven marketing — trusted by US businesses since 2021.</p>
        <a class="footer-whatsapp" href="https://wa.me/<?php echo e($contact['whatsapp'] ?? ''); ?>" target="_blank" rel="noopener">💬 WhatsApp Us</a>
      </div>
      <nav class="footer-col" aria-label="Firms">
        <h3>Our Firms</h3>
        <a href="e-procurement.php">MAS Corporation</a>
        <a href="web-it.php">MAS Communication</a>
        <a href="market-entry.php">MAS Consultancy</a>
        <a href="agency.php">MAS Hybrid Agency</a>
        <a href="about.php">About the Group</a>
      </nav>
      <nav class="footer-col" aria-label="Services">
        <h3>Services</h3>
        <a href="services.php">All Services</a>
        <a href="e-procurement.php">E-Procurement</a>
        <a href="web-it.php">Web Development</a>
        <a href="market-entry.php">Business Setup</a>
        <a href="services.php#lead-generation">Lead Generation</a>
      </nav>
      <div class="footer-col">
        <h3>Contact</h3>
        <p><?php echo e_nl($contact['address'] ?? ''); ?></p>
        <a href="mailto:<?php echo e($contact['email1'] ?? ''); ?>"><?php echo e($contact['email1'] ?? ''); ?></a>
        <a href="mailto:<?php echo e($contact['email2'] ?? ''); ?>"><?php echo e($contact['email2'] ?? ''); ?></a>
        <a href="tel:<?php echo e($contact['phone_tel'] ?? ''); ?>"><?php echo e($contact['phone_display'] ?? ''); ?></a>
      </div>
    </div>
    <div class="footer-wordmark" aria-hidden="true"><img src="logo-m-outline.png" alt="" class="footer-wordmark-m">AS Consultancy</div>
    <div class="footer-bottom">
      <div class="container footer-bottom-inner">
        <p>&copy; <span id="year">2026</span> MAS Group. Licensed under MAS Corporation. All rights reserved.</p>
        <p><a href="blog.php">News &amp; Blog</a> &middot; <a href="faq.php">FAQ</a> &middot; <a href="contact-us.php">Contact Us</a> &middot; <a href="privacy-policy.php">Privacy Policy</a> &middot; <a href="terms.php">Terms of Service</a></p>
      </div>
    </div>
  </footer>

  <a href="https://wa.me/<?php echo e($contact['whatsapp'] ?? ''); ?>" target="_blank" rel="noopener" class="whatsapp-btn" aria-label="Chat with us on WhatsApp">
    <span class="whatsapp-tooltip">Chat with us!</span>
    <svg viewBox="0 0 32 32" aria-hidden="true"><path d="M16 3C9.4 3 4 8.4 4 15c0 2.1.6 4.1 1.6 5.8L4 27l6.4-1.5c1.6.9 3.5 1.4 5.6 1.4 6.6 0 12-5.4 12-12S22.6 3 16 3zm0 22.1c-1.8 0-3.6-.5-5.1-1.4l-.4-.2-3.8.9.9-3.7-.2-.4c-1-1.6-1.6-3.5-1.6-5.4 0-5.6 4.6-10.2 10.2-10.2S26.2 9.3 26.2 15 21.6 25.1 16 25.1zm5.6-7.6c-.3-.2-1.8-.9-2.1-1-.3-.1-.5-.2-.7.2-.2.3-.8 1-.9 1.2-.2.2-.3.2-.6.1-.3-.2-1.3-.5-2.4-1.5-.9-.8-1.5-1.8-1.7-2.1-.2-.3 0-.5.1-.6.1-.1.3-.3.4-.5.1-.2.2-.3.3-.5.1-.2 0-.4 0-.6-.1-.2-.7-1.7-.9-2.3-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.5.1-.8.4-.3.3-1 1-1 2.5s1.1 2.9 1.2 3.1c.1.2 2.1 3.2 5.1 4.5.7.3 1.3.5 1.7.6.7.2 1.4.2 1.9.1.6-.1 1.8-.7 2-1.4.3-.7.3-1.3.2-1.4-.1-.1-.3-.2-.6-.3z"/></svg>
  </a>
  <button class="back-to-top" id="backToTop" aria-label="Back to top">&uarr;</button>

  <script src="js/main.js"></script>
</body>
</html>
<?php
}
