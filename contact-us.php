<?php
require_once __DIR__ . '/includes/layout.php';
$site    = load_site();
$contact = $site['contact'] ?? [];

page_head([
    'title'       => 'Contact MAS Consultancy | Dhaka Office — Email, Phone & WhatsApp',
    'description' => 'Contact MAS Group in Dhaka: 73, Eastern Commercial Complex, Kakrail. Email info@masconsultancy.org, call or WhatsApp +880 1913 876636. We reply within 24 hours on business days.',
    'canonical'   => 'https://masconsultancy.org/contact-us.php',
]);
site_header('contact', true);
?>

  <!-- ============ PAGE HERO ============ -->
  <section class="page-hero">
    <div class="container">
      <p class="eyebrow eyebrow-light">Contact Us</p>
      <h1>Let&apos;s Talk About Your Project</h1>
      <p>Tell us what you&apos;re planning — we&apos;ll get back to you within 24 hours on business days. For urgent questions, WhatsApp is fastest.</p>
    </div>
  </section>

  <!-- ============ CONTACT ============ -->
  <section class="section section-dark">
    <div class="container">
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
              <option>B2B Lead Generation &amp; Appointment Setting</option>
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

<?php
site_footer();
