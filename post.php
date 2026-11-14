<?php
require_once __DIR__ . '/includes/functions.php';
$site    = load_site();
$posts   = load_posts();
$contact = $site['contact'] ?? [];

$slug = $_GET['slug'] ?? '';
$post = null;
if ($slug !== '') {
    foreach ($posts as $p) {
        if (($p['slug'] ?? '') === $slug || ($p['id'] ?? '') === $slug) {
            $post = $p;
            break;
        }
    }
}
if (!$post) {
    http_response_code(404);
}

$metaTitle = $post ? $post['title'] . ' | MAS Consultancy' : 'Post not found | MAS Consultancy';
$metaDesc  = $post ? ($post['excerpt'] ?? '') : 'This article could not be found.';
$canon     = $post ? 'https://masconsultancy.org/post.php?slug=' . urlencode($post['slug'] ?? $post['id']) : 'https://masconsultancy.org/blog.php';
$ogImage   = ($post && !empty($post['image'])) ? $post['image'] : 'https://masconsultancy.org/logo.png';

// Related posts: same category first, then newest others, max 3.
$related = [];
if ($post) {
    foreach ($posts as $p) {
        if (($p['id'] ?? '') !== ($post['id'] ?? '') && ($p['category'] ?? '') === ($post['category'] ?? '')) {
            $related[] = $p;
        }
    }
    foreach ($posts as $p) {
        if (count($related) >= 3) break;
        if (($p['id'] ?? '') !== ($post['id'] ?? '') && ($p['category'] ?? '') !== ($post['category'] ?? '')) {
            $related[] = $p;
        }
    }
    $related = array_slice($related, 0, 3);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo e($metaTitle); ?></title>
  <meta name="description" content="<?php echo e($metaDesc); ?>">
  <meta name="theme-color" content="#faf8f2">
  <meta property="og:type" content="article">
  <meta property="og:title" content="<?php echo e($metaTitle); ?>">
  <meta property="og:description" content="<?php echo e($metaDesc); ?>">
  <meta property="og:url" content="<?php echo e($canon); ?>">
  <meta property="og:image" content="<?php echo e($ogImage); ?>">
  <?php if ($post): ?>
  <meta property="article:published_time" content="<?php echo e($post['date'] ?? ''); ?>">
  <meta property="article:section" content="<?php echo e(post_category_label($post['category'] ?? '')); ?>">
  <?php endif; ?>
  <link rel="icon" type="image/png" href="logo.png">
  <link rel="canonical" href="<?php echo e($canon); ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preconnect" href="https://images.unsplash.com">
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,400;1,9..144,500;1,9..144,600&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <?php if ($post): ?>
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "BlogPosting",
    "headline": <?php echo json_encode($post['title'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>,
    "description": <?php echo json_encode($post['excerpt'] ?? '', JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>,
    "image": <?php echo json_encode($ogImage, JSON_UNESCAPED_SLASHES); ?>,
    "datePublished": <?php echo json_encode($post['date'] ?? '', JSON_UNESCAPED_SLASHES); ?>,
    "author": {"@type": "Organization", "name": "MAS Consultancy", "url": "https://masconsultancy.org/"},
    "publisher": {"@type": "Organization", "name": "MAS Consultancy", "url": "https://masconsultancy.org/", "logo": {"@type": "ImageObject", "url": "https://masconsultancy.org/logo.png"}},
    "mainEntityOfPage": {"@type": "WebPage", "@id": <?php echo json_encode($canon, JSON_UNESCAPED_SLASHES); ?>}
  }
  </script>
  <?php endif; ?>
</head>
<body>
  <a class="skip-link" href="#article">Skip to article</a>

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

  <?php if (!$post): ?>
  <!-- ============ NOT FOUND ============ -->
  <section class="section" id="article">
    <div class="container container-narrow">
      <div class="empty-state">
        <div class="empty-icon" aria-hidden="true">📰</div>
        <h2>Post not found</h2>
        <p>This article may have been moved or removed. Browse the latest from the MAS Group instead.</p>
        <p><a href="blog.php" class="btn btn-primary">Back to Blog</a></p>
      </div>
    </div>
  </section>
  <?php else: ?>
  <!-- ============ ARTICLE ============ -->
  <article id="article">
    <header class="article-hero">
      <div class="container container-narrow">
        <p class="article-crumb"><a href="blog.php">&larr; All posts</a> <span aria-hidden="true">/</span> <?php echo e(post_category_label($post['category'] ?? '')); ?></p>
        <h1><?php echo e($post['title'] ?? ''); ?></h1>
        <p class="article-meta"><span class="news-cat"><?php echo e(post_category_label($post['category'] ?? '')); ?></span> <time datetime="<?php echo e($post['date'] ?? ''); ?>"><?php echo e(format_post_date($post['date'] ?? '')); ?></time> <span aria-hidden="true">&middot;</span> <span>By MAS Group</span></p>
        <?php if (!empty($post['image'])): ?>
        <img class="article-img" src="<?php echo e($post['image']); ?>" alt="<?php echo e($post['title'] ?? ''); ?>">
        <?php endif; ?>
      </div>
    </header>
    <div class="article-body">
      <div class="container container-narrow">
        <?php echo article_html($post['content'] ?? ''); ?>
        <div class="article-cta">
          <h2>Need help with this?</h2>
          <p>Talk to the MAS Group — e-procurement, web &amp; IT, and foreign business setup in Bangladesh, trusted by 52+ US clients since 2021.</p>
          <a href="index.php#contact" class="btn btn-primary">Get in Touch</a>
        </div>
      </div>
    </div>
  </article>

  <?php if ($related): ?>
  <!-- ============ RELATED ============ -->
  <section class="section section-alt">
    <div class="container">
      <div class="section-head">
        <p class="eyebrow">Keep Reading</p>
        <h2 class="section-title">Related articles</h2>
      </div>
      <div class="news-grid">
        <?php foreach ($related as $rel): ?>
        <?php echo post_card_html($rel); ?>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>
  <?php endif; ?>

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
