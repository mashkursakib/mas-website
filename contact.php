<?php
// MAS Consultancy — contact form handler.
// Receives the contact form (index.html), validates it, and emails it to the office.
// Returns JSON: {"ok": true} or {"ok": false, "error": "..."}.

header('Content-Type: application/json');

require_once __DIR__ . '/includes/functions.php';
$site = load_site();
$TO = $site['site']['email_to'] ?? 'info@masconsultancy.org'; // set in Admin > Site Settings
$SUBJECT_PREFIX = '[MAS Website] ';

function fail($msg) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => $msg]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    fail('Method not allowed.');
}

// Honeypot: bots fill this hidden field, humans leave it empty.
if (!empty($_POST['website'])) {
    echo json_encode(['ok' => true]); // pretend success, silently drop it
    exit;
}

$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$company = trim($_POST['company'] ?? '');
$phone   = trim($_POST['phone'] ?? '');
$service = trim($_POST['service'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $email === '' || $message === '' || $service === '') {
    fail('Please fill in all required fields.');
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    fail('Please enter a valid email address.');
}
if (strlen($message) > 500) {
    fail('Message is too long (max 500 characters).');
}
// Block header-injection attempts.
foreach ([$name, $email, $service] as $field) {
    if (preg_match('/[\r\n]/', $field)) {
        fail('Invalid input.');
    }
}

$body = "New enquiry from masconsultancy.org\n\n"
    . "Name:    $name\n"
    . "Email:   $email\n"
    . "Company: " . ($company !== '' ? $company : '-') . "\n"
    . "Phone:   " . ($phone !== '' ? $phone : '-') . "\n"
    . "Service: $service\n\n"
    . "Message:\n$message\n";

$headers = "From: MAS Website <noreply@masconsultancy.org>\r\n"
    . "Reply-To: $email\r\n"
    . "Content-Type: text/plain; charset=UTF-8\r\n";

if (mail($TO, $SUBJECT_PREFIX . $service . ' — ' . $name, $body, $headers)) {
    echo json_encode(['ok' => true]);
} else {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Mail could not be sent.']);
}
