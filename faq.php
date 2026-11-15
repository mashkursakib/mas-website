<?php
require_once __DIR__ . '/includes/layout.php';
$site    = load_site();
$contact = $site['contact'] ?? [];

// FAQPage schema — answers mirror the visible FAQ text below (plain text, no links).
$faqPairs = [
    ['What is the MAS Group, and how are the three firms different?', 'MAS Consultancy is a licensed group of companies under MAS Corporation. MAS Corporation handles e-procurement, MAS Communication delivers web development and IT solutions, and MAS Consultancy provides end-to-end support for international businesses expanding into Bangladesh. One team coordinates all three for you.'],
    ['Which e-procurement portals do you work with?', 'We work across e-GP Bangladesh, CPTU, the BMET Portal, DESCO Procurement, BIWTA, and LGED tenders — covering government, utility, transport, and engineering contracts.'],
    ['What does setting up a business in Bangladesh involve?', 'Six steps: market research and feasibility, company registration and licensing (RJSC, BIDA, trade licence, TIN/BIN), office setup and infrastructure, local staffing, banking and financial setup, and ongoing support and compliance. We manage the full journey.'],
    ['Do you work with US-based businesses?', 'Yes — US businesses are our core focus. We serve 52+ US clients, from market entry and company setup to web development and e-procurement support, and our team works across US time zones.'],
    ['Do you offer lead generation or appointment setting?', 'Yes. Our team offers B2B lead generation, LinkedIn outreach, and appointment setting for international firms building a sales pipeline — delivered to agreed targets, with regular reporting.'],
    ['How do we start working together?', 'Tell us what you are planning — through the contact form, email, or WhatsApp. We reply within 24 hours on business days with next steps and any questions, then a short scoping conversation before any proposal.'],
    ['How much does a project cost?', 'Every project is quoted individually — it depends on scope, timeline, and what you need from us. Tell us about your project and we will send you a detailed, itemised estimate. There is no obligation.'],
    ['How long does business setup take in Bangladesh?', 'It depends on the entity type and the approvals involved — some registrations move quickly, others wait on the authorities. After a first review of your case, we confirm a realistic timeline before any work starts.'],
    ['What are your business hours?', 'Sunday to Thursday, 9:00 AM – 6:00 PM (Bangladesh Time). We are closed Friday and Saturday. You can reach us anytime by email at ' . ($contact['email1'] ?? 'info@masconsultancy.org') . ' or on WhatsApp at ' . ($contact['phone_display'] ?? '') . '.'],
    ['How quickly will I hear back after contacting you?', 'We reply within 24 hours on business days. For urgent inquiries, WhatsApp is the fastest way to reach us.'],
];
$faqEntities = [];
foreach ($faqPairs as [$q, $a]) {
    $faqEntities[] = ['@type' => 'Question', 'name' => $q, 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $a]];
}
$extra = "\n  <script type=\"application/ld+json\">\n" . json_encode(['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => $faqEntities], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . "\n  </script>";

page_head([
    'title'       => 'FAQ | MAS Consultancy — E-Procurement, Business Setup & Services',
    'description' => 'Frequently asked questions about MAS Group: the three firms, e-procurement portals, setting up a business in Bangladesh, lead generation, pricing, timelines, and how to get started.',
    'canonical'   => 'https://masconsultancy.org/faq.php',
    'extra'       => $extra,
]);
site_header('faq', true);
?>

  <!-- ============ PAGE HERO ============ -->
  <section class="page-hero">
    <div class="container">
      <p class="eyebrow eyebrow-light">FAQ</p>
      <h1>Frequently Asked Questions</h1>
      <p>Answers to the questions we hear most. Anything else — <a href="contact-us.php">ask us directly</a>.</p>
    </div>
  </section>

  <!-- ============ FAQ ============ -->
  <section class="section">
    <div class="container container-narrow">
      <div class="faq-list reveal">
        <div class="faq-item">
          <button class="faq-q" aria-expanded="false">What is the MAS Group, and how are the three firms different? <span class="faq-icon">+</span></button>
          <div class="faq-a"><p>MAS Consultancy is a licensed group of companies under MAS Corporation. <strong>MAS Corporation</strong> handles e-procurement, <strong>MAS Communication</strong> delivers web development and IT solutions, and <strong>MAS Consultancy</strong> provides end-to-end support for international businesses expanding into Bangladesh. One team coordinates all three for you — see <a href="about.php">About the Group</a>.</p></div>
        </div>
        <div class="faq-item">
          <button class="faq-q" aria-expanded="false">Which e-procurement portals do you work with? <span class="faq-icon">+</span></button>
          <div class="faq-a"><p>We work across e-GP Bangladesh, CPTU, the BMET Portal, DESCO Procurement, BIWTA, and LGED tenders — covering government, utility, transport, and engineering contracts. See <a href="e-procurement.php">E-Procurement</a> for the full coverage.</p></div>
        </div>
        <div class="faq-item">
          <button class="faq-q" aria-expanded="false">What does setting up a business in Bangladesh involve? <span class="faq-icon">+</span></button>
          <div class="faq-a"><p>Six steps: market research and feasibility, company registration and licensing (RJSC, BIDA, trade licence, TIN/BIN), office setup and infrastructure, local staffing, banking and financial setup, and ongoing support and compliance. We manage the full journey — see <a href="market-entry.php">Market Entry</a>.</p></div>
        </div>
        <div class="faq-item">
          <button class="faq-q" aria-expanded="false">Do you work with US-based businesses? <span class="faq-icon">+</span></button>
          <div class="faq-a"><p>Yes — US businesses are our core focus. We serve 52+ US clients, from market entry and company setup to web development and e-procurement support, and our team works across US time zones.</p></div>
        </div>
        <div class="faq-item">
          <button class="faq-q" aria-expanded="false">Do you offer lead generation or appointment setting? <span class="faq-icon">+</span></button>
          <div class="faq-a"><p>Yes. Our team offers B2B lead generation, LinkedIn outreach, and appointment setting for international firms building a sales pipeline — delivered to agreed targets, with regular reporting. See <a href="services.php#lead-generation">Lead Generation</a>.</p></div>
        </div>
        <div class="faq-item">
          <button class="faq-q" aria-expanded="false">How do we start working together? <span class="faq-icon">+</span></button>
          <div class="faq-a"><p>Tell us what you&apos;re planning — through the <a href="contact-us.php">contact form</a>, email, or WhatsApp. We reply within 24 hours on business days with next steps and any questions, then a short scoping conversation before any proposal.</p></div>
        </div>
        <div class="faq-item">
          <button class="faq-q" aria-expanded="false">How much does a project cost? <span class="faq-icon">+</span></button>
          <div class="faq-a"><p>Every project is quoted individually — it depends on scope, timeline, and what you need from us. Tell us about your project and we&apos;ll send you a detailed, itemised estimate. There&apos;s no obligation.</p></div>
        </div>
        <div class="faq-item">
          <button class="faq-q" aria-expanded="false">How long does business setup take in Bangladesh? <span class="faq-icon">+</span></button>
          <div class="faq-a"><p>It depends on the entity type and the approvals involved — some registrations move quickly, others wait on the authorities. After a first review of your case, we confirm a realistic timeline before any work starts.</p></div>
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

<?php
cta_band(
    'Still Have Questions?',
    'Ask us directly — we reply within 24 hours on business days.'
);
site_footer();
