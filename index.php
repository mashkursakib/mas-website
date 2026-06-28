<?php
$dataFile = 'data.json';
$data = json_decode(file_get_contents($dataFile), true);
if(!$data) {
    $data = [
        'hero_title' => 'Empowering Business Through',
        'hero_subtitle' => 'Three specialized firms — MAS Corporation for e-procurement, MAS Communication for web & IT, and MAS Consultancy for foreign business operations.',
        'about_text' => 'MAS is a licensed group of companies under MAS Corporation.',
        'about_text2' => 'Our three sister concerns operate in dedicated domains.',
        'stats_years' => '10',
        'stats_projects' => '300',
        'stats_clients' => '150',
        'stats_us_clients' => '40',
        'contact_address' => 'House 12, Road 4, Block B, Banani, Dhaka-1213, Bangladesh',
        'contact_phone_us' => '+1 (347) 000-0000',
        'contact_phone_bd' => '+880-1700-000000',
        'contact_email1' => 'info@masconsultancy.org',
        'contact_email2' => 'biz@masconsultancy.org',
        'contact_hours' => 'Sun - Thu: 9:00 AM - 6:00 PM',
        'blogs' => []
    ];
}
$featuredBlogs = array_filter($data['blogs']??[], function($p){ return !empty($p['featured']); });
$latestBlogs = !empty($featuredBlogs) ? array_slice(array_values($featuredBlogs), 0, 3) : array_slice($data['blogs']??[], 0, 3);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAS Consultancy | E-Procurement, Web Development & Bangladesh Business Setup</title>
    <meta name="description" content="MAS Group — Three specialized firms: MAS Corporation for e-procurement, MAS Communication for IT & web development, and MAS Consultancy for Bangladesh market entry.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,800;1,400;1,600&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --green-dark: #1a3a2a; --green-mid: #2d5a3d; --green-main: #2e7d4f;
            --green-light: #4a9e6a; --gold: #c9a84c; --gold-light: #e8c96a;
            --cream: #f5f3ee; --cream-dark: #ede9e0; --white: #ffffff;
            --text-dark: #1a1a1a; --text-mid: #3a3a3a; --text-light: #666666;
            --text-muted: #999999; --border: #e0ddd6;
            --font-serif: 'Playfair Display', Georgia, serif;
            --font-sans: 'Inter', system-ui, sans-serif;
        }
        html { scroll-behavior: smooth; }
        body { font-family: var(--font-sans); color: var(--text-dark); background: var(--white); overflow-x: hidden; }

        /* NAVBAR */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
            padding: 0 40px; height: 70px;
            display: flex; align-items: center; justify-content: space-between;
            transition: all 0.3s ease; background: transparent;
        }
        .navbar.scrolled { background: rgba(255,255,255,0.97); box-shadow: 0 2px 20px rgba(0,0,0,0.08); }
        .nav-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .nav-logo-text { font-family: var(--font-serif); font-size: 1.3rem; font-weight: 700; color: var(--white); letter-spacing: 0.05em; transition: color 0.3s; }
        .navbar.scrolled .nav-logo-text { color: var(--text-dark); }
        .nav-links { display: flex; align-items: center; gap: 6px; list-style: none; }
        .nav-links a { text-decoration: none; font-size: 0.875rem; font-weight: 500; color: rgba(255,255,255,0.9); padding: 8px 14px; border-radius: 6px; transition: all 0.2s; }
        .navbar.scrolled .nav-links a { color: var(--text-mid); }
        .nav-links a:hover { background: rgba(255,255,255,0.15); }
        .navbar.scrolled .nav-links a:hover { color: var(--green-main); background: rgba(46,125,79,0.08); }
        .nav-cta { background: var(--green-main) !important; color: var(--white) !important; padding: 10px 22px !important; border-radius: 8px !important; font-weight: 600 !important; }
        .nav-cta:hover { background: var(--green-dark) !important; }
        .nav-hamburger { display: none; flex-direction: column; gap: 5px; cursor: pointer; padding: 5px; }
        .nav-hamburger span { width: 24px; height: 2px; background: var(--white); border-radius: 2px; transition: all 0.3s; }
        .navbar.scrolled .nav-hamburger span { background: var(--text-dark); }

        /* HERO */
        #hero {
            position: relative; min-height: 100vh;
            display: flex; flex-direction: column;
            justify-content: center; align-items: center;
            text-align: center; overflow: hidden; padding: 120px 40px 80px;
        }
        .hero-bg { position: absolute; inset: 0; background: linear-gradient(135deg, #0d2318 0%, #1a3a2a 30%, #0f2820 60%, #0a1f15 100%); z-index: 0; }
        .hero-bg::after { content: ''; position: absolute; inset: 0; background: url('https://images.unsplash.com/photo-1486325212027-8081e485255e?w=1600&q=80') center/cover no-repeat; opacity: 0.25; mix-blend-mode: overlay; }
        .hero-grid-overlay { position: absolute; inset: 0; background-image: linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px); background-size: 60px 60px; z-index: 1; }
        .hero-content { position: relative; z-index: 2; max-width: 820px; }
        .hero-badge { display: inline-flex; align-items: center; gap: 8px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: rgba(255,255,255,0.9); font-size: 0.75rem; font-weight: 600; letter-spacing: 0.12em; padding: 8px 18px; border-radius: 50px; margin-bottom: 30px; backdrop-filter: blur(10px); }
        .hero-badge::before { content: ''; width: 8px; height: 8px; background: var(--gold); border-radius: 50%; animation: pulse 2s infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.6; transform: scale(1.3); } }
        .hero-title { font-family: var(--font-serif); font-size: clamp(2.8rem, 6vw, 5rem); font-weight: 800; color: var(--white); line-height: 1.1; margin-bottom: 16px; }
        .hero-title-italic { font-style: italic; color: var(--gold); display: block; }
        .hero-subtitle { font-size: 1.05rem; color: rgba(255,255,255,0.75); line-height: 1.7; max-width: 620px; margin: 0 auto 40px; }
        .hero-subtitle strong { color: var(--white); font-weight: 600; }
        .hero-buttons { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; }
        .btn-primary { background: var(--green-main); color: var(--white); padding: 16px 32px; border-radius: 10px; font-size: 0.95rem; font-weight: 600; text-decoration: none; border: 2px solid var(--green-main); cursor: pointer; transition: all 0.25s; display: inline-flex; align-items: center; gap: 8px; }
        .btn-primary:hover { background: var(--green-dark); border-color: var(--green-dark); transform: translateY(-2px); box-shadow: 0 8px 25px rgba(46,125,79,0.4); }
        .btn-outline { background: transparent; color: var(--white); padding: 16px 32px; border-radius: 10px; font-size: 0.95rem; font-weight: 600; text-decoration: none; border: 2px solid rgba(255,255,255,0.5); cursor: pointer; transition: all 0.25s; }
        .btn-outline:hover { background: rgba(255,255,255,0.1); border-color: var(--white); transform: translateY(-2px); }
        .hero-stats { position: relative; z-index: 2; width: 100%; max-width: 900px; margin-top: 70px; padding-top: 40px; border-top: 1px solid rgba(255,255,255,0.15); display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
        .hero-stat { text-align: center; }
        .hero-stat-num { font-family: var(--font-serif); font-size: 2.5rem; font-weight: 700; color: var(--gold); line-height: 1; }
        .hero-stat-num sup { font-size: 1.2rem; }
        .hero-stat-label { font-size: 0.8rem; color: rgba(255,255,255,0.6); margin-top: 6px; font-weight: 500; }
        .hero-scroll { position: absolute; bottom: 30px; left: 50%; transform: translateX(-50%); z-index: 2; display: flex; flex-direction: column; align-items: center; gap: 6px; color: rgba(255,255,255,0.5); font-size: 0.7rem; letter-spacing: 0.15em; animation: bounce 2.5s infinite; }
        @keyframes bounce { 0%, 100% { transform: translateX(-50%) translateY(0); } 50% { transform: translateX(-50%) translateY(8px); } }

        /* SHARED */
        section { padding: 100px 0; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 40px; }
        .section-badge { display: inline-block; background: rgba(46,125,79,0.1); color: var(--green-main); font-size: 0.72rem; font-weight: 700; letter-spacing: 0.12em; padding: 6px 16px; border-radius: 50px; border: 1px solid rgba(46,125,79,0.2); margin-bottom: 20px; }
        .section-badge.white { background: rgba(255,255,255,0.15); color: rgba(255,255,255,0.9); border-color: rgba(255,255,255,0.3); }
        .section-title { font-family: var(--font-serif); font-size: clamp(2rem, 4vw, 3rem); font-weight: 700; color: var(--text-dark); line-height: 1.2; }
        .section-title.white { color: var(--white); }

        /* ABOUT */
        #about { background: var(--cream); }
        .about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; }
        .about-img-placeholder { width: 100%; height: 480px; border-radius: 16px; background: linear-gradient(135deg, #2d5a3d, #1a3a2a); overflow: hidden; position: relative; }
        .about-img-placeholder img { width: 100%; height: 100%; object-fit: cover; border-radius: 16px; }
        .about-card { position: absolute; bottom: -20px; right: -20px; background: var(--white); border-radius: 12px; padding: 20px 24px; box-shadow: 0 20px 60px rgba(0,0,0,0.12); min-width: 200px; }
        .about-card-year { font-family: var(--font-serif); font-size: 2.2rem; font-weight: 800; color: var(--text-dark); }
        .about-card-label { font-size: 0.8rem; color: var(--text-light); margin-top: 4px; }
        .about-card-label strong { color: var(--green-main); display: block; }
        .about-stars { display: flex; gap: 3px; margin-top: 12px; color: var(--gold); font-size: 1rem; }
        .about-body { margin-top: 24px; font-size: 0.95rem; color: var(--text-mid); line-height: 1.8; }
        .about-body p { margin-bottom: 16px; }
        .about-body strong { color: var(--text-dark); font-weight: 600; }
        .about-features { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-top: 32px; }
        .about-feature { background: var(--white); border: 1px solid var(--border); border-radius: 12px; padding: 18px; display: flex; gap: 14px; align-items: flex-start; transition: transform 0.2s, box-shadow 0.2s; }
        .about-feature:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,0.08); }
        .about-feature-icon { width: 40px; height: 40px; background: rgba(46,125,79,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 1.1rem; }
        .about-feature-title { font-size: 0.9rem; font-weight: 700; color: var(--text-dark); }
        .about-feature-desc { font-size: 0.78rem; color: var(--text-light); margin-top: 3px; line-height: 1.5; }

        /* SERVICES */
        #services { background: var(--white); }
        .services-header { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: end; margin-bottom: 60px; }
        .services-header-right { font-size: 0.95rem; color: var(--text-light); line-height: 1.7; text-align: right; }
        .services-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
        .service-card { background: var(--cream); border: 1px solid var(--border); border-radius: 16px; padding: 32px; transition: all 0.3s; cursor: pointer; position: relative; overflow: hidden; }
        .service-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: var(--green-main); transform: scaleX(0); transition: transform 0.3s; }
        .service-card:hover { transform: translateY(-6px); box-shadow: 0 20px 60px rgba(0,0,0,0.1); border-color: transparent; }
        .service-card:hover::before { transform: scaleX(1); }
        .service-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; margin-bottom: 20px; }
        .service-icon.green { background: rgba(46,125,79,0.1); } .service-icon.blue { background: rgba(59,130,246,0.1); } .service-icon.purple { background: rgba(139,92,246,0.1); } .service-icon.orange { background: rgba(249,115,22,0.1); } .service-icon.red { background: rgba(239,68,68,0.1); } .service-icon.teal { background: rgba(20,184,166,0.1); }
        .service-meta { font-size: 0.7rem; font-weight: 700; letter-spacing: 0.1em; color: var(--gold); margin-bottom: 8px; }
        .service-name { font-family: var(--font-serif); font-size: 1.2rem; font-weight: 700; color: var(--text-dark); margin-bottom: 12px; }
        .service-desc { font-size: 0.85rem; color: var(--text-light); line-height: 1.7; }
        .service-link { display: inline-flex; align-items: center; gap: 6px; margin-top: 20px; font-size: 0.85rem; font-weight: 600; color: var(--green-main); text-decoration: none; transition: gap 0.2s; }
        .service-link:hover { gap: 10px; }

        /* CONCERNS */
        #concerns { background: var(--cream); }
        .concerns-header { text-align: center; max-width: 600px; margin: 0 auto 60px; }
        .concerns-layout { display: grid; grid-template-columns: 380px 1fr; gap: 40px; align-items: start; }
        .concerns-list { display: flex; flex-direction: column; gap: 12px; }
        .concern-item { background: var(--white); border: 1px solid var(--border); border-radius: 12px; padding: 18px 20px; display: flex; align-items: center; gap: 14px; cursor: pointer; transition: all 0.3s; }
        .concern-item.active { background: var(--green-dark); border-color: var(--green-dark); }
        .concern-item-icon { width: 40px; height: 40px; border-radius: 10px; background: rgba(46,125,79,0.1); display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0; }
        .concern-item.active .concern-item-icon { background: rgba(255,255,255,0.15); }
        .concern-item-meta { font-size: 0.68rem; font-weight: 700; letter-spacing: 0.1em; color: var(--gold); text-transform: uppercase; }
        .concern-item.active .concern-item-meta { color: var(--gold-light); }
        .concern-item-title { font-size: 0.9rem; font-weight: 600; color: var(--text-dark); margin-top: 2px; }
        .concern-item.active .concern-item-title { color: var(--white); }
        .concerns-panel { background: var(--white); border-radius: 16px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.08); }
        .concerns-panel-img-placeholder { width: 100%; height: 260px; background: linear-gradient(135deg, #1a3a2a, #2d5a3d); overflow: hidden; }
        .concerns-panel-img-placeholder img { width: 100%; height: 100%; object-fit: cover; }
        .concerns-panel-body { padding: 32px; }
        .concerns-panel-badge { display: inline-block; background: rgba(46,125,79,0.1); color: var(--green-main); font-size: 0.7rem; font-weight: 700; letter-spacing: 0.1em; padding: 5px 12px; border-radius: 50px; margin-bottom: 16px; }
        .concerns-panel-title { font-family: var(--font-serif); font-size: 1.5rem; font-weight: 700; color: var(--text-dark); margin-bottom: 14px; }
        .concerns-panel-desc { font-size: 0.9rem; color: var(--text-light); line-height: 1.8; }
        .concerns-panel-desc strong { color: var(--green-main); }

        /* E-PROCUREMENT */
        #eprocurement { background: var(--white); }
        .eprocurement-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; }
        .eprocurement-content p { font-size: 0.95rem; color: var(--text-mid); line-height: 1.8; margin-bottom: 16px; }
        .eprocurement-content strong { color: var(--text-dark); font-weight: 600; }
        .portals-label { font-size: 0.72rem; font-weight: 700; letter-spacing: 0.12em; color: var(--text-muted); text-transform: uppercase; margin-top: 32px; margin-bottom: 12px; }
        .portals-list { display: flex; flex-wrap: wrap; gap: 10px; }
        .portal-tag { background: var(--cream); border: 1px solid var(--border); border-radius: 50px; padding: 6px 16px; font-size: 0.78rem; color: var(--text-mid); font-weight: 500; }
        .eprocurement-img-placeholder { width: 100%; height: 460px; border-radius: 16px; overflow: hidden; position: relative; }
        .eprocurement-img-placeholder img { width: 100%; height: 100%; object-fit: cover; border-radius: 16px; }
        .eprocurement-badge-overlay { position: absolute; top: 20px; right: 20px; background: var(--green-dark); color: var(--white); border-radius: 12px; padding: 16px 20px; text-align: center; }
        .eprocurement-badge-num { font-family: var(--font-serif); font-size: 2rem; font-weight: 800; color: var(--gold); }
        .eprocurement-badge-label { font-size: 0.75rem; color: rgba(255,255,255,0.8); margin-top: 4px; }
        .eprocurement-cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-top: 50px; }
        .eprocurement-card { background: var(--cream); border: 1px solid var(--border); border-radius: 12px; padding: 24px; }
        .eprocurement-card-icon { width: 40px; height: 40px; background: rgba(46,125,79,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1rem; margin-bottom: 14px; }
        .eprocurement-card-title { font-size: 0.9rem; font-weight: 700; color: var(--text-dark); }
        .eprocurement-card-desc { font-size: 0.8rem; color: var(--text-light); margin-top: 6px; line-height: 1.6; }

        /* WEB DEV */
        #webdev { background: var(--cream); }
        .webdev-header { text-align: center; margin-bottom: 50px; }
        .webdev-title-italic { font-style: italic; color: var(--green-main); }
        .webdev-header p { margin-top: 16px; color: var(--text-light); font-size: 0.95rem; }
        .webdev-tabs { display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; margin-bottom: 50px; }
        .webdev-tab { padding: 10px 24px; border-radius: 50px; border: 2px solid var(--border); background: var(--white); font-size: 0.88rem; font-weight: 600; color: var(--text-mid); cursor: pointer; transition: all 0.25s; font-family: var(--font-sans); }
        .webdev-tab.active { background: var(--green-dark); border-color: var(--green-dark); color: var(--white); }
        .webdev-tab:hover:not(.active) { border-color: var(--green-main); color: var(--green-main); }
        .webdev-panel { display: none; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center; }
        .webdev-panel.active { display: grid; }
        .webdev-panel-img img { width: 100%; height: 400px; object-fit: cover; border-radius: 16px; }
        .webdev-panel-title { font-family: var(--font-serif); font-size: 1.8rem; font-weight: 700; color: var(--text-dark); margin-bottom: 16px; }
        .webdev-panel-desc { font-size: 0.92rem; color: var(--text-light); line-height: 1.8; margin-bottom: 24px; }
        .webdev-checklist { list-style: none; display: flex; flex-direction: column; gap: 10px; }
        .webdev-checklist li { display: flex; align-items: center; gap: 10px; font-size: 0.88rem; color: var(--text-mid); font-weight: 500; }
        .webdev-checklist li::before { content: '✓'; color: var(--green-main); font-weight: 700; flex-shrink: 0; }
        .webdev-checklist li strong { color: var(--green-main); }
        .btn-green { display: inline-flex; align-items: center; gap: 8px; background: var(--green-dark); color: var(--white); padding: 14px 28px; border-radius: 10px; font-size: 0.9rem; font-weight: 600; text-decoration: none; border: none; cursor: pointer; transition: all 0.25s; margin-top: 28px; font-family: var(--font-sans); }
        .btn-green:hover { background: var(--green-main); transform: translateY(-2px); }

        /* OPERATIONAL */
        #operational { background: var(--green-dark); }
        .operational-header { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; margin-bottom: 60px; }
        .operational-header-right { font-size: 0.95rem; color: rgba(255,255,255,0.7); line-height: 1.8; padding-top: 80px; }
        .operational-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .operational-card { background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 32px; transition: all 0.3s; }
        .operational-card:hover { background: rgba(255,255,255,0.12); transform: translateY(-4px); }
        .operational-card-num { font-size: 0.78rem; font-weight: 700; color: var(--gold); margin-bottom: 20px; }
        .operational-card-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px; }
        .operational-card-icon { width: 42px; height: 42px; background: rgba(255,255,255,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; }
        .operational-card-title { font-family: var(--font-serif); font-size: 1.05rem; font-weight: 700; color: var(--white); margin-bottom: 10px; }
        .operational-card-desc { font-size: 0.82rem; color: rgba(255,255,255,0.6); line-height: 1.7; }

        /* NEWS SECTION */
        #news { background: var(--white); }
        .news-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px; }
        .news-link { font-size: 0.88rem; font-weight: 600; color: var(--green-main); text-decoration: none; display: flex; align-items: center; gap: 6px; }
        .news-link:hover { color: var(--green-dark); }
        .news-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
        .news-card { background: var(--cream); border: 1px solid var(--border); border-radius: 16px; overflow: hidden; text-decoration: none; color: inherit; display: block; transition: all 0.3s; }
        .news-card:hover { transform: translateY(-5px); box-shadow: 0 15px 50px rgba(0,0,0,0.1); border-color: transparent; }
        .news-card-img { height: 180px; overflow: hidden; background: linear-gradient(135deg, #e8f5ee, #c8e6d8); display: flex; align-items: center; justify-content: center; font-size: 2.5rem; }
        .news-card-img img { width: 100%; height: 100%; object-fit: cover; }
        .news-card-body { padding: 22px; }
        .news-card-cat { font-size: 0.68rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--green-main); margin-bottom: 8px; }
        .news-card-title { font-family: var(--font-serif); font-size: 1.05rem; font-weight: 700; color: var(--text-dark); margin-bottom: 8px; line-height: 1.4; }
        .news-card-date { font-size: 0.75rem; color: #bbb; margin-top: 14px; }
        .news-empty { text-align: center; padding: 60px; color: var(--text-light); grid-column: 1/-1; }

        /* CONTACT */
        #contact { background: var(--white); }
        .contact-header { text-align: center; max-width: 560px; margin: 0 auto 60px; }
        .contact-grid { display: grid; grid-template-columns: 1fr 1.4fr; gap: 60px; }
        .contact-info { display: flex; flex-direction: column; gap: 32px; }
        .contact-info-item { display: flex; gap: 16px; align-items: flex-start; }
        .contact-info-icon { width: 44px; height: 44px; background: rgba(46,125,79,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
        .contact-info-label { font-size: 0.7rem; font-weight: 700; letter-spacing: 0.1em; color: var(--gold); text-transform: uppercase; margin-bottom: 6px; }
        .contact-info-value { font-size: 0.9rem; color: var(--text-mid); line-height: 1.6; }
        .contact-map { margin-top: 24px; border-radius: 12px; overflow: hidden; border: 1px solid var(--border); height: 180px; }
        .contact-map iframe { width: 100%; height: 100%; border: none; }
        .contact-form { background: var(--cream); border-radius: 20px; padding: 40px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .form-group { display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px; }
        .form-label { font-size: 0.83rem; font-weight: 600; color: var(--text-dark); }
        .form-label .req { color: var(--green-main); }
        .form-input, .form-select, .form-textarea { padding: 13px 16px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 0.9rem; font-family: var(--font-sans); color: var(--text-dark); background: var(--white); transition: border-color 0.2s; outline: none; width: 100%; }
        .form-input:focus, .form-select:focus, .form-textarea:focus { border-color: var(--green-main); box-shadow: 0 0 0 3px rgba(46,125,79,0.1); }
        .form-textarea { resize: vertical; min-height: 130px; }
        .btn-submit { width: 100%; padding: 16px; background: var(--green-dark); color: var(--white); border: none; border-radius: 10px; font-size: 0.95rem; font-weight: 600; font-family: var(--font-sans); cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; transition: all 0.25s; margin-top: 24px; }
        .btn-submit:hover { background: var(--green-main); transform: translateY(-2px); }

        /* FOOTER */
        footer { background: var(--green-dark); color: rgba(255,255,255,0.7); padding: 60px 0 30px; }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 50px; margin-bottom: 50px; }
        .footer-brand-name { font-family: var(--font-serif); font-size: 1.3rem; font-weight: 700; color: var(--white); }
        .footer-brand-desc { font-size: 0.85rem; line-height: 1.7; max-width: 280px; margin-top: 12px; }
        .footer-concerns { display: flex; flex-direction: column; gap: 8px; margin-top: 20px; }
        .footer-concern { font-size: 0.8rem; color: rgba(255,255,255,0.5); }
        .footer-concern strong { color: rgba(255,255,255,0.8); }
        .footer-col-title { font-size: 0.82rem; font-weight: 700; letter-spacing: 0.08em; color: rgba(255,255,255,0.5); text-transform: uppercase; margin-bottom: 20px; }
        .footer-links { list-style: none; display: flex; flex-direction: column; gap: 10px; }
        .footer-links a { font-size: 0.88rem; color: rgba(255,255,255,0.7); text-decoration: none; transition: color 0.2s; }
        .footer-links a:hover { color: var(--white); }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,0.1); padding-top: 30px; display: flex; justify-content: space-between; align-items: center; font-size: 0.82rem; flex-wrap: wrap; gap: 16px; }
        .footer-bottom-right { display: flex; gap: 24px; }
        .footer-bottom-right a { color: rgba(255,255,255,0.5); text-decoration: none; transition: color 0.2s; }
        .footer-bottom-right a:hover { color: var(--white); }

        /* MOBILE NAV */
        .mobile-menu { display: none; position: fixed; top: 70px; left: 0; right: 0; background: var(--white); box-shadow: 0 10px 40px rgba(0,0,0,0.1); padding: 20px 30px; z-index: 999; flex-direction: column; gap: 4px; }
        .mobile-menu.open { display: flex; }
        .mobile-menu a { text-decoration: none; font-size: 0.95rem; font-weight: 500; color: var(--text-mid); padding: 12px 0; border-bottom: 1px solid var(--border); transition: color 0.2s; }
        .mobile-menu a:hover { color: var(--green-main); }

        /* TOAST */
        .toast { position: fixed; bottom: 30px; right: 30px; background: var(--green-dark); color: var(--white); padding: 16px 24px; border-radius: 12px; font-size: 0.9rem; font-weight: 500; box-shadow: 0 10px 40px rgba(0,0,0,0.2); z-index: 9999; transform: translateY(100px); opacity: 0; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        .toast.show { transform: translateY(0); opacity: 1; }

        /* RESPONSIVE */
        @media(max-width: 1024px) {
            .services-grid { grid-template-columns: repeat(2, 1fr); }
            .about-grid { grid-template-columns: 1fr; gap: 40px; }
            .eprocurement-grid { grid-template-columns: 1fr; gap: 40px; }
            .webdev-panel.active { grid-template-columns: 1fr; }
            .operational-grid { grid-template-columns: repeat(2, 1fr); }
            .footer-grid { grid-template-columns: 1fr 1fr; }
            .concerns-layout { grid-template-columns: 1fr; }
            .news-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media(max-width: 768px) {
            .navbar { padding: 0 20px; }
            .nav-links { display: none; }
            .nav-hamburger { display: flex; }
            .container { padding: 0 20px; }
            section { padding: 70px 0; }
            .hero-stats { grid-template-columns: repeat(2, 1fr); }
            .services-grid, .news-grid { grid-template-columns: 1fr; }
            .services-header { grid-template-columns: 1fr; }
            .services-header-right { text-align: left; }
            .about-features { grid-template-columns: 1fr; }
            .operational-grid { grid-template-columns: 1fr; }
            .operational-header { grid-template-columns: 1fr; }
            .contact-grid { grid-template-columns: 1fr; }
            .form-row { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr; }
            .footer-bottom { flex-direction: column; text-align: center; }
            .eprocurement-cards { grid-template-columns: 1fr; }
            .news-header { flex-direction: column; align-items: flex-start; gap: 16px; }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar" id="navbar">
    <a href="#" class="nav-logo">
        <div style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;">
            <svg viewBox="0 0 40 40" fill="none" width="36" height="36">
                <rect x="2" y="8" width="6" height="24" rx="1.5" fill="#4a9e6a"/>
                <rect x="10" y="14" width="6" height="18" rx="1.5" fill="#2e7d4f"/>
                <rect x="18" y="4" width="6" height="28" rx="1.5" fill="#c9a84c"/>
                <rect x="26" y="10" width="6" height="22" rx="1.5" fill="#2e7d4f"/>
                <rect x="34" y="16" width="4" height="16" rx="1.5" fill="#4a9e6a"/>
            </svg>
        </div>
        <span class="nav-logo-text">MAS</span>
    </a>
    <ul class="nav-links">
        <li><a href="#about">About Us</a></li>
        <li><a href="#services">Services</a></li>
        <li><a href="#concerns">Concerns</a></li>
        <li><a href="#eprocurement">E-Procurement</a></li>
        <li><a href="#webdev">Web Development</a></li>
        <li><a href="#operational">Operational Support</a></li>
        <li><a href="blog.php">News & Blog</a></li>
        <li><a href="#contact" class="nav-cta">Contact</a></li>
    </ul>
    <div class="nav-hamburger" id="hamburger" onclick="toggleMobileMenu()">
        <span></span><span></span><span></span>
    </div>
</nav>

<!-- MOBILE MENU -->
<div class="mobile-menu" id="mobileMenu">
    <a href="#about" onclick="closeMobileMenu()">About Us</a>
    <a href="#services" onclick="closeMobileMenu()">Services</a>
    <a href="#concerns" onclick="closeMobileMenu()">Concerns</a>
    <a href="#eprocurement" onclick="closeMobileMenu()">E-Procurement</a>
    <a href="#webdev" onclick="closeMobileMenu()">Web Development</a>
    <a href="#operational" onclick="closeMobileMenu()">Operational Support</a>
    <a href="blog.php" onclick="closeMobileMenu()">News & Blog</a>
    <a href="#contact" onclick="closeMobileMenu()">Contact</a>
</div>

<!-- HERO -->
<section id="hero">
    <div class="hero-bg"></div>
    <div class="hero-grid-overlay"></div>
    <div class="hero-content">
        <div class="hero-badge">TRUSTED PARTNER FOR US BUSINESSES</div>
        <h1 class="hero-title">
            <?php echo htmlspecialchars($data['hero_title']); ?>
            <span class="hero-title-italic">Smart Technology</span>
        </h1>
        <p class="hero-subtitle">
            <?php echo htmlspecialchars($data['hero_subtitle']); ?>
        </p>
        <div class="hero-buttons">
            <a href="#services" class="btn-primary">Explore Our Services</a>
            <a href="#contact" class="btn-outline">Get In Touch</a>
        </div>
    </div>
    <div class="hero-stats">
        <div class="hero-stat">
            <div class="hero-stat-num"><span class="counter" data-target="<?php echo $data['stats_years']??'10'; ?>">0</span><sup>+</sup></div>
            <div class="hero-stat-label">Years of Excellence</div>
        </div>
        <div class="hero-stat">
            <div class="hero-stat-num"><span class="counter" data-target="<?php echo $data['stats_projects']??'300'; ?>">0</span><sup>+</sup></div>
            <div class="hero-stat-label">Projects Completed</div>
        </div>
        <div class="hero-stat">
            <div class="hero-stat-num"><span class="counter" data-target="<?php echo $data['stats_clients']??'150'; ?>">0</span><sup>+</sup></div>
            <div class="hero-stat-label">Clients Served</div>
        </div>
        <div class="hero-stat">
            <div class="hero-stat-num"><span class="counter" data-target="<?php echo $data['stats_us_clients']??'40'; ?>">0</span><sup>+</sup></div>
            <div class="hero-stat-label">US Clients Served</div>
        </div>
    </div>
    <div class="hero-scroll">
        <span>SCROLL</span>
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M8 3v10M3 9l5 5 5-5" stroke="rgba(255,255,255,0.5)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
    </div>
</section>

<!-- ABOUT -->
<section id="about">
    <div class="container">
        <div class="about-grid">
            <div style="position:relative;">
                <div class="about-img-placeholder">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=800&q=80" alt="MAS team" loading="lazy">
                </div>
                <div class="about-card">
                    <div class="about-card-year">2014</div>
                    <div class="about-card-label"><strong>MAS Group — Founded</strong>Dhaka, Bangladesh</div>
                    <div class="about-stars">★★★★★</div>
                    <div style="font-size:0.75rem;color:#999;margin-top:4px;">Client Satisfaction</div>
                </div>
            </div>
            <div>
                <span class="section-badge">ABOUT US</span>
                <h2 class="section-title" style="margin-top:16px;">One Group. Three Specialized Firms. Complete Solutions.</h2>
                <div class="about-body">
                    <p><?php echo htmlspecialchars($data['about_text']); ?></p>
                    <p><?php echo htmlspecialchars($data['about_text2']); ?></p>
                </div>
                <div class="about-features">
                    <div class="about-feature"><div class="about-feature-icon">🏆</div><div><div class="about-feature-title">ISO Certified</div><div class="about-feature-desc">Internationally recognized quality standards in IT delivery</div></div></div>
                    <div class="about-feature"><div class="about-feature-icon">🌐</div><div><div class="about-feature-title">Global Reach</div><div class="about-feature-desc">Partnered with businesses from 20+ countries worldwide</div></div></div>
                    <div class="about-feature"><div class="about-feature-icon">🛡️</div><div><div class="about-feature-title">Trusted Partner</div><div class="about-feature-desc">Preferred vendor for government and enterprise clients</div></div></div>
                    <div class="about-feature"><div class="about-feature-icon">👥</div><div><div class="about-feature-title">Expert Team</div><div class="about-feature-desc">80+ certified professionals across all IT disciplines</div></div></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SERVICES -->
<section id="services">
    <div class="container">
        <div class="services-header">
            <div>
                <span class="section-badge">OUR SERVICES</span>
                <h2 class="section-title" style="margin-top:16px;">Three Firms, One Vision:<br>Complete IT Excellence</h2>
            </div>
            <div class="services-header-right">MAS Corporation, MAS Communication, and MAS Consultancy — each a specialist, together an end-to-end partner for US businesses.</div>
        </div>
        <div class="services-grid">
            <div class="service-card"><div class="service-icon green">📋</div><div class="service-meta">MAS CORPORATION · E-PROCUREMENT</div><div class="service-name">Government & Corporate Procurement</div><div class="service-desc">End-to-end e-procurement management — from tender registration and bid preparation to contract execution on CPTU, e-GP, and private portals.</div><a href="#eprocurement" class="service-link">Learn more →</a></div>
            <div class="service-card"><div class="service-icon blue">💻</div><div class="service-meta">MAS COMMUNICATION · WEB & IT</div><div class="service-name">Custom Web & App Development</div><div class="service-desc">Bespoke corporate websites, e-commerce platforms, enterprise portals, and mobile applications built with cutting-edge technologies.</div><a href="#webdev" class="service-link">Learn more →</a></div>
            <div class="service-card"><div class="service-icon purple">🌏</div><div class="service-meta">MAS CONSULTANCY · MARKET ENTRY</div><div class="service-name">Foreign Business Setup in Bangladesh</div><div class="service-desc">Comprehensive support for international companies entering Bangladesh — company registration, licensing, office setup, and local staffing.</div><a href="#operational" class="service-link">Learn more →</a></div>
            <div class="service-card"><div class="service-icon teal">🖥️</div><div class="service-meta">MAS COMMUNICATION · INFRASTRUCTURE</div><div class="service-name">IT Infrastructure & Cloud</div><div class="service-desc">Network design, server management, cloud migration, and IT infrastructure consulting for enterprise-grade reliability.</div><a href="#contact" class="service-link">Learn more →</a></div>
            <div class="service-card"><div class="service-icon red">🔒</div><div class="service-meta">MAS COMMUNICATION · SECURITY</div><div class="service-name">Security & Compliance</div><div class="service-desc">Cybersecurity audits, data protection compliance, vulnerability assessments, and security training for your organization.</div><a href="#contact" class="service-link">Learn more →</a></div>
            <div class="service-card"><div class="service-icon orange">📊</div><div class="service-meta">MAS CONSULTANCY · STRATEGY</div><div class="service-name">Digital Transformation Advisory</div><div class="service-desc">Strategic roadmapping, technology selection, process digitization, and change management to accelerate your digital journey.</div><a href="#contact" class="service-link">Learn more →</a></div>
        </div>
    </div>
</section>

<!-- CONCERNS -->
<section id="concerns">
    <div class="container">
        <div class="concerns-header">
            <span class="section-badge">COMMON CONCERNS</span>
            <h2 class="section-title" style="margin-top:16px;">Addressing Your Business Challenges</h2>
            <p style="margin-top:16px;color:var(--text-light);font-size:0.95rem;line-height:1.7;">We understand the real-world obstacles businesses face. Here's how we turn your concerns into competitive advantages.</p>
        </div>
        <div class="concerns-layout">
            <div class="concerns-list">
                <div class="concern-item active" onclick="switchConcern(this,0)"><div class="concern-item-icon">📋</div><div><div class="concern-item-meta">E-PROCUREMENT</div><div class="concern-item-title">Complex Procurement Processes</div></div></div>
                <div class="concern-item" onclick="switchConcern(this,1)"><div class="concern-item-icon">📈</div><div><div class="concern-item-meta">OPERATIONAL SUPPORT</div><div class="concern-item-title">Foreign Business Entry Barriers</div></div></div>
                <div class="concern-item" onclick="switchConcern(this,2)"><div class="concern-item-icon">🌐</div><div><div class="concern-item-meta">WEB DEVELOPMENT</div><div class="concern-item-title">Digital Presence & Technology Gaps</div></div></div>
                <div class="concern-item" onclick="switchConcern(this,3)"><div class="concern-item-icon">🛡️</div><div><div class="concern-item-meta">CYBER SECURITY</div><div class="concern-item-title">IT Security & Compliance Risks</div></div></div>
                <div class="concern-item" onclick="switchConcern(this,4)"><div class="concern-item-icon">👥</div><div><div class="concern-item-meta">OPERATIONAL SUPPORT</div><div class="concern-item-title">Local Talent & Staffing</div></div></div>
                <div class="concern-item" onclick="switchConcern(this,5)"><div class="concern-item-icon">💰</div><div><div class="concern-item-meta">IT ADVISORY</div><div class="concern-item-title">Cost & Vendor Management</div></div></div>
            </div>
            <div class="concerns-panel">
                <div class="concerns-panel-img-placeholder"><img id="concernImg" src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&q=80" alt=""></div>
                <div class="concerns-panel-body">
                    <span class="concerns-panel-badge" id="concernBadge">E-PROCUREMENT</span>
                    <h3 class="concerns-panel-title" id="concernTitle">How do we navigate Bangladesh's government e-procurement system?</h3>
                    <p class="concerns-panel-desc" id="concernDesc">We handle the entire e-procurement lifecycle on your behalf — from CPTU and e-GP portal registration, to bid document preparation, technical compliance, and contract negotiation. Our experts have managed <strong>500+ successful government tenders</strong> with a 78% bid success rate.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- E-PROCUREMENT -->
<section id="eprocurement">
    <div class="container">
        <div class="eprocurement-grid">
            <div class="eprocurement-content">
                <span class="section-badge">E-PROCUREMENT</span>
                <h2 class="section-title" style="margin-top:16px;margin-bottom:24px;">Win Government & Corporate Tenders with MAS Corporation</h2>
                <p><strong>MAS Corporation</strong> is the dedicated e-procurement arm of the MAS Group. Bangladesh's <strong>e-procurement</strong> ecosystem — managed through CPTU and e-GP platforms — is the gateway to billions in government contracts. Our specialist team carries a 78% bid success rate across 500+ submitted tenders.</p>
                <p>Whether you're a US multinational or a local enterprise, MAS Corporation provides the technical expertise, documentation support, and strategic guidance that transforms your <strong>procurement</strong> capability into a sustainable competitive advantage.</p>
                <div class="portals-label">PORTALS WE WORK WITH</div>
                <div class="portals-list">
                    <span class="portal-tag"><strong>e-GP Bangladesh</strong> · Government Portal</span>
                    <span class="portal-tag"><strong>CPTU</strong> · Central Procurement</span>
                    <span class="portal-tag"><strong>BMET Portal</strong> · Ministry of Labour</span>
                    <span class="portal-tag"><strong>DESCO Procurement</strong> · Utility Sector</span>
                    <span class="portal-tag"><strong>BIWTA</strong> · Transport Authority</span>
                    <span class="portal-tag"><strong>LGED Tender</strong> · Engineering Works</span>
                </div>
            </div>
            <div style="position:relative;">
                <div class="eprocurement-img-placeholder">
                    <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&q=80" alt="E-procurement" loading="lazy">
                    <div class="eprocurement-badge-overlay"><div class="eprocurement-badge-num">78%</div><div class="eprocurement-badge-label">Bid Success Rate</div></div>
                </div>
            </div>
        </div>
        <div class="eprocurement-cards">
            <div class="eprocurement-card"><div class="eprocurement-card-icon">📝</div><div class="eprocurement-card-title">e-GP Portal Registration</div><div class="eprocurement-card-desc">Complete setup and verification on all government e-procurement portals.</div></div>
            <div class="eprocurement-card"><div class="eprocurement-card-icon">🔍</div><div class="eprocurement-card-title">Tender Identification</div><div class="eprocurement-card-desc">Real-time monitoring and smart matching of tenders to your business profile.</div></div>
            <div class="eprocurement-card"><div class="eprocurement-card-icon">📁</div><div class="eprocurement-card-title">Bid Document Preparation</div><div class="eprocurement-card-desc">Expert preparation of technical and financial bids with compliance review.</div></div>
            <div class="eprocurement-card"><div class="eprocurement-card-icon">✅</div><div class="eprocurement-card-title">Technical Compliance</div><div class="eprocurement-card-desc">Ensuring all submissions meet regulatory and procurement authority requirements.</div></div>
            <div class="eprocurement-card"><div class="eprocurement-card-icon">🤝</div><div class="eprocurement-card-title">Contract Negotiation</div><div class="eprocurement-card-desc">Strategic negotiation support for award and post-award contract management.</div></div>
            <div class="eprocurement-card"><div class="eprocurement-card-icon">📊</div><div class="eprocurement-card-title">Performance Reporting</div><div class="eprocurement-card-desc">Detailed analytics on bid performance, success rates, and market trends.</div></div>
        </div>
    </div>
</section>

<!-- WEB DEVELOPMENT -->
<section id="webdev">
    <div class="container">
        <div class="webdev-header">
            <span class="section-badge">WEB DEVELOPMENT</span>
            <h2 class="section-title" style="margin-top:16px;">MAS Communication: <span class="webdev-title-italic">Digital Solutions That Drive Results</span></h2>
            <p>We craft beautiful, high-performance digital products — from landing pages to complex enterprise systems — all engineered for scale.</p>
        </div>
        <div class="webdev-tabs">
            <button class="webdev-tab active" onclick="switchTab(this,'corporate')">Corporate Websites</button>
            <button class="webdev-tab" onclick="switchTab(this,'ecommerce')">E-Commerce</button>
            <button class="webdev-tab" onclick="switchTab(this,'portals')">Enterprise Portals</button>
            <button class="webdev-tab" onclick="switchTab(this,'mobile')">Mobile Apps</button>
        </div>
        <div class="webdev-panel active" id="tab-corporate">
            <div class="webdev-panel-img"><img src="https://images.unsplash.com/photo-1547658719-da2b51169166?w=800&q=80" alt="Corporate websites" loading="lazy"></div>
            <div><h3 class="webdev-panel-title">Corporate Websites</h3><p class="webdev-panel-desc">We design and develop high-impact corporate websites that establish your brand authority, communicate your value proposition, and convert visitors into clients. Every site is fully responsive, SEO-optimized, and built for speed.</p><ul class="webdev-checklist"><li><strong>Brand-aligned UI/UX design</strong></li><li><strong>CMS integration (WordPress/Headless)</strong></li><li>Multi-language support</li><li>Google Analytics & SEO</li><li>Hosting & maintenance</li></ul><a href="#contact" class="btn-green">Start a Project →</a></div>
        </div>
        <div class="webdev-panel" id="tab-ecommerce">
            <div class="webdev-panel-img"><img src="https://images.unsplash.com/photo-1563013544-824ae1b704d3?w=800&q=80" alt="E-commerce" loading="lazy"></div>
            <div><h3 class="webdev-panel-title">E-Commerce Platforms</h3><p class="webdev-panel-desc">Full-featured online stores built on WooCommerce, Shopify, or custom frameworks — optimized for conversions, payment processing, and seamless user experience across all devices.</p><ul class="webdev-checklist"><li><strong>Custom storefront design</strong></li><li><strong>Payment gateway integration</strong></li><li>Inventory management system</li><li>Order tracking & fulfillment</li><li>Performance optimization</li></ul><a href="#contact" class="btn-green">Start a Project →</a></div>
        </div>
        <div class="webdev-panel" id="tab-portals">
            <div class="webdev-panel-img"><img src="https://images.unsplash.com/photo-1551434678-e076c223a692?w=800&q=80" alt="Enterprise portals" loading="lazy"></div>
            <div><h3 class="webdev-panel-title">Enterprise Portals</h3><p class="webdev-panel-desc">Custom-built enterprise web applications including HR portals, client dashboards, data management systems, and workflow automation tools designed for scale and security.</p><ul class="webdev-checklist"><li><strong>Role-based access control</strong></li><li><strong>API integration & microservices</strong></li><li>Real-time data dashboards</li><li>Enterprise-grade security</li><li>24/7 technical support</li></ul><a href="#contact" class="btn-green">Start a Project →</a></div>
        </div>
        <div class="webdev-panel" id="tab-mobile">
            <div class="webdev-panel-img"><img src="https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=800&q=80" alt="Mobile apps" loading="lazy"></div>
            <div><h3 class="webdev-panel-title">Mobile Applications</h3><p class="webdev-panel-desc">Native and cross-platform mobile apps for iOS and Android — from concept and UX design through development, testing, and App Store deployment with ongoing maintenance.</p><ul class="webdev-checklist"><li><strong>iOS & Android development</strong></li><li><strong>React Native / Flutter</strong></li><li>Push notifications & analytics</li><li>Offline functionality</li><li>App Store optimization</li></ul><a href="#contact" class="btn-green">Start a Project →</a></div>
        </div>
    </div>
</section>

<!-- OPERATIONAL SUPPORT -->
<section id="operational">
    <div class="container">
        <div class="operational-header">
            <div>
                <span class="section-badge white">OPERATIONAL SUPPORT</span>
                <h2 class="section-title white" style="margin-top:16px;">MAS Consultancy: Your Gateway to Business in Bangladesh</h2>
            </div>
            <div class="operational-header-right"><strong style="color:white">MAS Consultancy</strong> specializes in helping US and international businesses establish full operations in Bangladesh — one of Asia's fastest-growing economies with competitive labor, a young tech workforce, and a booming IT sector.</div>
        </div>
        <div class="operational-grid">
            <div class="operational-card"><div class="operational-card-num">01</div><div class="operational-card-header"><div class="operational-card-title">Feasibility & Market Research</div><div class="operational-card-icon">🔍</div></div><div class="operational-card-desc">We analyze your target sector, identify opportunities, assess competition, and provide a comprehensive market entry report tailored to your business model.</div></div>
            <div class="operational-card"><div class="operational-card-num">02</div><div class="operational-card-header"><div class="operational-card-title">Company Registration & Licensing</div><div class="operational-card-icon">📋</div></div><div class="operational-card-desc">Full management of RJSC registration, BIDA approval, trade license, TIN/BIN registration, and all sector-specific permits and regulatory approvals.</div></div>
            <div class="operational-card"><div class="operational-card-num">03</div><div class="operational-card-header"><div class="operational-card-title">Office Setup & Infrastructure</div><div class="operational-card-icon">🏢</div></div><div class="operational-card-desc">Identifying and securing office space, setting up IT infrastructure, internet connectivity, and all operational utilities for your Bangladesh operations.</div></div>
            <div class="operational-card"><div class="operational-card-num">04</div><div class="operational-card-header"><div class="operational-card-title">Local Talent Recruitment</div><div class="operational-card-icon">👥</div></div><div class="operational-card-desc">Recruiting qualified local professionals — engineers, managers, analysts, and support staff — through our extensive professional network across Bangladesh.</div></div>
            <div class="operational-card"><div class="operational-card-num">05</div><div class="operational-card-header"><div class="operational-card-title">Banking & Financial Setup</div><div class="operational-card-icon">🏦</div></div><div class="operational-card-desc">Corporate bank account opening, foreign currency account management, and liaison with Bangladesh Bank for remittance and investment approvals.</div></div>
            <div class="operational-card"><div class="operational-card-num">06</div><div class="operational-card-header"><div class="operational-card-title">Ongoing Operational Support</div><div class="operational-card-icon">⚙️</div></div><div class="operational-card-desc">Continued advisory services, annual compliance management, local government liaison, and dedicated account management for your Bangladesh operations.</div></div>
        </div>
    </div>
</section>

<!-- LATEST NEWS -->
<section id="news">
    <div class="container">
        <div class="news-header">
            <div>
                <span class="section-badge">LATEST NEWS</span>
                <h2 class="section-title" style="margin-top:12px;">Updates from MAS Group</h2>
            </div>
            <a href="blog.php" class="news-link">View All Posts →</a>
        </div>
        <div class="news-grid">
            <?php if(!empty($latestBlogs)): ?>
                <?php foreach($latestBlogs as $post): ?>
                <a href="blog.php?post=<?php echo $post['id']; ?>" class="news-card">
                    <div class="news-card-img">
                        <?php if(!empty($post['image'])): ?>
                            <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="">
                        <?php else: ?>
                            <?php $icons=['news'=>'📢','eprocurement'=>'📋','webdev'=>'💻','consultancy'=>'🌏','general'=>'📝']; echo $icons[$post['category']??'general']??'📝'; ?>
                        <?php endif; ?>
                    </div>
                    <div class="news-card-body">
                        <div class="news-card-cat"><?php echo strtoupper($post['category']??'GENERAL'); ?></div>
                        <div class="news-card-title"><?php echo htmlspecialchars($post['title']); ?></div>
                        <div style="font-size:0.83rem;color:var(--text-light);line-height:1.7;"><?php echo htmlspecialchars(substr($post['content'],0,100)).'...'; ?></div>
                        <div class="news-card-date"><?php echo $post['date']; ?></div>
                    </div>
                </a>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="news-empty">
                    <p>📰 News and updates will appear here once published from the admin panel.</p>
                    <br><a href="blog.php" style="color:var(--green-main);font-weight:600;">Visit Blog Page →</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- CONTACT -->
<section id="contact">
    <div class="container">
        <div class="contact-header">
            <span class="section-badge">CONTACT US</span>
            <h2 class="section-title" style="margin-top:16px;">Let's Start a Conversation</h2>
            <p style="margin-top:16px;color:var(--text-light);font-size:0.95rem;line-height:1.7;">Whether you have a specific project in mind or just want to explore how we can help, our team is ready to assist.</p>
        </div>
        <div class="contact-grid">
            <div class="contact-info">
                <div class="contact-info-item"><div class="contact-info-icon">📍</div><div><div class="contact-info-label">OFFICE ADDRESS</div><div class="contact-info-value"><?php echo nl2br(htmlspecialchars($data['contact_address']??'')); ?></div></div></div>
                <div class="contact-info-item"><div class="contact-info-icon">📞</div><div><div class="contact-info-label">PHONE</div><div class="contact-info-value"><?php echo htmlspecialchars($data['contact_phone_us']??''); ?> (US Line)<br><?php echo htmlspecialchars($data['contact_phone_bd']??''); ?> (BD Office)</div></div></div>
                <div class="contact-info-item"><div class="contact-info-icon">✉️</div><div><div class="contact-info-label">EMAIL</div><div class="contact-info-value"><?php echo htmlspecialchars($data['contact_email1']??''); ?><br><?php echo htmlspecialchars($data['contact_email2']??''); ?></div></div></div>
                <div class="contact-info-item"><div class="contact-info-icon">🕐</div><div><div class="contact-info-label">BUSINESS HOURS</div><div class="contact-info-value"><?php echo htmlspecialchars($data['contact_hours']??''); ?><br>Fri – Sat: Closed</div></div></div>
                <div class="contact-map"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3650.0!2d90.4!3d23.8!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjPCsDQ4JzAwLjAiTiA5MMKwMjQnMDAuMCJF!5e0!3m2!1sen!2sbd!4v1" allowfullscreen="" loading="lazy" title="MAS Office"></iframe></div>
            </div>
            <div class="contact-form">
                <form id="contactForm" onsubmit="handleSubmit(event)">
                    <div class="form-row">
                        <div class="form-group"><label class="form-label">Full Name <span class="req">*</span></label><input type="text" class="form-input" placeholder="John Rahman" required></div>
                        <div class="form-group"><label class="form-label">Email Address <span class="req">*</span></label><input type="email" class="form-input" placeholder="john@company.com" required></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group"><label class="form-label">Company Name</label><input type="text" class="form-input" placeholder="Your Company Ltd."></div>
                        <div class="form-group"><label class="form-label">Phone Number</label><input type="tel" class="form-input" placeholder="+1 (347) 000-0000"></div>
                    </div>
                    <div class="form-group"><label class="form-label">Service of Interest <span class="req">*</span></label><select class="form-select" required><option value="">Select a service...</option><option>E-Procurement (MAS Corporation)</option><option>Web Development (MAS Communication)</option><option>IT Infrastructure & Cloud</option><option>Security & Compliance</option><option>Bangladesh Business Setup (MAS Consultancy)</option><option>Digital Transformation Advisory</option><option>Other</option></select></div>
                    <div class="form-group"><label class="form-label">Message <span class="req">*</span></label><textarea class="form-textarea" id="messageArea" placeholder="Tell us about your project or inquiry..." maxlength="500" oninput="updateCount()" required></textarea><div style="font-size:0.75rem;color:#999;text-align:right;margin-top:6px;"><span id="charCount">0</span>/500</div></div>
                    <button type="submit" class="btn-submit">Send Message <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg></button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer>
    <div class="container">
        <div class="footer-grid">
            <div>
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
                    <svg width="32" height="32" viewBox="0 0 40 40" fill="none"><rect x="2" y="8" width="6" height="24" rx="1.5" fill="#4a9e6a"/><rect x="10" y="14" width="6" height="18" rx="1.5" fill="#2e7d4f"/><rect x="18" y="4" width="6" height="28" rx="1.5" fill="#c9a84c"/><rect x="26" y="10" width="6" height="22" rx="1.5" fill="#2e7d4f"/><rect x="34" y="16" width="4" height="16" rx="1.5" fill="#4a9e6a"/></svg>
                    <span class="footer-brand-name">MAS</span>
                </div>
                <div class="footer-brand-desc">MAS is a licensed group of companies headquartered in Dhaka, Bangladesh. Empowering US and global businesses through smart technology and local expertise since 2014.</div>
                <div class="footer-concerns">
                    <div class="footer-concern"><strong>MAS Corporation</strong> — E-Procurement</div>
                    <div class="footer-concern"><strong>MAS Communication</strong> — IT & Web Development</div>
                    <div class="footer-concern"><strong>MAS Consultancy</strong> — Foreign Business Operations</div>
                </div>
            </div>
            <div>
                <div class="footer-col-title">Services</div>
                <ul class="footer-links">
                    <li><a href="#eprocurement">E-Procurement</a></li>
                    <li><a href="#webdev">Web Development</a></li>
                    <li><a href="#webdev">Mobile Apps</a></li>
                    <li><a href="#operational">Business Setup</a></li>
                    <li><a href="#services">IT Consulting</a></li>
                    <li><a href="#services">Cybersecurity</a></li>
                </ul>
            </div>
            <div>
                <div class="footer-col-title">Company</div>
                <ul class="footer-links">
                    <li><a href="#about">About MAS</a></li>
                    <li><a href="blog.php">News & Blog</a></li>
                    <li><a href="#concerns">Our Concerns</a></li>
                    <li><a href="#contact">Contact Us</a></li>
                    <li><a href="admin.php">Admin Panel</a></li>
                </ul>
            </div>
            <div>
                <div class="footer-col-title">Contact</div>
                <ul class="footer-links">
                    <li><a href="mailto:<?php echo $data['contact_email1']??'info@masconsultancy.org'; ?>"><?php echo $data['contact_email1']??'info@masconsultancy.org'; ?></a></li>
                    <li><a href="mailto:<?php echo $data['contact_email2']??'biz@masconsultancy.org'; ?>"><?php echo $data['contact_email2']??'biz@masconsultancy.org'; ?></a></li>
                    <li><a href="tel:<?php echo preg_replace('/[^+\d]/','',$data['contact_phone_us']??''); ?>"><?php echo $data['contact_phone_us']??''; ?></a></li>
                    <li><a href="tel:<?php echo preg_replace('/[^+\d]/','',$data['contact_phone_bd']??''); ?>"><?php echo $data['contact_phone_bd']??''; ?></a></li>
                    <li><a href="https://masconsultancy.org">masconsultancy.org</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <div>© <?php echo date('Y'); ?> MAS Group. Licensed under MAS Corporation. All rights reserved.</div>
            <div class="footer-bottom-right">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

<div class="toast" id="toast">✅ Message sent! We'll get back to you within 24 hours.</div>

<script>
    // NAVBAR
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        if(window.scrollY > 80) navbar.classList.add('scrolled');
        else navbar.classList.remove('scrolled');
    });

    // MOBILE MENU
    function toggleMobileMenu() { document.getElementById('mobileMenu').classList.toggle('open'); }
    function closeMobileMenu() { document.getElementById('mobileMenu').classList.remove('open'); }

    // COUNTERS
    let countersStarted = false;
    function startCounters() {
        if(countersStarted) return; countersStarted = true;
        document.querySelectorAll('.counter').forEach(counter => {
            const target = parseInt(counter.dataset.target);
            let current = 0; const step = target / 120;
            const timer = setInterval(() => {
                current += step;
                if(current >= target) { current = target; clearInterval(timer); }
                counter.textContent = Math.floor(current);
            }, 16);
        });
    }
    const heroStats = document.querySelector('.hero-stats');
    if(heroStats) new IntersectionObserver((e) => { if(e[0].isIntersecting) startCounters(); }, {threshold:0.3}).observe(heroStats);

    // CONCERNS
    const concernData = [
        {badge:'E-PROCUREMENT',title:"How do we navigate Bangladesh's government e-procurement system?",desc:"We handle the entire e-procurement lifecycle on your behalf — from CPTU and e-GP portal registration, to bid document preparation, technical compliance, and contract negotiation. Our experts have managed <strong>500+ successful government tenders</strong> with a 78% bid success rate.",img:"https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&q=80"},
        {badge:'OPERATIONAL SUPPORT',title:"How do we overcome foreign business entry barriers in Bangladesh?",desc:"MAS Consultancy provides end-to-end market entry support — handling all regulatory registrations (RJSC, BIDA, trade license), securing office space, and managing local government relationships so you can focus on your core business.",img:"https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=800&q=80"},
        {badge:'WEB DEVELOPMENT',title:"How do we build a powerful digital presence that drives real results?",desc:"MAS Communication delivers <strong>high-performance digital products</strong> — corporate websites, e-commerce platforms, enterprise portals, and mobile apps — all built with modern frameworks, SEO-optimized, and engineered for scale.",img:"https://images.unsplash.com/photo-1547658719-da2b51169166?w=800&q=80"},
        {badge:'CYBER SECURITY',title:"How do we protect our IT systems and ensure compliance?",desc:"Our security team conducts comprehensive <strong>cybersecurity audits</strong>, vulnerability assessments, data protection compliance reviews, and implements robust security frameworks to protect your digital assets.",img:"https://images.unsplash.com/photo-1563986768609-322da13575f3?w=800&q=80"},
        {badge:'OPERATIONAL SUPPORT',title:"How do we find and retain qualified local talent in Bangladesh?",desc:"Through our <strong>extensive professional network</strong> spanning all major cities, we recruit engineers, managers, analysts, and specialized staff — handling screening, verification, HR onboarding, and payroll management.",img:"https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&q=80"},
        {badge:'IT ADVISORY',title:"How do we optimize IT costs and manage vendors effectively?",desc:"Our IT advisory team develops <strong>comprehensive vendor management strategies</strong>, technology roadmaps, and cost optimization frameworks — ensuring maximum value from your technology investments.",img:"https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&q=80"}
    ];
    function switchConcern(el, idx) {
        document.querySelectorAll('.concern-item').forEach(i => i.classList.remove('active'));
        el.classList.add('active');
        const d = concernData[idx];
        document.getElementById('concernBadge').textContent = d.badge;
        document.getElementById('concernTitle').textContent = d.title;
        document.getElementById('concernDesc').innerHTML = d.desc;
        document.getElementById('concernImg').src = d.img;
    }

    // WEB DEV TABS
    function switchTab(el, tabId) {
        document.querySelectorAll('.webdev-tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.webdev-panel').forEach(p => p.classList.remove('active'));
        el.classList.add('active');
        document.getElementById('tab-'+tabId).classList.add('active');
    }

    // CONTACT FORM
    function updateCount() { document.getElementById('charCount').textContent = document.getElementById('messageArea').value.length; }
    function handleSubmit(e) {
        e.preventDefault();
        const btn = e.target.querySelector('.btn-submit');
        btn.textContent = 'Sending...'; btn.disabled = true;
        setTimeout(() => {
            btn.innerHTML = 'Send Message <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>';
            btn.disabled = false; e.target.reset();
            document.getElementById('charCount').textContent = '0';
            const toast = document.getElementById('toast');
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 4000);
        }, 1500);
    }

    // SCROLL REVEAL
    const revealEls = document.querySelectorAll('.service-card,.operational-card,.about-feature,.eprocurement-card,.news-card');
    const revealObs = new IntersectionObserver((entries) => {
        entries.forEach((entry, i) => {
            if(entry.isIntersecting) { entry.target.style.opacity='1'; entry.target.style.transform='translateY(0)'; revealObs.unobserve(entry.target); }
        });
    }, {threshold:0.1});
    revealEls.forEach((el,i) => {
        el.style.opacity='0'; el.style.transform='translateY(30px)';
        el.style.transition=`opacity 0.6s ease ${i*0.07}s, transform 0.6s ease ${i*0.07}s`;
        revealObs.observe(el);
    });
</script>
</body>
</html>