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
  <title>News &amp; Blog - MAS Consultancy</title>
  <meta name="description" content="Updates, insights, and news from MAS Corporation, MAS Communication, and MAS Consultancy — e-procurement, web & IT, and Bangladesh market entry.">
  <meta name="theme-color" content="#faf8f2">
  <meta property="og:type" content="website">
  <meta property="og:title" content="News & Blog - MAS Consultancy">
  <meta property="og:description" content="Updates, insights, and news from the MAS Group.">
  <meta property="og:url" content="https://masconsultancy.org/blog.php">
  <link rel="icon" type="image/png" href="logo.png">
  <link rel="canonical" href="https://masconsultancy.org/blog.php">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preconnect" href="https://images.unsplash.com">
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,400;1,9..144,500;1,9..144,600&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <a class="skip-link" href="#posts">Skip to posts</a>

  <!-- ============ NAVBAR ============ -->
  <header class="navbar navbar-solid" id="navbar">
    <div class="nav-inner">
      <a href="index.php" class="nav-logo" aria-label="MAS Consultancy — home">
        <img src="logo-wordmark.png" alt="MAS Consultancy" class="nav-wordmark" height="42">
      </a>
      <nav aria-label="Primary">
        <ul class="nav-links" id="navLinks">
          <li><a href="index.php#about">About</a></li>
          <li><a href="index.php#services">Services</a></li>
          <li><a href="index.php#eprocurement">E-Procurement</a></li>
          <li><a href="index.php#webdev">Web Dev</a></li>
          <li><a href="index.php#operational">Market Entry</a></li>
          <li><a href="index.php#portfolio">Portfolio</a></li>
          <li><a href="blog.php" class="active">Blog</a></li>
          <li><a href="index.php#contact" class="nav-cta">Get in Touch</a></li>
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
      <a href="index.php#about">About Us</a>
      <a href="index.php#services">Services</a>
      <a href="index.php#eprocurement">E-Procurement</a>
      <a href="index.php#webdev">Web Development</a>
      <a href="index.php#operational">Market Entry</a>
      <a href="index.php#portfolio">Portfolio</a>
      <a href="blog.php">News &amp; Blog</a>
      <a href="index.php#contact" class="mobile-cta">Get in Touch</a>
    </nav>
    <div class="mobile-contact">
      <a href="tel:<?php echo e($contact['phone_tel'] ?? ''); ?>"><?php echo e($contact['phone_display'] ?? ''); ?></a>
      <a href="mailto:<?php echo e($contact['email1'] ?? ''); ?>"><?php echo e($contact['email1'] ?? ''); ?></a>
    </div>
  </div>
  <div class="menu-overlay" id="menuOverlay"></div>

  <!-- ============ PAGE HERO ============ -->
  <section class="page-hero">
    <div class="container">
      <p class="eyebrow eyebrow-light">News &amp; Insights</p>
      <h1>Latest from MAS Group</h1>
      <p>Updates, insights, and news from MAS Corporation, MAS Communication, and MAS Consultancy.</p>
    </div>
  </section>

  <!-- ============ POSTS ============ -->
  <section class="section" id="posts">
    <div class="container">
      <?php $counts = ['all' => count($posts)]; foreach ($posts as $p) { $counts[$p['category'] ?? ''] = ($counts[$p['category'] ?? ''] ?? 0) + 1; } ?>
      <div class="filter-bar" role="group" aria-label="Filter posts by category">
        <button class="filter-btn active" data-filter="all">All Posts <span class="filter-count">(<?php echo $counts['all']; ?>)</span></button>
        <?php foreach (POST_CATEGORIES as $key => $label): ?>
        <button class="filter-btn" data-filter="<?php echo e($key); ?>"><?php echo e($label); ?> <span class="filter-count">(<?php echo $counts[$key] ?? 0; ?>)</span></button>
        <?php endforeach; ?>
      </div>
      <div id="blogGrid" class="news-grid">
        <?php foreach ($posts as $post): ?>
        <?php echo post_card_html($post); ?>
        <?php endforeach; ?>
      </div>
      <div id="blogEmpty" class="empty-state"<?php echo $posts ? ' hidden' : ''; ?>>
        <div class="empty-icon" aria-hidden="true">📰</div>
        <h2>No posts yet</h2>
        <p>Check back soon for news and updates from the MAS Group — or subscribe below and we'll send them to you.</p>
      </div>
    </div>
  </section>

  <!-- ============ NEWSLETTER CTA ============ -->
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

  <!-- ============ FOOTER ============ -->
  <footer class="footer">
    <div class="container footer-grid">
      <div class="footer-brand">
        <a href="index.php" class="nav-logo"><img src="logo.png" alt="MAS Consultancy logo" height="40"><span class="nav-logo-text">MAS <em>Consultancy</em></span></a>
        <p>One group, complete solutions. E-procurement, web &amp; IT, and foreign business setup in Bangladesh — trusted by US businesses since 2021.</p>
        <a class="footer-whatsapp" href="https://wa.me/<?php echo e($contact['whatsapp'] ?? ''); ?>" target="_blank" rel="noopener">💬 WhatsApp Us</a>
      </div>
      <nav class="footer-col" aria-label="Firms">
        <h3>Our Firms</h3>
        <a href="index.php#eprocurement">MAS Corporation</a>
        <a href="index.php#webdev">MAS Communication</a>
        <a href="index.php#operational">MAS Consultancy</a>
        <a href="index.php#portfolio">Portfolio</a>
      </nav>
      <nav class="footer-col" aria-label="Services">
        <h3>Services</h3>
        <a href="index.php#eprocurement">E-Procurement</a>
        <a href="index.php#webdev">Web Development</a>
        <a href="index.php#operational">Business Setup</a>
        <a href="index.php#services">IT &amp; Security</a>
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
        <p><a href="index.php">Back to Homepage</a> &middot; <a href="index.php#contact">Contact Us</a></p>
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
