<?php
// MAS Admin — blog post list.
$pageTitle = 'Blog Posts';
$active = 'posts';
require_once __DIR__ . '/_header.php';

$posts = load_posts();
?>

<h1>Blog Posts</h1>
<p class="lede">Posts appear on the blog page and the three newest show on the homepage.</p>

<div class="quick-links">
  <a class="btn" href="post-edit.php">+ New blog post</a>
  <a class="btn btn-outline" href="../blog.php" target="_blank" rel="noopener">View blog ↗</a>
</div>

<div class="card">
  <?php if ($posts): ?>
  <table>
    <thead><tr><th>Title</th><th>Category</th><th>Date</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($posts as $post): ?>
      <tr>
        <td>
          <?php echo e($post['title'] ?? ''); ?>
          <div class="meta"><?php $ex = $post['excerpt'] ?? ''; echo e(strlen($ex) > 90 ? substr($ex, 0, 90) . '…' : $ex); ?></div>
        </td>
        <td><span class="cat-tag"><?php echo e(post_category_label($post['category'] ?? '')); ?></span></td>
        <td><?php echo e(format_post_date($post['date'] ?? '')); ?></td>
        <td>
          <div class="row-actions">
            <a class="btn btn-outline btn-sm" href="post-edit.php?id=<?php echo e($post['id'] ?? ''); ?>">Edit</a>
            <form method="post" action="post-delete.php" onsubmit="return confirm('Delete this post? This cannot be undone.');">
              <?php echo csrf_field(); ?>
              <input type="hidden" name="id" value="<?php echo e($post['id'] ?? ''); ?>">
              <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
          </div>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php else: ?>
  <p class="empty">No posts yet. <a href="post-edit.php">Publish your first post</a>.</p>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/_footer.php'; ?>
