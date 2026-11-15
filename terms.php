<?php
require_once __DIR__ . '/includes/layout.php';

page_head([
    'title'       => 'Terms of Service | MAS Consultancy',
    'description' => 'The terms governing your use of masconsultancy.org and the services provided by MAS Group.',
    'canonical'   => 'https://masconsultancy.org/terms.php',
]);
site_header('terms', true);
?>

  <!-- ============ PAGE HERO ============ -->
  <section class="page-hero">
    <div class="container">
      <p class="eyebrow eyebrow-light">Legal</p>
      <h1>Terms of Service</h1>
      <p>Effective date: 15 November 2026. Last updated: 15 November 2026.</p>
    </div>
  </section>

  <!-- ============ TERMS ============ -->
  <section class="section">
    <div class="container container-narrow">
      <p>These terms govern your use of masconsultancy.org (the "Website") and the services provided by MAS Group, operating under MAS Corporation ("we", "us", "our"). By using the Website, you agree to these terms. If you do not agree, please do not use the Website.</p>

      <h2>Our services</h2>
      <p>MAS Group provides e-procurement support, web and IT services, foreign business setup in Bangladesh, B2B lead generation, and AI-driven marketing services. The descriptions on this Website are general introductions to our services. The scope, timeline, and price of any specific engagement are set out in a written proposal or agreement for that project, and that document governs the engagement.</p>

      <h2>Quotes and proposals</h2>
      <p>Any estimate or quote we provide is based on the information available at the time and is valid for the period stated in the proposal. A project begins only when both sides have agreed the scope and terms in writing.</p>

      <h2>Payments</h2>
      <p>Fees, payment schedules, and accepted payment methods are agreed per project and stated in the proposal or invoice. Work may be paused if agreed payments are overdue.</p>

      <h2>Your responsibilities</h2>
      <p>When you contact us or use our services, you agree to provide accurate information and to use the Website lawfully. You agree not to misuse the Website, attempt to gain unauthorised access to it, or use it to send spam or harmful content.</p>

      <h2>Intellectual property</h2>
      <p>The content of this Website — including text, images, branding, and design — belongs to MAS Group or its licensors and may not be copied or reused without permission. Ownership of deliverables produced for a client (such as a website, report, or marketing material) is agreed in the relevant project proposal.</p>

      <h2>Information on this Website</h2>
      <p>We aim to keep the information on this Website accurate and up to date, but we do not guarantee that it is complete or error-free. Nothing on this Website is legal, financial, or tax advice. Figures such as project counts and success rates reflect our records at the time of publication.</p>

      <h2>Third-party links</h2>
      <p>Our Website may link to third-party websites. We are not responsible for the content or privacy practices of those sites.</p>

      <h2>Limitation of liability</h2>
      <p>To the fullest extent permitted by law, MAS Group is not liable for indirect, incidental, or consequential losses arising from the use of this Website. Our total liability for any claim relating to a specific engagement is limited to the fees paid for that engagement.</p>

      <h2>Changes to these terms</h2>
      <p>We may update these terms from time to time. The latest version will always be published on this page, with the effective date shown above. Continued use of the Website after changes are published means you accept the updated terms.</p>

      <h2>Governing law</h2>
      <p>These terms are governed by the laws of Bangladesh. Any dispute arising from them will be handled under the jurisdiction of the courts of Dhaka, Bangladesh.</p>

      <h2>Contact us</h2>
      <p>MAS Group (MAS Corporation)<br>
      73, Eastern Commercial Complex, Kakrail, Dhaka, Bangladesh<br>
      Email: <a href="mailto:info@masconsultancy.org">info@masconsultancy.org</a><br>
      Phone: +880 1913 876636</p>
    </div>
  </section>

<?php
cta_band(
    'Questions about these terms?',
    'Contact us — we reply within 24 hours on business days.'
);
site_footer();
