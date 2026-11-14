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

        if ($title === '' || $excerpt === '') {
            $error = 'Title and excerpt are required.';
        } elseif (!isset(POST_CATEGORIES[$category])) {
            $error = 'Please choose a valid category.';
        } elseif ($date !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            $error = 'Date must be YYYY-MM-DD.';
        } elseif ($image !== '' && !filter_var($image, FILTER_VALIDATE_URL)) {
            $error = 'Image must be a full URL (https://…).';
        } elseif ($url !== '' && !filter_var($url, FILTER_VALIDATE_URL) && !preg_match('/^[a-z0-9\-_.\/]+\.(php|html?)$/i', $url)) {
            $error = 'Link must be a full URL or a site page like blog.php.';
        } else {
            $record = [
                'id'       => $editing['id'] ?? uniqid('p'),
                'title'    => $title,
                'excerpt'  => $excerpt,
                'category' => $category,
                'date'     => $date !== '' ? $date : date('Y-m-d'),
                'image'    => $image,
                'url'      => $url !== '' ? $url : 'blog.php',
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
        'title'    => $_POST['title'] ?? '',
        'excerpt'  => $_POST['excerpt'] ?? '',
        'category' => $_POST['category'] ?? 'company-news',
        'date'     => $_POST['date'] ?? date('Y-m-d'),
        'image'    => $_POST['image'] ?? '',
        'url'      => $_POST['url'] ?? '',
    ];
}

$pageTitle = $editing ? 'Edit Post' : 'New Post';
$active = 'posts';
require_once __DIR__ . '/_header.php';

$editing = $editing ?? ['id' => '', 'title' => '', 'excerpt' => '', 'category' => 'company-news', 'date' => date('Y-m-d'), 'image' => '', 'url' => ''];
?>

<h1><?php echo $editing['id'] !== '' ? 'Edit Post' : 'New Blog Post'; ?></h1>
<p class="lede">The card shows on the blog page; the three newest also show on the homepage.</p>

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
      <label for="excerpt">Excerpt *</label>
      <textarea id="excerpt" name="excerpt" required maxlength="300"><?php echo e($editing['excerpt']); ?></textarea>
      <span class="hint">One or two sentences shown on the post card (max 300 characters).</span>
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
      <span class="hint">Where "Read more" goes. Leave as blog.php until full article pages exist.</span>
    </div>
    <div class="btn-row">
      <button type="submit" class="btn"><?php echo $editing['id'] !== '' ? 'Save changes' : 'Publish post'; ?></button>
      <a class="btn btn-outline" href="posts.php">Cancel</a>
    </div>
  </form>
</div>

<?php require_once __DIR__ . '/_footer.php'; ?>
