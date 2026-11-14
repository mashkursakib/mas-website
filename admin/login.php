<?php
// MAS Admin — login.
require_once __DIR__ . '/../includes/functions.php';

if (is_logged_in()) {
    redirect('index.php');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_check()) {
        $error = 'Session expired — please try again.';
    } else {
        $result = login_attempt($_POST['username'] ?? '', $_POST['password'] ?? '');
        if ($result['ok']) {
            redirect('index.php');
        }
        $error = $result['error'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Log in — MAS Admin</title>
<link rel="stylesheet" href="admin.css">
</head>
<body>
<div class="login-wrap">
  <div class="login-card">
    <h1>MAS <em style="color: var(--gold);">Admin</em></h1>
    <p class="lede">Log in to manage masconsultancy.org</p>
    <?php if ($error): ?>
      <div class="alert alert-error"><?php echo e($error); ?></div>
    <?php endif; ?>
    <form method="post" action="login.php" autocomplete="off">
      <?php echo csrf_field(); ?>
      <div class="field">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required autofocus autocomplete="username">
      </div>
      <div class="field">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required autocomplete="current-password">
      </div>
      <button type="submit" class="btn" style="width: 100%; justify-content: center;">Log in</button>
    </form>
    <p style="text-align: center; margin-top: 18px; font-size: .85rem; color: var(--muted);">
      <a href="../index.php">← Back to site</a>
    </p>
  </div>
</div>
</body>
</html>
