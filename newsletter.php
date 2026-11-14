<?php
// MAS Consultancy — newsletter signup handler.
// Validates the email, appends it to subscribers.txt (outside the web root
// is better — see README), and emails the office. Returns JSON.

header('Content-Type: application/json');

require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/smtp.php';
$site = load_site();
$TO = $site['site']['email_to'] ?? 'info@masconsultancy.org'; // set in Admin > Site Settings
$STORE = __DIR__ . '/subscribers.txt'; // keep this file private (see README / .htaccess)

function fail($msg) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => $msg]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    fail('Method not allowed.');
}

$email = trim($_POST['email'] ?? '');
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    fail('Please enter a valid email address.');
}

$line = date('Y-m-d H:i:s') . ' | ' . $email . PHP_EOL;
@file_put_contents($STORE, $line, FILE_APPEND | LOCK_EX);

$body = "New newsletter signup from masconsultancy.org\n\nEmail: $email\n";
$result = send_mail_smtp($TO, '[MAS Website] New newsletter subscriber', $body);
if (!$result['ok']) {
    error_log('MAS newsletter mail failed: ' . $result['error']);
}
// The signup is saved in subscribers.txt either way.
echo json_encode(['ok' => true]);
