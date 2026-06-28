<?php
session_start();
$admin_username = "masadmin";
$admin_password = "MAS@2024Secure";
$dataFile = 'data.json';

// Handle Login
if(isset($_POST['login'])) {
    if($_POST['username'] === $admin_username && $_POST['password'] === $admin_password) {
        $_SESSION['loggedin'] = true;
        $_SESSION['login_time'] = time();
    } else {
        $error = "Incorrect username or password!";
    }
}

// Auto logout after 2 hours
if(isset($_SESSION['login_time']) && (time() - $_SESSION['login_time'] > 7200)) {
    session_destroy();
    header("Location: admin.php?timeout=1");
    exit;
}

// Handle Logout
if(isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}

// Load Data
$data = json_decode(file_get_contents($dataFile), true);
if(!$data) $data = ['blogs' => []];
if(!isset($data['blogs'])) $data['blogs'] = [];

// Save Text Changes
if(isset($_POST['save_text']) && isset($_SESSION['loggedin'])) {
    $fields = [
        'hero_title', 'hero_subtitle', 'about_text', 'about_text2',
        'stats_years', 'stats_projects', 'stats_clients', 'stats_us_clients',
        'contact_address', 'contact_phone_us', 'contact_phone_bd',
        'contact_email1', 'contact_email2', 'contact_hours'
    ];
    foreach($fields as $field) {
        if(isset($_POST[$field])) {
            $data[$field] = $_POST[$field];
        }
    }
    file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    $msg = "success:Website content updated successfully!";
}

// Add New Blog Post
if(isset($_POST['add_blog']) && isset($_SESSION['loggedin'])) {
    if(empty(trim($_POST['blog_title'])) || empty(trim($_POST['blog_content']))) {
        $msg = "error:Please fill in both title and content!";
    } else {
        // Handle image upload
        $imagePath = '';
        if(isset($_FILES['blog_image']) && $_FILES['blog_image']['error'] === 0) {
            $uploadDir = 'uploads/';
            if(!file_exists($uploadDir)) mkdir($uploadDir, 0755, true);
            $ext = strtolower(pathinfo($_FILES['blog_image']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if(in_array($ext, $allowed) && $_FILES['blog_image']['size'] < 5000000) {
                $filename = 'blog_' . time() . '.' . $ext;
                move_uploaded_file($_FILES['blog_image']['tmp_name'], $uploadDir . $filename);
                $imagePath = $uploadDir . $filename;
            }
        }

        $newPost = [
            'id' => time(),
            'title' => trim($_POST['blog_title']),
            'category' => $_POST['blog_category'],
            'content' => trim($_POST['blog_content']),
            'image' => $imagePath,
            'author' => $_POST['blog_author'],
            'date' => date('F j, Y'),
            'date_raw' => date('Y-m-d'),
            'featured' => isset($_POST['blog_featured']) ? true : false
        ];
        array_unshift($data['blogs'], $newPost);
        file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $msg = "success:Blog post published successfully!";
    }
}

// Edit Blog Post - Load
$editPost = null;
if(isset($_GET['edit']) && isset($_SESSION['loggedin'])) {
    foreach($data['blogs'] as $post) {
        if($post['id'] == $_GET['edit']) {
            $editPost = $post;
            break;
        }
    }
}

// Edit Blog Post - Save
if(isset($_POST['update_blog']) && isset($_SESSION['loggedin'])) {
    foreach($data['blogs'] as &$post) {
        if($post['id'] == $_POST['post_id']) {
            $post['title'] = trim($_POST['blog_title']);
            $post['category'] = $_POST['blog_category'];
            $post['content'] = trim($_POST['blog_content']);
            $post['author'] = $_POST['blog_author'];
            $post['featured'] = isset($_POST['blog_featured']) ? true : false;
            if(isset($_FILES['blog_image']) && $_FILES['blog_image']['error'] === 0) {
                $uploadDir = 'uploads/';
                if(!file_exists($uploadDir)) mkdir($uploadDir, 0755, true);
                $ext = strtolower(pathinfo($_FILES['blog_image']['name'], PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                if(in_array($ext, $allowed)) {
                    $filename = 'blog_' . time() . '.' . $ext;
                    move_uploaded_file($_FILES['blog_image']['tmp_name'], $uploadDir . $filename);
                    $post['image'] = $uploadDir . $filename;
                }
            }
            break;
        }
    }
    file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    $msg = "success:Post updated successfully!";
}

// Delete Blog Post
if(isset($_GET['delete']) && isset($_SESSION['loggedin'])) {
    $data['blogs'] = array_values(array_filter($data['blogs'], function($post) {
        return $post['id'] != $_GET['delete'];
    }));
    file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    header("Location: admin.php?tab=blog&deleted=1");
    exit;
}

$totalPosts = count($data['blogs']);
$featuredPosts = count(array_filter($data['blogs'], function($p){ return isset($p['featured']) && $p['featured']; }));
$activeTab = isset($_GET['tab']) ? $_GET['tab'] : 'dashboard';
if($editPost) $activeTab = 'blog';

// Parse message
$msgType = ''; $msgText = '';
if(isset($msg)) {
    $parts = explode(':', $msg, 2);
    $msgType = $parts[0];
    $msgText = $parts[1];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAS Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #f0f2f5; color: #1a1a1a; }

        /* LOGIN PAGE */
        .login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0d2318, #1a3a2a);
        }
        .login-box {
            background: white;
            padding: 50px 40px;
            border-radius: 16px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 80px rgba(0,0,0,0.3);
        }
        .login-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 30px;
            justify-content: center;
        }
        .login-logo-icon {
            width: 40px; height: 40px;
            background: #1a3a2a;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: white; font-weight: 800; font-size: 1.1rem;
        }
        .login-logo-text { font-size: 1.5rem; font-weight: 700; color: #1a3a2a; }
        .login-subtitle { text-align: center; color: #666; font-size: 0.9rem; margin-bottom: 35px; }
        .login-box label { font-size: 0.82rem; font-weight: 600; color: #333; display: block; margin-bottom: 6px; }
        .login-box input {
            width: 100%; padding: 13px 16px;
            border: 1.5px solid #e0e0e0;
            border-radius: 10px;
            font-size: 0.95rem;
            font-family: 'Inter', sans-serif;
            margin-bottom: 18px;
            outline: none;
            transition: border-color 0.2s;
        }
        .login-box input:focus { border-color: #2e7d4f; }
        .login-btn {
            width: 100%; padding: 14px;
            background: #1a3a2a; color: white;
            border: none; border-radius: 10px;
            font-size: 0.95rem; font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer; transition: background 0.2s;
        }
        .login-btn:hover { background: #2e7d4f; }
        .login-error {
            background: #fff3f3; color: #dc3545;
            border: 1px solid #ffcdd2;
            padding: 12px 16px; border-radius: 8px;
            margin-bottom: 20px; font-size: 0.88rem;
        }
        .login-timeout {
            background: #fff8e1; color: #856404;
            border: 1px solid #ffc107;
            padding: 12px 16px; border-radius: 8px;
            margin-bottom: 20px; font-size: 0.88rem;
        }

        /* ADMIN LAYOUT */
        .admin-layout { display: flex; min-height: 100vh; }

        /* SIDEBAR */
        .sidebar {
            width: 260px; background: #1a3a2a;
            display: flex; flex-direction: column;
            position: fixed; top: 0; left: 0; bottom: 0;
            z-index: 100;
        }
        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-logo {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none;
        }
        .sidebar-logo-icon {
            width: 36px; height: 36px;
            background: #2e7d4f; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: white; font-weight: 800;
        }
        .sidebar-logo-text { color: white; font-size: 1.1rem; font-weight: 700; }
        .sidebar-logo-sub { color: rgba(255,255,255,0.5); font-size: 0.72rem; display: block; }
        .sidebar-nav { padding: 20px 12px; flex: 1; }
        .sidebar-section-label {
            font-size: 0.65rem; font-weight: 700;
            letter-spacing: 0.12em;
            color: rgba(255,255,255,0.35);
            text-transform: uppercase;
            padding: 0 8px;
            margin: 20px 0 8px;
        }
        .sidebar-link {
            display: flex; align-items: center; gap: 12px;
            padding: 11px 12px; border-radius: 8px;
            text-decoration: none;
            color: rgba(255,255,255,0.7);
            font-size: 0.88rem; font-weight: 500;
            transition: all 0.2s;
            margin-bottom: 2px;
        }
        .sidebar-link:hover { background: rgba(255,255,255,0.08); color: white; }
        .sidebar-link.active { background: #2e7d4f; color: white; }
        .sidebar-link-icon { font-size: 1rem; width: 20px; text-align: center; }
        .sidebar-badge {
            margin-left: auto;
            background: #c9a84c; color: white;
            font-size: 0.7rem; font-weight: 700;
            padding: 2px 8px; border-radius: 50px;
        }
        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-user {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px; border-radius: 8px;
            margin-bottom: 8px;
        }
        .sidebar-user-avatar {
            width: 34px; height: 34px;
            background: #2e7d4f; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: white; font-weight: 700; font-size: 0.85rem;
        }
        .sidebar-user-name { color: white; font-size: 0.85rem; font-weight: 600; }
        .sidebar-user-role { color: rgba(255,255,255,0.4); font-size: 0.72rem; }
        .sidebar-logout {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px; border-radius: 8px;
            text-decoration: none; color: rgba(255,255,255,0.5);
            font-size: 0.85rem; transition: all 0.2s;
        }
        .sidebar-logout:hover { color: #ff6b6b; background: rgba(255,107,107,0.1); }

        /* MAIN CONTENT */
        .main-content { margin-left: 260px; flex: 1; }
        .topbar {
            background: white; padding: 16px 32px;
            display: flex; justify-content: space-between; align-items: center;
            border-bottom: 1px solid #e8e8e8;
            position: sticky; top: 0; z-index: 50;
        }
        .topbar-title { font-size: 1.1rem; font-weight: 700; color: #1a1a1a; }
        .topbar-breadcrumb { font-size: 0.8rem; color: #999; margin-top: 2px; }
        .topbar-actions { display: flex; align-items: center; gap: 12px; }
        .view-site-btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 16px; border-radius: 8px;
            background: #1a3a2a; color: white;
            text-decoration: none; font-size: 0.82rem;
            font-weight: 600; transition: background 0.2s;
        }
        .view-site-btn:hover { background: #2e7d4f; }

        .page-content { padding: 32px; }

        /* ALERT */
        .alert {
            padding: 14px 20px; border-radius: 10px;
            margin-bottom: 24px; font-size: 0.9rem;
            font-weight: 500; display: flex; align-items: center; gap: 10px;
        }
        .alert-success { background: #e8f5e9; color: #2e7d4f; border: 1px solid #c8e6c9; }
        .alert-error { background: #ffebee; color: #dc3545; border: 1px solid #ffcdd2; }

        /* STATS CARDS */
        .stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 32px; }
        .stat-card {
            background: white; border-radius: 12px;
            padding: 24px; border: 1px solid #e8e8e8;
        }
        .stat-card-label { font-size: 0.78rem; color: #999; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; }
        .stat-card-value { font-size: 2rem; font-weight: 800; color: #1a1a1a; margin: 8px 0 4px; }
        .stat-card-sub { font-size: 0.78rem; color: #2e7d4f; font-weight: 500; }
        .stat-card-icon { font-size: 1.5rem; margin-bottom: 10px; }

        /* CARDS */
        .card {
            background: white; border-radius: 12px;
            border: 1px solid #e8e8e8; overflow: hidden;
            margin-bottom: 24px;
        }
        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid #f0f0f0;
            display: flex; justify-content: space-between; align-items: center;
        }
        .card-title { font-size: 1rem; font-weight: 700; color: #1a1a1a; }
        .card-subtitle { font-size: 0.8rem; color: #999; margin-top: 2px; }
        .card-body { padding: 24px; }

        /* FORM ELEMENTS */
        .form-group { margin-bottom: 22px; }
        .form-label {
            font-size: 0.83rem; font-weight: 600; color: #333;
            display: block; margin-bottom: 8px;
        }
        .form-hint { font-size: 0.75rem; color: #999; margin-top: 4px; }
        .form-input, .form-select, .form-textarea {
            width: 100%; padding: 12px 16px;
            border: 1.5px solid #e0e0e0; border-radius: 8px;
            font-size: 0.9rem; font-family: 'Inter', sans-serif;
            color: #1a1a1a; background: white;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            border-color: #2e7d4f;
            box-shadow: 0 0 0 3px rgba(46,125,79,0.1);
        }
        .form-textarea { resize: vertical; min-height: 120px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; }

        /* BUTTONS */
        .btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 11px 22px; border-radius: 8px;
            font-size: 0.88rem; font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer; border: none;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-primary { background: #1a3a2a; color: white; }
        .btn-primary:hover { background: #2e7d4f; }
        .btn-success { background: #2e7d4f; color: white; }
        .btn-success:hover { background: #1a3a2a; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-danger:hover { background: #b02a37; }
        .btn-outline { background: white; color: #1a1a1a; border: 1.5px solid #e0e0e0; }
        .btn-outline:hover { border-color: #1a3a2a; color: #1a3a2a; }
        .btn-sm { padding: 7px 14px; font-size: 0.8rem; }
        .btn-gold { background: #c9a84c; color: white; }
        .btn-gold:hover { background: #a8862e; }

        /* BLOG TABLE */
        .blog-table { width: 100%; border-collapse: collapse; }
        .blog-table th {
            text-align: left; padding: 12px 16px;
            font-size: 0.75rem; font-weight: 700;
            color: #999; text-transform: uppercase;
            letter-spacing: 0.08em;
            border-bottom: 2px solid #f0f0f0;
        }
        .blog-table td {
            padding: 16px; border-bottom: 1px solid #f5f5f5;
            font-size: 0.88rem; vertical-align: middle;
        }
        .blog-table tr:last-child td { border-bottom: none; }
        .blog-table tr:hover td { background: #fafafa; }
        .blog-thumb {
            width: 60px; height: 45px;
            object-fit: cover; border-radius: 6px;
            background: #f0f0f0;
        }
        .blog-thumb-placeholder {
            width: 60px; height: 45px;
            background: #f0f0f0; border-radius: 6px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; color: #ccc;
        }
        .category-badge {
            display: inline-block;
            padding: 3px 10px; border-radius: 50px;
            font-size: 0.72rem; font-weight: 600;
        }
        .cat-eprocurement { background: #e8f5e9; color: #2e7d4f; }
        .cat-webdev { background: #e3f2fd; color: #1565c0; }
        .cat-consultancy { background: #fce4ec; color: #c62828; }
        .cat-news { background: #fff8e1; color: #f57f17; }
        .cat-general { background: #f3e5f5; color: #6a1b9a; }
        .featured-badge {
            display: inline-block;
            background: #fff8e1; color: #c9a84c;
            border: 1px solid #c9a84c;
            padding: 2px 8px; border-radius: 50px;
            font-size: 0.68rem; font-weight: 700;
        }
        .empty-state {
            text-align: center; padding: 60px 20px;
            color: #999;
        }
        .empty-state-icon { font-size: 3rem; margin-bottom: 16px; }
        .empty-state h3 { color: #333; margin-bottom: 8px; }

        /* IMAGE UPLOAD */
        .image-upload-area {
            border: 2px dashed #e0e0e0; border-radius: 8px;
            padding: 30px; text-align: center;
            cursor: pointer; transition: all 0.2s;
        }
        .image-upload-area:hover { border-color: #2e7d4f; background: #f9fffe; }
        .image-upload-area input { display: none; }
        .image-preview {
            max-width: 200px; max-height: 150px;
            border-radius: 8px; margin-top: 12px;
            display: none;
        }

        /* CHECKBOX */
        .form-check { display: flex; align-items: center; gap: 10px; }
        .form-check input[type="checkbox"] { width: 18px; height: 18px; cursor: pointer; accent-color: #2e7d4f; }
        .form-check label { font-size: 0.88rem; color: #555; cursor: pointer; }

        /* SECTION DIVIDER */
        .section-divider { border: none; border-top: 1px solid #f0f0f0; margin: 24px 0; }

        /* ACTION BUTTONS */
        .action-group { display: flex; gap: 8px; }

        /* RESPONSIVE */
        @media(max-width: 768px) {
            .sidebar { transform: translateX(-260px); transition: transform 0.3s; }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .stats-row { grid-template-columns: 1fr 1fr; }
            .form-row, .form-row-3 { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<?php if(!isset($_SESSION['loggedin'])): ?>
<!-- LOGIN PAGE -->
<div class="login-page">
    <div class="login-box">
        <div class="login-logo">
            <div class="login-logo-icon">M</div>
            <div class="login-logo-text">MAS Admin</div>
        </div>
        <p class="login-subtitle">Sign in to manage your website content</p>
        <?php if(isset($_GET['timeout'])): ?>
            <div class="login-timeout">⏰ Session expired. Please log in again.</div>
        <?php endif; ?>
        <?php if(isset($error)) echo "<div class='login-error'>❌ $error</div>"; ?>
        <form method="POST">
            <label>Username</label>
            <input type="text" name="username" placeholder="Enter username" required autocomplete="username">
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter password" required autocomplete="current-password">
            <button type="submit" name="login" class="login-btn">Sign In →</button>
        </form>
    </div>
</div>

<?php else: ?>
<!-- ADMIN DASHBOARD -->
<div class="admin-layout">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <a href="admin.php" class="sidebar-logo">
                <div class="sidebar-logo-icon">M</div>
                <div>
                    <div class="sidebar-logo-text">MAS Panel</div>
                    <span class="sidebar-logo-sub">masconsultancy.org</span>
                </div>
            </a>
        </div>

        <nav class="sidebar-nav">
            <div class="sidebar-section-label">Main</div>
            <a href="admin.php?tab=dashboard" class="sidebar-link <?php echo $activeTab=='dashboard'?'active':''; ?>">
                <span class="sidebar-link-icon">📊</span> Dashboard
            </a>

            <div class="sidebar-section-label">Content</div>
            <a href="admin.php?tab=homepage" class="sidebar-link <?php echo $activeTab=='homepage'?'active':''; ?>">
                <span class="sidebar-link-icon">🏠</span> Homepage Text
            </a>
            <a href="admin.php?tab=contact" class="sidebar-link <?php echo $activeTab=='contact'?'active':''; ?>">
                <span class="sidebar-link-icon">📞</span> Contact Info
            </a>
            <a href="admin.php?tab=stats" class="sidebar-link <?php echo $activeTab=='stats'?'active':''; ?>">
                <span class="sidebar-link-icon">📈</span> Stats & Numbers
            </a>

            <div class="sidebar-section-label">Blog & News</div>
            <a href="admin.php?tab=blog" class="sidebar-link <?php echo $activeTab=='blog'?'active':''; ?>">
                <span class="sidebar-link-icon">✍️</span> All Posts
                <?php if($totalPosts > 0): ?><span class="sidebar-badge"><?php echo $totalPosts; ?></span><?php endif; ?>
            </a>
            <a href="admin.php?tab=new_post" class="sidebar-link <?php echo $activeTab=='new_post'?'active':''; ?>">
                <span class="sidebar-link-icon">➕</span> New Post
            </a>

            <div class="sidebar-section-label">Site</div>
            <a href="index.php" target="_blank" class="sidebar-link">
                <span class="sidebar-link-icon">🌐</span> View Website
            </a>
            <a href="blog.php" target="_blank" class="sidebar-link">
                <span class="sidebar-link-icon">📰</span> View Blog
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="sidebar-user-avatar">A</div>
                <div>
                    <div class="sidebar-user-name">Admin</div>
                    <div class="sidebar-user-role">MAS Administrator</div>
                </div>
            </div>
            <a href="?logout=1" class="sidebar-logout">🚪 Sign Out</a>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <!-- TOPBAR -->
        <div class="topbar">
            <div>
                <div class="topbar-title">
                    <?php
                    $titles = [
                        'dashboard' => 'Dashboard',
                        'homepage' => 'Homepage Content',
                        'contact' => 'Contact Information',
                        'stats' => 'Stats & Numbers',
                        'blog' => 'Blog & News Posts',
                        'new_post' => 'New Blog Post'
                    ];
                    echo $titles[$activeTab] ?? 'Admin Panel';
                    ?>
                </div>
                <div class="topbar-breadcrumb">MAS Admin → <?php echo $titles[$activeTab] ?? 'Admin Panel'; ?></div>
            </div>
            <div class="topbar-actions">
                <a href="blog.php" target="_blank" class="view-site-btn">📰 View Blog</a>
                <a href="index.php" target="_blank" class="view-site-btn">🌐 View Site</a>
            </div>
        </div>

        <div class="page-content">

            <!-- ALERT -->
            <?php if($msgText): ?>
                <div class="alert alert-<?php echo $msgType; ?>">
                    <?php echo $msgType === 'success' ? '✅' : '❌'; ?> <?php echo $msgText; ?>
                </div>
            <?php endif; ?>
            <?php if(isset($_GET['deleted'])): ?>
                <div class="alert alert-success">✅ Blog post deleted successfully!</div>
            <?php endif; ?>

            <!-- ===== DASHBOARD ===== -->
            <?php if($activeTab === 'dashboard'): ?>
                <div class="stats-row">
                    <div class="stat-card">
                        <div class="stat-card-icon">📝</div>
                        <div class="stat-card-label">Total Posts</div>
                        <div class="stat-card-value"><?php echo $totalPosts; ?></div>
                        <div class="stat-card-sub">Blog & News articles</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-icon">⭐</div>
                        <div class="stat-card-label">Featured Posts</div>
                        <div class="stat-card-value"><?php echo $featuredPosts; ?></div>
                        <div class="stat-card-sub">Shown on homepage</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-icon">🌐</div>
                        <div class="stat-card-label">Domain</div>
                        <div class="stat-card-value" style="font-size:1rem; padding-top:6px;">masconsultancy.org</div>
                        <div class="stat-card-sub" style="color:#2e7d4f;">● Live</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-icon">🏢</div>
                        <div class="stat-card-label">Sister Concerns</div>
                        <div class="stat-card-value">3</div>
                        <div class="stat-card-sub">Corp, Comm, Consult</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div>
                            <div class="card-title">Quick Actions</div>
                            <div class="card-subtitle">Common tasks you can do right now</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div style="display:flex; flex-wrap:wrap; gap:12px;">
                            <a href="admin.php?tab=new_post" class="btn btn-success">✍️ Write New Post</a>
                            <a href="admin.php?tab=homepage" class="btn btn-primary">🏠 Edit Homepage</a>
                            <a href="admin.php?tab=contact" class="btn btn-primary">📞 Update Contact</a>
                            <a href="admin.php?tab=stats" class="btn btn-primary">📈 Update Stats</a>
                            <a href="index.php" target="_blank" class="btn btn-outline">🌐 View Live Site</a>
                        </div>
                    </div>
                </div>

                <?php if(!empty($data['blogs'])): ?>
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Recent Posts</div>
                        <a href="admin.php?tab=blog" class="btn btn-outline btn-sm">View All</a>
                    </div>
                    <div class="card-body" style="padding:0;">
                        <table class="blog-table">
                            <thead><tr><th>Title</th><th>Category</th><th>Date</th><th>Action</th></tr></thead>
                            <tbody>
                            <?php foreach(array_slice($data['blogs'], 0, 5) as $post): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($post['title']); ?></strong></td>
                                    <td><span class="category-badge cat-<?php echo $post['category']??'general'; ?>"><?php echo ucfirst($post['category']??'general'); ?></span></td>
                                    <td><?php echo $post['date']; ?></td>
                                    <td>
                                        <a href="admin.php?edit=<?php echo $post['id']; ?>" class="btn btn-outline btn-sm">Edit</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>

            <!-- ===== HOMEPAGE TEXT ===== -->
            <?php elseif($activeTab === 'homepage'): ?>
                <form method="POST">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <div class="card-title">Hero Section</div>
                                <div class="card-subtitle">The main text visitors see first</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label">Hero Main Title</label>
                                <input type="text" name="hero_title" class="form-input" value="<?php echo htmlspecialchars($data['hero_title']??''); ?>">
                                <div class="form-hint">The large heading text. "Smart Technology" in gold italic is always shown after this.</div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Hero Subtitle / Description</label>
                                <textarea name="hero_subtitle" class="form-textarea" rows="4"><?php echo htmlspecialchars($data['hero_subtitle']??''); ?></textarea>
                                <div class="form-hint">The paragraph below the main title.</div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">About Us Section</div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label">About Us - First Paragraph</label>
                                <textarea name="about_text" class="form-textarea" rows="4"><?php echo htmlspecialchars($data['about_text']??''); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">About Us - Second Paragraph</label>
                                <textarea name="about_text2" class="form-textarea" rows="4"><?php echo htmlspecialchars($data['about_text2']??''); ?></textarea>
                            </div>
                        </div>
                    </div>

                    <button type="submit" name="save_text" class="btn btn-success">💾 Save All Changes</button>
                </form>

            <!-- ===== CONTACT INFO ===== -->
            <?php elseif($activeTab === 'contact'): ?>
                <form method="POST">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Contact Information</div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label">Office Address</label>
                                <textarea name="contact_address" class="form-textarea" rows="2"><?php echo htmlspecialchars($data['contact_address']??''); ?></textarea>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">US Phone Number</label>
                                    <input type="text" name="contact_phone_us" class="form-input" value="<?php echo htmlspecialchars($data['contact_phone_us']??''); ?>" placeholder="+1 (347) 000-0000">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Bangladesh Phone Number</label>
                                    <input type="text" name="contact_phone_bd" class="form-input" value="<?php echo htmlspecialchars($data['contact_phone_bd']??''); ?>" placeholder="+880-1700-000000">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Primary Email</label>
                                    <input type="email" name="contact_email1" class="form-input" value="<?php echo htmlspecialchars($data['contact_email1']??''); ?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Business Email</label>
                                    <input type="email" name="contact_email2" class="form-input" value="<?php echo htmlspecialchars($data['contact_email2']??''); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Business Hours</label>
                                <input type="text" name="contact_hours" class="form-input" value="<?php echo htmlspecialchars($data['contact_hours']??''); ?>" placeholder="Sun - Thu: 9:00 AM - 6:00 PM">
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="save_text" class="btn btn-success">💾 Save Contact Info</button>
                </form>

            <!-- ===== STATS ===== -->
            <?php elseif($activeTab === 'stats'): ?>
                <form method="POST">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <div class="card-title">Homepage Statistics</div>
                                <div class="card-subtitle">Numbers shown in the hero section (numbers only, + is added automatically)</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-row-3" style="grid-template-columns: 1fr 1fr 1fr 1fr;">
                                <div class="form-group">
                                    <label class="form-label">Years of Excellence</label>
                                    <input type="number" name="stats_years" class="form-input" value="<?php echo htmlspecialchars($data['stats_years']??'10'); ?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Projects Completed</label>
                                    <input type="number" name="stats_projects" class="form-input" value="<?php echo htmlspecialchars($data['stats_projects']??'300'); ?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Clients Served</label>
                                    <input type="number" name="stats_clients" class="form-input" value="<?php echo htmlspecialchars($data['stats_clients']??'150'); ?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">US Clients Served</label>
                                    <input type="number" name="stats_us_clients" class="form-input" value="<?php echo htmlspecialchars($data['stats_us_clients']??'40'); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="save_text" class="btn btn-success">💾 Save Statistics</button>
                </form>

            <!-- ===== ALL BLOG POSTS ===== -->
            <?php elseif($activeTab === 'blog'): ?>
                <div style="display:flex; justify-content:flex-end; margin-bottom:20px;">
                    <a href="admin.php?tab=new_post" class="btn btn-success">✍️ Write New Post</a>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div>
                            <div class="card-title">All Blog Posts</div>
                            <div class="card-subtitle"><?php echo $totalPosts; ?> total posts</div>
                        </div>
                    </div>
                    <div class="card-body" style="padding:0;">
                        <?php if(empty($data['blogs'])): ?>
                            <div class="empty-state">
                                <div class="empty-state-icon">📝</div>
                                <h3>No posts yet</h3>
                                <p>Write your first blog post to get started.</p>
                                <br>
                                <a href="admin.php?tab=new_post" class="btn btn-success">✍️ Write First Post</a>
                            </div>
                        <?php else: ?>
                        <table class="blog-table">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Title & Author</th>
                                    <th>Category</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($data['blogs'] as $post): ?>
                                <tr>
                                    <td>
                                        <?php if(!empty($post['image'])): ?>
                                            <img src="<?php echo htmlspecialchars($post['image']); ?>" class="blog-thumb" alt="">
                                        <?php else: ?>
                                            <div class="blog-thumb-placeholder">📄</div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($post['title']); ?></strong><br>
                                        <small style="color:#999;">by <?php echo htmlspecialchars($post['author']??'MAS Team'); ?></small>
                                    </td>
                                    <td>
                                        <span class="category-badge cat-<?php echo $post['category']??'general'; ?>">
                                            <?php echo ucfirst($post['category']??'general'); ?>
                                        </span>
                                    </td>
                                    <td style="color:#999; white-space:nowrap;"><?php echo $post['date']; ?></td>
                                    <td>
                                        <?php if(!empty($post['featured'])): ?>
                                            <span class="featured-badge">⭐ Featured</span>
                                        <?php else: ?>
                                            <span style="color:#ccc; font-size:0.78rem;">Standard</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="action-group">
                                            <a href="admin.php?edit=<?php echo $post['id']; ?>" class="btn btn-outline btn-sm">✏️ Edit</a>
                                            <a href="admin.php?delete=<?php echo $post['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this post?')">🗑️</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php endif; ?>
                    </div>
                </div>

            <!-- ===== NEW POST ===== -->
            <?php elseif($activeTab === 'new_post' || $editPost): ?>
                <form method="POST" enctype="multipart/form-data">
                    <?php if($editPost): ?>
                        <input type="hidden" name="post_id" value="<?php echo $editPost['id']; ?>">
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-header">
                            <div class="card-title"><?php echo $editPost ? 'Edit Post' : 'Write New Blog Post'; ?></div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label">Post Title *</label>
                                <input type="text" name="blog_title" class="form-input"
                                    value="<?php echo htmlspecialchars($editPost['title']??''); ?>"
                                    placeholder="e.g., MAS Corporation wins major government contract" required>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Category</label>
                                    <select name="blog_category" class="form-select">
                                        <?php
                                        $cats = ['news'=>'Company News','eprocurement'=>'E-Procurement','webdev'=>'Web Development','consultancy'=>'Consultancy','general'=>'General'];
                                        foreach($cats as $val=>$label):
                                            $sel = ($editPost['category']??'news') === $val ? 'selected' : '';
                                        ?>
                                            <option value="<?php echo $val; ?>" <?php echo $sel; ?>><?php echo $label; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Author Name</label>
                                    <input type="text" name="blog_author" class="form-input"
                                        value="<?php echo htmlspecialchars($editPost['author']??'MAS Team'); ?>"
                                        placeholder="MAS Team">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Content *</label>
                                <textarea name="blog_content" class="form-textarea" rows="12"
                                    placeholder="Write your full blog post or news article here..." required><?php echo htmlspecialchars($editPost['content']??''); ?></textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Featured Image</label>
                                <div class="image-upload-area" onclick="document.getElementById('blogImage').click()">
                                    <input type="file" id="blogImage" name="blog_image" accept="image/*" onchange="previewImage(this)">
                                    <div id="uploadText">
                                        📷 Click to upload an image<br>
                                        <small style="color:#999;">JPG, PNG, GIF, WebP — Max 5MB</small>
                                    </div>
                                    <img id="imagePreview" class="image-preview">
                                    <?php if(!empty($editPost['image'])): ?>
                                        <br><img src="<?php echo htmlspecialchars($editPost['image']); ?>" style="max-width:200px; border-radius:8px; margin-top:10px;">
                                        <br><small style="color:#999;">Current image (upload new to replace)</small>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-check">
                                <input type="checkbox" name="blog_featured" id="featured"
                                    <?php echo (!empty($editPost['featured'])) ? 'checked' : ''; ?>>
                                <label for="featured">⭐ Mark as Featured (shows on homepage)</label>
                            </div>
                        </div>
                    </div>

                    <div style="display:flex; gap:12px;">
                        <?php if($editPost): ?>
                            <button type="submit" name="update_blog" class="btn btn-success">💾 Update Post</button>
                            <a href="admin.php?tab=blog" class="btn btn-outline">Cancel</a>
                        <?php else: ?>
                            <button type="submit" name="add_blog" class="btn btn-success">🚀 Publish Post</button>
                            <a href="admin.php?tab=blog" class="btn btn-outline">Cancel</a>
                        <?php endif; ?>
                    </div>
                </form>

            <?php endif; ?>

        </div><!-- /page-content -->
    </div><!-- /main-content -->
</div><!-- /admin-layout -->

<script>
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        const uploadText = document.getElementById('uploadText');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                uploadText.style.display = 'none';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Auto-hide alerts
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(function() { alert.remove(); }, 500);
        });
    }, 4000);
</script>

<?php endif; ?>
</body>
</html>