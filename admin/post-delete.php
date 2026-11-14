<?php
// MAS Admin — delete a blog post (POST only, CSRF protected).
require_once __DIR__ . '/../includes/functions.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_check()) {
    flash('Invalid request.', 'error');
    redirect('posts.php');
}

$id = $_POST['id'] ?? '';
$posts = load_posts();
$before = count($posts);
$posts = array_values(array_filter($posts, fn($p) => ($p['id'] ?? '') !== $id));

if (count($posts) === $before) {
    flash('Post not found.', 'error');
} elseif (save_posts($posts)) {
    flash('Post deleted.');
} else {
    flash('Could not save — check that data/posts.json is writable.', 'error');
}
redirect('posts.php');
