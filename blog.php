<?php
require_once __DIR__ . '/includes/layout.php';
$posts = load_posts();

page_head([
    'title'       => 'News & Blog - MAS Consultancy',
    'description' => 'Updates, insights, and news from MAS Corporation, MAS Communication, and MAS Consultancy — e-procurement, web & IT, and Bangladesh market entry.',
    'canonical'   => 'https://masconsultancy.org/blog.php',
]);
site_header('blog', true);
?>

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

<?php
newsletter_block();
site_footer();
