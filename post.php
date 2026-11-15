<?php
require_once __DIR__ . '/includes/layout.php';
$posts = load_posts();

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

$extra = '';
if ($post) {
    $extra .= '
  <meta property="article:published_time" content="' . e($post['date'] ?? '') . '">
  <meta property="article:section" content="' . e(post_category_label($post['category'] ?? '')) . '">
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "BlogPosting",
    "headline": ' . json_encode($post['title'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . ',
    "description": ' . json_encode($post['excerpt'] ?? '', JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . ',
    "image": ' . json_encode($ogImage, JSON_UNESCAPED_SLASHES) . ',
    "datePublished": ' . json_encode($post['date'] ?? '', JSON_UNESCAPED_SLASHES) . ',
    "author": {"@type": "Organization", "name": "MAS Consultancy", "url": "https://masconsultancy.org/"},
    "publisher": {"@type": "Organization", "name": "MAS Consultancy", "url": "https://masconsultancy.org/", "logo": {"@type": "ImageObject", "url": "https://masconsultancy.org/logo.png"}},
    "mainEntityOfPage": {"@type": "WebPage", "@id": ' . json_encode($canon, JSON_UNESCAPED_SLASHES) . '}
  }
  </script>';
}

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

page_head([
    'title'       => $metaTitle,
    'description' => $metaDesc,
    'canonical'   => $canon,
    'og_type'     => 'article',
    'og_image'    => $ogImage,
    'extra'       => $extra,
]);
site_header('blog', true);
?>

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
          <a href="contact-us.php" class="btn btn-primary">Get in Touch</a>
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

<?php
newsletter_block();
site_footer();
