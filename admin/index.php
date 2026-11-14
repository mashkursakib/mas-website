<?php
// MAS Admin — dashboard.
$pageTitle = 'Dashboard';
$active = 'dashboard';
require_once __DIR__ . '/_header.php';

$posts = load_posts();
$site = load_site();
$counts = [];
foreach ($posts as $p) {
    $cat = $p['category'] ?? '';
    $counts[$cat] = ($counts[$cat] ?? 0) + 1;
}
$latest = array_slice($posts, 0, 5);
$postsUpdated = @filemtime(POSTS_JSON);
$siteUpdated = @filemtime(SITE_JSON);
?>

<h1>Dashboard</h1>
<p class="lede">Welcome back. Here is your site at a glance.</p>

<div class="stat-row">
  <div class="stat-box"><b><?php echo count($posts); ?></b><span>Blog posts</span></div>
  <div class="stat-box"><b><?php echo e((string) ($site['stats'][1]['value'] ?? '—')); ?>+</b><span>Projects shown on site</span></div>
  <div class="stat-box"><b><?php echo e((string) ($site['stats'][2]['value'] ?? '—')); ?>+</b><span>US clients shown on site</span></div>
  <div class="stat-box"><b><?php echo $postsUpdated ? date('M j', $postsUpdated) : '—'; ?></b><span>Posts last updated</span></div>
</div>

<div class="quick-links">
  <a class="btn" href="post-edit.php">+ New blog post</a>
  <a class="btn btn-outline" href="posts.php">Manage posts</a>
  <a class="btn btn-outline" href="settings.php">Edit site settings</a>
  <a class="btn btn-outline" href="../blog.php" target="_blank" rel="noopener">View blog ↗</a>
</div>

<div class="card">
  <h2>Latest posts</h2>
  <?php if ($latest): ?>
  <table>
    <thead><tr><th>Title</th><th>Category</th><th>Date</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($latest as $post): ?>
      <tr>
        <td><?php echo e($post['title'] ?? ''); ?></td>
        <td><span class="cat-tag"><?php echo e(post_category_label($post['category'] ?? '')); ?></span></td>
        <td><?php echo e(format_post_date($post['date'] ?? '')); ?></td>
        <td><a href="post-edit.php?id=<?php echo e($post['id'] ?? ''); ?>">Edit</a></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php else: ?>
  <p class="empty">No posts yet. <a href="post-edit.php">Publish your first post</a> — it will appear on the blog page and the homepage news section.</p>
  <?php endif; ?>
</div>

<div class="card">
  <h2>Posts by category</h2>
  <?php if ($counts): ?>
  <table>
    <tbody>
      <?php foreach (POST_CATEGORIES as $key => $label): ?>
      <tr><td><?php echo e($label); ?></td><td><?php echo $counts[$key] ?? 0; ?></td></tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php else: ?>
  <p class="empty">No posts in any category yet.</p>
  <?php endif; ?>
  <p style="margin-top: 16px; font-size: .88rem; color: var(--muted);">
    Site settings last saved: <?php echo $siteUpdated ? date('M j, Y H:i', $siteUpdated) : 'never'; ?> ·
    Contact email for enquiries: <?php echo e($site['site']['email_to'] ?? ''); ?>
  </p>
</div>

<?php require_once __DIR__ . '/_footer.php'; ?>
