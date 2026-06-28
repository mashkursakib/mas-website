<?php
$dataFile = 'data.json';
$data = json_decode(file_get_contents($dataFile), true);
if(!$data) $data = ['blogs' => []];
$blogs = $data['blogs'] ?? [];
$totalPosts = count($blogs);

// Single post view
$viewPost = null;
if(isset($_GET['post'])) {
    foreach($blogs as $post) {
        if($post['id'] == $_GET['post']) {
            $viewPost = $post;
            break;
        }
    }
}

// Category filter
$filterCat = isset($_GET['cat']) ? $_GET['cat'] : '';
if($filterCat) {
    $blogs = array_filter($blogs, function($p) use ($filterCat) {
        return ($p['category']??'general') === $filterCat;
    });
}

$categoryLabels = [
    'news' => 'Company News',
    'eprocurement' => 'E-Procurement',
    'webdev' => 'Web Development',
    'consultancy' => 'Consultancy',
    'general' => 'General'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $viewPost ? htmlspecialchars($viewPost['title']).' - ' : ''; ?>News & Blog - MAS Consultancy</title>
    <meta name="description" content="Latest news, insights and updates from MAS Corporation, MAS Communication and MAS Consultancy.">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,800;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --green-dark: #1a3a2a;
            --green-main: #2e7d4f;
            --gold: #c9a84c;
            --cream: #f5f3ee;
            --white: #ffffff;
            --text-dark: #1a1a1a;
            --text-light: #666;
            --border: #e0ddd6;
        }
        body { font-family: 'Inter', sans-serif; background: var(--cream); color: var(--text-dark); }

        /* NAVBAR */
        .navbar {
            background: var(--green-dark);
            padding: 0 40px; height: 70px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 100;
        }
        .navbar-logo {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none; color: white;
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem; font-weight: 700;
        }
        .navbar-logo-icon {
            width: 32px; height: 32px; background: var(--green-main);
            border-radius: 7px; display: flex; align-items: center;
            justify-content: center; font-weight: 800; font-size: 0.9rem;
        }
        .navbar-links { display: flex; align-items: center; gap: 6px; list-style: none; }
        .navbar-links a {
            color: rgba(255,255,255,0.8); text-decoration: none;
            font-size: 0.875rem; font-weight: 500;
            padding: 8px 14px; border-radius: 6px; transition: all 0.2s;
        }
        .navbar-links a:hover { color: white; background: rgba(255,255,255,0.1); }
        .navbar-links a.active { color: white; background: var(--green-main); }

        /* HERO */
        .blog-hero {
            background: var(--green-dark);
            padding: 70px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .blog-hero::before {
            content: '';
            position: absolute; inset: 0;
            background: url('https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=1200&q=80') center/cover;
            opacity: 0.1;
        }
        .blog-hero-content { position: relative; z-index: 1; }
        .blog-hero-badge {
            display: inline-block;
            background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);
            color: rgba(255,255,255,0.9); font-size: 0.72rem;
            font-weight: 700; letter-spacing: 0.12em;
            padding: 6px 16px; border-radius: 50px; margin-bottom: 20px;
        }
        .blog-hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 5vw, 3.5rem);
            color: white; font-weight: 800;
            margin-bottom: 16px;
        }
        .blog-hero p { color: rgba(255,255,255,0.7); font-size: 1rem; max-width: 500px; margin: 0 auto; }

        /* MAIN LAYOUT */
        .blog-main { max-width: 1200px; margin: 0 auto; padding: 60px 40px; }

        /* CATEGORY FILTER */
        .cat-filter {
            display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 40px;
        }
        .cat-btn {
            padding: 8px 20px; border-radius: 50px;
            border: 1.5px solid var(--border);
            background: white; color: var(--text-light);
            font-size: 0.82rem; font-weight: 600;
            text-decoration: none; transition: all 0.2s;
        }
        .cat-btn:hover { border-color: var(--green-main); color: var(--green-main); }
        .cat-btn.active { background: var(--green-dark); border-color: var(--green-dark); color: white; }

        /* FEATURED POST */
        .featured-post {
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 0; background: white;
            border-radius: 20px; overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            margin-bottom: 50px;
            text-decoration: none; color: inherit;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .featured-post:hover { transform: translateY(-4px); box-shadow: 0 20px 60px rgba(0,0,0,0.12); }
        .featured-post-img {
            height: 360px; object-fit: cover;
            background: linear-gradient(135deg, var(--green-dark), #2d5a3d);
        }
        .featured-post-img img { width: 100%; height: 100%; object-fit: cover; }
        .featured-post-img-placeholder {
            height: 360px;
            background: linear-gradient(135deg, var(--green-dark), #2d5a3d);
            display: flex; align-items: center; justify-content: center;
            font-size: 4rem;
        }
        .featured-post-body { padding: 50px 40px; display: flex; flex-direction: column; justify-content: center; }
        .featured-label {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(201,168,76,0.1); color: var(--gold);
            border: 1px solid rgba(201,168,76,0.3);
            font-size: 0.72rem; font-weight: 700;
            letter-spacing: 0.1em; padding: 5px 14px;
            border-radius: 50px; margin-bottom: 16px; width: fit-content;
        }
        .featured-post-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem; font-weight: 800;
            color: var(--text-dark); margin-bottom: 14px; line-height: 1.3;
        }
        .featured-post-excerpt { color: var(--text-light); font-size: 0.92rem; line-height: 1.8; margin-bottom: 24px; }
        .featured-post-meta { display: flex; align-items: center; gap: 16px; }
        .post-meta-item { font-size: 0.78rem; color: #999; }
        .post-meta-item strong { color: var(--green-main); }

        /* BLOG GRID */
        .blog-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; }

        .blog-card {
            background: white; border-radius: 16px;
            overflow: hidden; border: 1px solid var(--border);
            text-decoration: none; color: inherit;
            transition: all 0.3s; display: flex; flex-direction: column;
        }
        .blog-card:hover { transform: translateY(-5px); box-shadow: 0 15px 50px rgba(0,0,0,0.1); border-color: transparent; }

        .blog-card-img { height: 200px; overflow: hidden; }
        .blog-card-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s; }
        .blog-card:hover .blog-card-img img { transform: scale(1.05); }
        .blog-card-img-placeholder {
            height: 200px;
            background: linear-gradient(135deg, #e8f5ee, #c8e6d8);
            display: flex; align-items: center; justify-content: center;
            font-size: 2.5rem; color: var(--green-main);
        }

        .blog-card-body { padding: 24px; flex: 1; display: flex; flex-direction: column; }
        .blog-card-category {
            font-size: 0.68rem; font-weight: 700;
            letter-spacing: 0.1em; text-transform: uppercase;
            color: var(--green-main); margin-bottom: 10px;
        }
        .blog-card-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.15rem; font-weight: 700;
            color: var(--text-dark); margin-bottom: 10px;
            line-height: 1.4;
        }
        .blog-card-excerpt { font-size: 0.83rem; color: var(--text-light); line-height: 1.7; flex: 1; }
        .blog-card-footer {
            display: flex; justify-content: space-between; align-items: center;
            margin-top: 20px; padding-top: 16px;
            border-top: 1px solid #f0f0f0;
        }
        .blog-card-date { font-size: 0.75rem; color: #bbb; }
        .blog-card-read { font-size: 0.78rem; font-weight: 600; color: var(--green-main); }

        /* SINGLE POST */
        .single-post { max-width: 800px; margin: 0 auto; padding: 60px 40px; }
        .single-back {
            display: inline-flex; align-items: center; gap: 6px;
            color: var(--green-main); text-decoration: none;
            font-size: 0.88rem; font-weight: 600;
            margin-bottom: 30px; transition: gap 0.2s;
        }
        .single-back:hover { gap: 10px; }
        .single-category {
            display: inline-block;
            background: rgba(46,125,79,0.1); color: var(--green-main);
            font-size: 0.72rem; font-weight: 700;
            letter-spacing: 0.1em; padding: 5px 14px;
            border-radius: 50px; margin-bottom: 16px;
        }
        .single-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.8rem, 4vw, 2.8rem);
            font-weight: 800; color: var(--text-dark);
            line-height: 1.2; margin-bottom: 20px;
        }
        .single-meta {
            display: flex; align-items: center; gap: 20px;
            padding: 16px 0; border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border); margin-bottom: 36px;
        }
        .single-meta-item { font-size: 0.82rem; color: #999; }
        .single-meta-item strong { color: var(--text-dark); }
        .single-img {
            width: 100%; border-radius: 16px; margin-bottom: 40px;
            max-height: 500px; object-fit: cover;
        }
        .single-content {
            font-size: 1rem; line-height: 1.9; color: #333;
        }
        .single-content p { margin-bottom: 20px; }
        .single-footer {
            margin-top: 60px; padding-top: 30px;
            border-top: 1px solid var(--border);
            text-align: center;
        }
        .single-footer a {
            display: inline-flex; align-items: center; gap: 8px;
            background: var(--green-dark); color: white;
            padding: 14px 28px; border-radius: 10px;
            font-size: 0.9rem; font-weight: 600;
            text-decoration: none; transition: background 0.2s;
        }
        .single-footer a:hover { background: var(--green-main); }

        /* EMPTY STATE */
        .empty-state { text-align: center; padding: 80px 20px; }
        .empty-state-icon { font-size: 4rem; margin-bottom: 20px; }
        .empty-state h3 { font-family: 'Playfair Display', serif; font-size: 1.5rem; margin-bottom: 10px; }
        .empty-state p { color: var(--text-light); font-size: 0.9rem; }

        /* FOOTER */
        .blog-footer {
            background: var(--green-dark); color: rgba(255,255,255,0.6);
            text-align: center; padding: 30px;
            font-size: 0.85rem; margin-top: 80px;
        }
        .blog-footer a { color: var(--gold); text-decoration: none; }

        @media(max-width: 768px) {
            .navbar { padding: 0 20px; }
            .blog-hero { padding: 50px 20px; }
            .blog-main { padding: 40px 20px; }
            .featured-post { grid-template-columns: 1fr; }
            .featured-post-img { height: 220px; }
            .blog-grid { grid-template-columns: 1fr; }
            .single-post { padding: 40px 20px; }
        }
        @media(max-width: 1024px) {
            .blog-grid { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <a href="index.php" class="navbar-logo">
        <div class="navbar-logo-icon">M</div>
        MAS
    </a>
    <ul class="navbar-links">
        <li><a href="index.php#about">About Us</a></li>
        <li><a href="index.php#services">Services</a></li>
        <li><a href="index.php#eprocurement">E-Procurement</a></li>
        <li><a href="index.php#webdev">Web Dev</a></li>
        <li><a href="blog.php" class="active">News & Blog</a></li>
        <li><a href="index.php#contact">Contact</a></li>
    </ul>
</nav>

<?php if($viewPost): ?>
<!-- ===== SINGLE POST ===== -->
<div class="single-post">
    <a href="blog.php" class="single-back">← Back to all posts</a>
    <div>
        <span class="single-category"><?php echo strtoupper($categoryLabels[$viewPost['category']??'general']??'GENERAL'); ?></span>
        <h1 class="single-title"><?php echo htmlspecialchars($viewPost['title']); ?></h1>
        <div class="single-meta">
            <div class="single-meta-item">✍️ <strong><?php echo htmlspecialchars($viewPost['author']??'MAS Team'); ?></strong></div>
            <div class="single-meta-item">📅 <strong><?php echo $viewPost['date']; ?></strong></div>
            <div class="single-meta-item">🏷️ <strong><?php echo $categoryLabels[$viewPost['category']??'general']??'General'; ?></strong></div>
        </div>
        <?php if(!empty($viewPost['image'])): ?>
            <img src="<?php echo htmlspecialchars($viewPost['image']); ?>" class="single-img" alt="<?php echo htmlspecialchars($viewPost['title']); ?>">
        <?php endif; ?>
        <div class="single-content">
            <?php echo nl2br(htmlspecialchars($viewPost['content'])); ?>
        </div>
        <div class="single-footer">
            <a href="blog.php">← Browse All Articles</a>
        </div>
    </div>
</div>

<?php else: ?>
<!-- ===== BLOG LISTING ===== -->

<!-- HERO -->
<div class="blog-hero">
    <div class="blog-hero-content">
        <div class="blog-hero-badge">NEWS & INSIGHTS</div>
        <h1>Latest from MAS Group</h1>
        <p>Updates, insights, and news from MAS Corporation, MAS Communication, and MAS Consultancy.</p>
    </div>
</div>

<div class="blog-main">

    <!-- CATEGORY FILTER -->
    <div class="cat-filter">
        <a href="blog.php" class="cat-btn <?php echo !$filterCat?'active':''; ?>">All Posts (<?php echo count($data['blogs']); ?>)</a>
        <?php foreach($categoryLabels as $val => $label):
            $count = count(array_filter($data['blogs'], function($p) use($val){ return ($p['category']??'general')===$val; }));
            if($count > 0):
        ?>
            <a href="blog.php?cat=<?php echo $val; ?>" class="cat-btn <?php echo $filterCat===$val?'active':''; ?>">
                <?php echo $label; ?> (<?php echo $count; ?>)
            </a>
        <?php endif; endforeach; ?>
    </div>

    <?php
    $blogsArray = array_values($blogs);
    $featuredPosts = array_filter($blogsArray, function($p){ return !empty($p['featured']); });
    $topFeatured = !empty($featuredPosts) ? array_values($featuredPosts)[0] : (!empty($blogsArray) ? $blogsArray[0] : null);
    ?>

    <?php if(empty($blogsArray)): ?>
        <div class="empty-state">
            <div class="empty-state-icon">📰</div>
            <h3>No posts yet</h3>
            <p>Check back soon for news and updates from the MAS Group.</p>
        </div>

    <?php else: ?>

        <!-- FEATURED / LATEST POST -->
        <?php if($topFeatured && !$filterCat): ?>
        <a href="blog.php?post=<?php echo $topFeatured['id']; ?>" class="featured-post">
            <div class="featured-post-img">
                <?php if(!empty($topFeatured['image'])): ?>
                    <img src="<?php echo htmlspecialchars($topFeatured['image']); ?>" alt="">
                <?php else: ?>
                    <div class="featured-post-img-placeholder">📰</div>
                <?php endif; ?>
            </div>
            <div class="featured-post-body">
                <div class="featured-label">
                    ⭐ <?php echo !empty($topFeatured['featured']) ? 'Featured Post' : 'Latest Post'; ?>
                </div>
                <div class="featured-post-title"><?php echo htmlspecialchars($topFeatured['title']); ?></div>
                <div class="featured-post-excerpt">
                    <?php echo htmlspecialchars(substr($topFeatured['content'], 0, 180)) . (strlen($topFeatured['content']) > 180 ? '...' : ''); ?>
                </div>
                <div class="featured-post-meta">
                    <div class="post-meta-item">By <strong><?php echo htmlspecialchars($topFeatured['author']??'MAS Team'); ?></strong></div>
                    <div class="post-meta-item"><?php echo $topFeatured['date']; ?></div>
                    <div class="post-meta-item"><strong><?php echo $categoryLabels[$topFeatured['category']??'general']??'General'; ?></strong></div>
                </div>
            </div>
        </a>
        <?php endif; ?>

        <!-- BLOG GRID -->
        <div class="blog-grid">
            <?php
            $startIdx = (!$filterCat && $topFeatured) ? 1 : 0;
            $postsToShow = array_slice($blogsArray, $startIdx);
            foreach($postsToShow as $post):
                $excerpt = htmlspecialchars(substr($post['content'], 0, 120)) . (strlen($post['content']) > 120 ? '...' : '');
            ?>
            <a href="blog.php?post=<?php echo $post['id']; ?>" class="blog-card">
                <div class="blog-card-img">
                    <?php if(!empty($post['image'])): ?>
                        <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="">
                    <?php else: ?>
                        <div class="blog-card-img-placeholder">
                            <?php
                            $icons = ['news'=>'📢','eprocurement'=>'📋','webdev'=>'💻','consultancy'=>'🌏','general'=>'📝'];
                            echo $icons[$post['category']??'general'] ?? '📝';
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="blog-card-body">
                    <div class="blog-card-category"><?php echo $categoryLabels[$post['category']??'general']??'General'; ?></div>
                    <div class="blog-card-title"><?php echo htmlspecialchars($post['title']); ?></div>
                    <div class="blog-card-excerpt"><?php echo $excerpt; ?></div>
                    <div class="blog-card-footer">
                        <div class="blog-card-date"><?php echo $post['date']; ?></div>
                        <div class="blog-card-read">Read more →</div>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>
</div>
<?php endif; ?>

<!-- FOOTER -->
<div class="blog-footer">
    <p>© <?php echo date('Y'); ?> MAS Group. Licensed under MAS Corporation. | <a href="index.php">Back to Homepage</a> | <a href="index.php#contact">Contact Us</a></p>
</div>

</body>
</html>