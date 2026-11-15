<?php
require_once __DIR__ . '/includes/layout.php';

page_head([
    'title'       => 'Privacy Policy | MAS Consultancy',
    'description' => 'How MAS Group collects, uses, and protects your personal information when you use masconsultancy.org, contact us, or subscribe to our newsletter.',
    'canonical'   => 'https://masconsultancy.org/privacy-policy.php',
]);
site_header('privacy', true);
?>

  <!-- ============ PAGE HERO ============ -->
  <section class="page-hero">
    <div class="container">
      <p class="eyebrow eyebrow-light">Legal</p>
      <h1>Privacy Policy</h1>
      <p>Effective date: 15 November 2026. Last updated: 15 November 2026.</p>
    </div>
  </section>

  <!-- ============ POLICY ============ -->
  <section class="section">
    <div class="container container-narrow">
      <p>MAS Group, operating under MAS Corporation ("we", "us", "our"), respects your privacy. This policy explains what personal information we collect through masconsultancy.org, how we use it, and the choices you have. If you have any questions, contact us at <a href="mailto:info@masconsultancy.org">info@masconsultancy.org</a>.</p>

      <h2>Information we collect</h2>
      <p><strong>Information you give us directly.</strong> When you use our contact form, you provide your name, email address, and any company, phone number, and message details you choose to include. When you subscribe to our newsletter, you provide your email address. When you contact us by email or WhatsApp, we receive whatever you send us.</p>
      <p><strong>Information collected automatically.</strong> We use Google Analytics 4 to understand how visitors use our website. This collects anonymised usage data such as pages visited, approximate location (city/country level), device type, and how you arrived at the site. Google Analytics uses cookies for this purpose.</p>

      <h2>How we use your information</h2>
      <ul>
        <li>To respond to your enquiries and provide the services you ask about.</li>
        <li>To send our newsletter and business updates, only if you subscribed. Every newsletter includes an unsubscribe option.</li>
        <li>To improve our website and services, using aggregated analytics data.</li>
        <li>To meet legal obligations and protect our business against misuse.</li>
      </ul>
      <p>We do not sell your personal information to anyone.</p>

      <h2>Who we share it with</h2>
      <p>We share limited data only with the service providers that help us run the website: our hosting provider (Render), our content delivery network (Cloudflare), our email delivery provider (Resend, which sends contact-form messages to us), and Google Analytics. These providers process data only as needed to deliver their services to us.</p>

      <h2>Cookies</h2>
      <p>Our website uses cookies for Google Analytics and for the basic functioning of the site. You can block or delete cookies in your browser settings; the site will still work, though some features may behave differently. You can opt out of Google Analytics by installing the <a href="https://tools.google.com/dlpage/gaoptout" target="_blank" rel="noopener">Google Analytics opt-out browser add-on</a>.</p>

      <h2>How long we keep it</h2>
      <p>Contact-form messages are kept for as long as needed to handle your enquiry and maintain a business record. Newsletter subscriptions are kept until you unsubscribe. Analytics data is retained according to Google Analytics settings.</p>

      <h2>Your rights</h2>
      <p>You may ask us at any time to show you the personal information we hold about you, correct it, or delete it. To make a request, email <a href="mailto:info@masconsultancy.org">info@masconsultancy.org</a> and we will respond within a reasonable time. You may also unsubscribe from the newsletter at any time using the link in any email we send.</p>

      <h2>Security</h2>
      <p>Our website is served over HTTPS, and access to our systems is restricted to authorised team members. No method of transmission over the internet is completely secure, and we cannot guarantee absolute security.</p>

      <h2>Children</h2>
      <p>Our website and services are intended for businesses and adults. We do not knowingly collect personal information from children.</p>

      <h2>Changes to this policy</h2>
      <p>We may update this policy from time to time. The latest version will always be published on this page, with the effective date shown above.</p>

      <h2>Contact us</h2>
      <p>MAS Group (MAS Corporation)<br>
      73, Eastern Commercial Complex, Kakrail, Dhaka, Bangladesh<br>
      Email: <a href="mailto:info@masconsultancy.org">info@masconsultancy.org</a><br>
      Phone: +880 1913 876636</p>
    </div>
  </section>

<?php
cta_band(
    'Questions about your privacy?',
    'Contact us — we reply within 24 hours on business days.'
);
site_footer();
