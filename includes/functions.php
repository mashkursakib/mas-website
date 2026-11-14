<?php
// MAS Consultancy — shared helpers for the public site and the admin panel.

define('SITE_ROOT', dirname(__DIR__));
define('DATA_DIR', SITE_ROOT . '/data');
define('SITE_JSON', DATA_DIR . '/site.json');
define('POSTS_JSON', DATA_DIR . '/posts.json');

require_once SITE_ROOT . '/config.php';

const POST_CATEGORIES = [
    'e-procurement' => 'E-Procurement',
    'web-it'        => 'Web & IT',
    'market-entry'  => 'Market Entry',
    'company-news'  => 'Company News',
];

// ---------------------------------------------------------------------------
// Data: JSON files under /data (blocked from direct web access).
// ---------------------------------------------------------------------------

function load_site(): array
{
    $json = @file_get_contents(SITE_JSON);
    $data = $json ? json_decode($json, true) : null;
    return is_array($data) ? $data : [];
}

function save_site(array $data): bool
{
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    return @file_put_contents(SITE_JSON, $json, LOCK_EX) !== false;
}

function load_posts(): array
{
    $json = @file_get_contents(POSTS_JSON);
    $data = $json ? json_decode($json, true) : null;
    return is_array($data) ? $data : [];
}

function save_posts(array $posts): bool
{
    $json = json_encode(array_values($posts), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    return @file_put_contents(POSTS_JSON, $json, LOCK_EX) !== false;
}

// ---------------------------------------------------------------------------
// Output helpers.
// ---------------------------------------------------------------------------

function e(?string $s): string
{
    return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');
}

// Escape plain text, then turn newlines into <br> (for addresses, hours).
function e_nl(?string $s): string
{
    return nl2br(e($s));
}

// Rich text written by the admin: allow only a small safe tag set.
function rich(?string $s): string
{
    return strip_tags((string) $s, '<strong><em><br><a>');
}

function post_category_label(string $key): string
{
    return POST_CATEGORIES[$key] ?? ucfirst(str_replace('-', ' ', $key));
}

function format_post_date(string $iso): string
{
    $t = strtotime($iso);
    return $t ? date('M j, Y', $t) : $iso;
}

// Render one blog post card (used by index.php news preview and blog.php).
function post_card_html(array $post): string
{
    $url = !empty($post['url']) ? $post['url'] : 'blog.php';
    $img = !empty($post['image']) ? $post['image'] : 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&q=80';
    $html  = '<article class="news-card" data-category="' . e($post['category'] ?? '') . '">';
    $html .= '<img src="' . e($img) . '" alt="" loading="lazy">';
    $html .= '<div class="news-card-body">';
    $html .= '<div class="news-meta"><span class="news-cat">' . e(post_category_label($post['category'] ?? '')) . '</span><time datetime="' . e($post['date'] ?? '') . '">' . e(format_post_date($post['date'] ?? '')) . '</time></div>';
    $html .= '<h3><a href="' . e($url) . '">' . e($post['title'] ?? '') . '</a></h3>';
    $html .= '<p>' . e($post['excerpt'] ?? '') . '</p>';
    $html .= '<a href="' . e($url) . '" class="text-link">Read more &rarr;</a>';
    $html .= '</div></article>';
    return $html;
}

// ---------------------------------------------------------------------------
// Sessions, auth, CSRF, flash messages.
// ---------------------------------------------------------------------------

function start_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }
    $secure = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'secure'   => $secure,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_name('mas_admin');
    session_start();
}

function is_logged_in(): bool
{
    start_session();
    return !empty($_SESSION['admin_user']) && $_SESSION['admin_user'] === ADMIN_USER;
}

function require_login(): void
{
    if (!is_logged_in()) {
        redirect('login.php');
    }
}

function login_attempt(string $user, string $pass): array
{
    start_session();
    $now = time();
    $attempts = $_SESSION['login_attempts'] ?? 0;
    $lockedUntil = $_SESSION['login_locked_until'] ?? 0;

    if ($lockedUntil > $now) {
        $mins = (int) ceil(($lockedUntil - $now) / 60);
        return ['ok' => false, 'error' => "Too many failed attempts. Try again in $mins minute(s)."];
    }

    if ($user === ADMIN_USER && password_verify($pass, ADMIN_PASS_HASH)) {
        session_regenerate_id(true);
        $_SESSION['admin_user'] = ADMIN_USER;
        unset($_SESSION['login_attempts'], $_SESSION['login_locked_until']);
        return ['ok' => true];
    }

    $attempts++;
    $_SESSION['login_attempts'] = $attempts;
    if ($attempts >= LOGIN_MAX_ATTEMPTS) {
        $_SESSION['login_locked_until'] = $now + LOGIN_LOCKOUT_SECONDS;
        return ['ok' => false, 'error' => 'Too many failed attempts. Locked for 10 minutes.'];
    }
    return ['ok' => false, 'error' => 'Wrong username or password.'];
}

function logout(): void
{
    start_session();
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
}

function csrf_token(): string
{
    start_session();
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function csrf_check(): bool
{
    start_session();
    $sent = $_POST['csrf_token'] ?? '';
    return is_string($sent) && hash_equals($_SESSION['csrf_token'] ?? '', $sent);
}

function flash(string $message, string $type = 'success'): void
{
    start_session();
    $_SESSION['flash'] = ['message' => $message, 'type' => $type];
}

function get_flash(): ?array
{
    start_session();
    if (empty($_SESSION['flash'])) {
        return null;
    }
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}

function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}

// Is the admin still on the default password? Used for the dashboard warning.
function using_default_password(): bool
{
    return password_verify('changeme123', ADMIN_PASS_HASH);
}
