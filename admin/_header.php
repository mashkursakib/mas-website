<?php
// Shared admin page header. Expects $pageTitle and $active to be set.
require_once __DIR__ . '/../includes/functions.php';
require_login();
$flash = get_flash();
$defaultPass = using_default_password();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo e($pageTitle ?? 'Admin'); ?> — MAS Admin</title>
<link rel="stylesheet" href="admin.css">
</head>
<body>
<header class="admin-top">
  <a class="admin-brand" href="index.php">MAS <em>Admin</em></a>
  <nav class="admin-nav">
    <a href="index.php" class="<?php echo ($active ?? '') === 'dashboard' ? 'active' : ''; ?>">Dashboard</a>
    <a href="posts.php" class="<?php echo ($active ?? '') === 'posts' ? 'active' : ''; ?>">Blog Posts</a>
    <a href="settings.php" class="<?php echo ($active ?? '') === 'settings' ? 'active' : ''; ?>">Site Settings</a>
    <a href="../index.php" target="_blank" rel="noopener">View site ↗</a>
    <a href="logout.php">Log out</a>
  </nav>
</header>
<main class="admin-main">
<?php if ($defaultPass): ?>
  <div class="alert alert-warning">⚠️ You are still using the default password. <a href="settings.php#password">Change it now</a>.</div>
<?php endif; ?>
<?php if ($flash): ?>
  <div class="alert alert-<?php echo e($flash['type']); ?>"><?php echo e($flash['message']); ?></div>
<?php endif; ?>
