<?php
require_once __DIR__ . '/includes/layout.php';

page_head([
    'title'       => 'Web & App Development in Bangladesh | MAS Communication',
    'description' => 'MAS Communication designs, builds, and maintains websites and web applications — business sites, e-commerce stores, enterprise portals and mobile apps — for clients in Bangladesh and abroad.',
    'canonical'   => 'https://masconsultancy.org/web-it.php',
]);
site_header('web-it', true);
?>

  <!-- ============ PAGE HERO ============ -->
  <section class="page-hero">
    <div class="container">
      <p class="eyebrow eyebrow-light">MAS Communication &middot; Web &amp; IT</p>
      <h1>Web &amp; App Development That Converts</h1>
      <p>One team takes you from first brief to a live, searchable website — and stays responsible for it afterwards, without juggling separate designers, developers, and support providers.</p>
    </div>
  </section>

  <!-- ============ WHAT WE BUILD ============ -->
  <section class="section">
    <div class="container">
      <div class="section-head reveal">
        <p class="eyebrow">What We Build</p>
        <h2 class="section-title">Four Ways We Build Your Digital Presence</h2>
        <p class="section-sub">Each one responsive, SEO-ready, and built for speed — with a CMS your team can update.</p>
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
            <a href="contact-us.php" class="btn btn-green btn-sm">Start a Project &rarr;</a>
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
            <a href="contact-us.php" class="btn btn-green btn-sm">Start a Project &rarr;</a>
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
            <a href="contact-us.php" class="btn btn-green btn-sm">Start a Project &rarr;</a>
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
            <a href="contact-us.php" class="btn btn-green btn-sm">Start a Project &rarr;</a>
          </div>
        </article>
      </div>
    </div>
  </section>

  <!-- ============ TYPICAL JOURNEY ============ -->
  <section class="section section-alt">
    <div class="container">
      <div class="section-head reveal">
        <p class="eyebrow">The Typical Journey</p>
        <h2 class="section-title">From Brief to Launch in Four Steps</h2>
      </div>
      <ol class="journey">
        <li class="journey-step reveal">
          <span class="journey-num">01</span>
          <div><h3>Brief &amp; Goals</h3><p>We start from what the site has to achieve — enquiries, sales, credibility — and agree the scope before design begins.</p></div>
        </li>
        <li class="journey-step reveal">
          <span class="journey-num">02</span>
          <div><h3>Custom Design</h3><p>A design made for your brand and audience, not a generic template, reviewed with you before build.</p></div>
        </li>
        <li class="journey-step reveal">
          <span class="journey-num">03</span>
          <div><h3>Clean Build</h3><p>Built cleanly and tested, with the CMS and admin panel set up so you are never locked out of your own content.</p></div>
        </li>
        <li class="journey-step reveal">
          <span class="journey-num">04</span>
          <div><h3>Launch, Then Support</h3><p>After launch we stay on: updates, improvements, and support as the business grows.</p></div>
        </li>
      </ol>
    </div>
  </section>

<?php
cta_band(
    'Have a Website or App in Mind?',
    'Tell us what it has to achieve and we\'ll send you a detailed, itemised estimate — no obligation.'
);
site_footer();
