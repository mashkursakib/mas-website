<?php
// MAS Admin — add / edit a blog post.
require_once __DIR__ . '/../includes/functions.php';
require_login();

$posts = load_posts();
$id = $_GET['id'] ?? '';
$editing = null;
if ($id !== '') {
    foreach ($posts as $p) {
        if (($p['id'] ?? '') === $id) {
            $editing = $p;
            break;
        }
    }
    if (!$editing) {
        flash('Post not found.', 'error');
        redirect('posts.php');
    }
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_check()) {
        $error = 'Session expired — please try again.';
    } else {
        $title    = trim($_POST['title'] ?? '');
        $excerpt  = trim($_POST['excerpt'] ?? '');
        $category = $_POST['category'] ?? '';
        $date     = $_POST['date'] ?? '';
        $image    = trim($_POST['image'] ?? '');
        $url      = trim($_POST['url'] ?? '');
        $slug     = trim($_POST['slug'] ?? '');
        $content  = trim($_POST['content'] ?? '');
        if ($slug === '') {
            $slug = slugify($title);
        } else {
            $slug = slugify($slug);
        }

        if ($title === '' || $excerpt === '') {
            $error = 'Title and excerpt are required.';
        } elseif (!isset(POST_CATEGORIES[$category])) {
            $error = 'Please choose a valid category.';
        } elseif ($slug === '' || !preg_match('/^[a-z0-9-]+$/', $slug)) {
            $error = 'Slug may only contain lowercase letters, numbers and hyphens.';
        } elseif (array_filter($posts, fn($p) => ($p['slug'] ?? '') === $slug && ($p['id'] ?? '') !== ($editing['id'] ?? ''))) {
            $error = 'That slug is already used by another post.';
        } elseif ($date !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            $error = 'Date must be YYYY-MM-DD.';
        } elseif ($image !== '' && !filter_var($image, FILTER_VALIDATE_URL)) {
            $error = 'Image must be a full URL (https://…).';
        } elseif ($url !== '' && !filter_var($url, FILTER_VALIDATE_URL) && !preg_match('/^[a-z0-9\-_.\/]+\.(php|html?)(\?[a-z0-9\-_=&%.]+)?$/i', $url)) {
            $error = 'Link must be a full URL or a site page like post.php?slug=example.';
        } else {
            $record = [
                'id'       => $editing['id'] ?? uniqid('p'),
                'slug'     => $slug,
                'title'    => $title,
                'excerpt'  => $excerpt,
                'category' => $category,
                'date'     => $date !== '' ? $date : date('Y-m-d'),
                'image'    => $image,
                'url'      => $url !== '' ? $url : 'post.php?slug=' . $slug,
                'content'  => $content,
            ];
            if ($editing) {
                foreach ($posts as $i => $p) {
                    if (($p['id'] ?? '') === $editing['id']) {
                        $posts[$i] = $record;
                    }
                }
            } else {
                $posts[] = $record;
            }
            // Newest first.
            usort($posts, fn($a, $b) => strcmp($b['date'] ?? '', $a['date'] ?? ''));
            if (save_posts($posts)) {
                flash($editing ? 'Post updated.' : 'Post published.');
                redirect('posts.php');
            }
            $error = 'Could not save — check that data/posts.json is writable.';
        }
    }
    // Keep the submitted values in the form on error.
    $editing = [
        'id'       => $editing['id'] ?? '',
        'slug'     => $_POST['slug'] ?? '',
        'title'    => $_POST['title'] ?? '',
        'excerpt'  => $_POST['excerpt'] ?? '',
        'category' => $_POST['category'] ?? 'company-news',
        'date'     => $_POST['date'] ?? date('Y-m-d'),
        'image'    => $_POST['image'] ?? '',
        'url'      => $_POST['url'] ?? '',
        'content'  => $_POST['content'] ?? '',
    ];
}

$pageTitle = $editing ? 'Edit Post' : 'New Post';
$active = 'posts';
require_once __DIR__ . '/_header.php';

$editing = $editing ?? ['id' => '', 'slug' => '', 'title' => '', 'excerpt' => '', 'category' => 'company-news', 'date' => date('Y-m-d'), 'image' => '', 'url' => '', 'content' => ''];
?>

<h1><?php echo $editing['id'] !== '' ? 'Edit Post' : 'New Blog Post'; ?></h1>
<p class="lede">The card shows on the blog page; the three newest also show on the homepage. The full article shows on its own page.</p>

<?php if ($error): ?>
  <div class="alert alert-error"><?php echo e($error); ?></div>
<?php endif; ?>

<div class="card">
  <form method="post" action="post-edit.php<?php echo $editing['id'] !== '' ? '?id=' . e($editing['id']) : ''; ?>">
    <?php echo csrf_field(); ?>
    <div class="field">
      <label for="title">Title *</label>
      <input type="text" id="title" name="title" value="<?php echo e($editing['title']); ?>" required maxlength="150">
    </div>
    <div class="field">
      <label for="slug">Slug</label>
      <input type="text" id="slug" name="slug" value="<?php echo e($editing['slug'] ?? ''); ?>" placeholder="my-article-title" pattern="[a-z0-9\-]+" maxlength="100">
      <span class="hint">Used in the article address: post.php?slug=<span id="slugPreview"><?php echo e($editing['slug'] ?? 'my-article-title'); ?></span>. Leave empty to generate it from the title.</span>
    </div>
    <div class="field">
      <label for="excerpt">Excerpt *</label>
      <textarea id="excerpt" name="excerpt" required maxlength="300"><?php echo e($editing['excerpt']); ?></textarea>
      <span class="hint">One or two sentences shown on the post card (max 300 characters).</span>
    </div>
    <div class="field">
      <label for="content">Article content</label>
      <textarea id="content" name="content" rows="16"><?php echo e($editing['content'] ?? ''); ?></textarea>
      <span class="hint">Full article. You may use &lt;h2&gt;, &lt;h3&gt;, &lt;p&gt;, &lt;ul&gt;, &lt;ol&gt;, &lt;li&gt;, &lt;strong&gt;, &lt;em&gt;, &lt;a&gt; and &lt;br&gt; tags. Other tags are removed when the article is shown.</span>
    </div>
    <div class="field-grid">
      <div class="field">
        <label for="category">Category *</label>
        <select id="category" name="category" required>
          <?php foreach (POST_CATEGORIES as $key => $label): ?>
          <option value="<?php echo e($key); ?>" <?php echo ($editing['category'] === $key) ? 'selected' : ''; ?>><?php echo e($label); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="field">
        <label for="date">Date</label>
        <input type="date" id="date" name="date" value="<?php echo e($editing['date']); ?>">
      </div>
    </div>
    <div class="field">
      <label for="image">Image URL</label>
      <input type="url" id="image" name="image" value="<?php echo e($editing['image']); ?>" placeholder="https://images.unsplash.com/…">
      <span class="hint">Leave empty to use the default image.</span>
    </div>
    <div class="field">
      <label for="url">Article link</label>
      <input type="text" id="url" name="url" value="<?php echo e($editing['url']); ?>" placeholder="blog.php or https://…">
      <span class="hint">Where "Read more" goes. Leave empty to link to this post's article page.</span>
    </div>
    <div class="btn-row">
      <button type="submit" class="btn"><?php echo $editing['id'] !== '' ? 'Save changes' : 'Publish post'; ?></button>
      <a class="btn btn-outline" href="posts.php">Cancel</a>
    </div>
  </form>
</div>

<?php require_once __DIR__ . '/_footer.php'; ?>
