<?php
// MAS Consultancy — newsletter signup handler.
// Validates the email, appends it to subscribers.txt (backup record), adds it
// to the Brevo "MAS Newsletter" list when a BREVO_API_KEY environment variable
// is set, and emails the office. Returns JSON.

header('Content-Type: application/json');

require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/mailer.php';
$site = load_site();
$TO = $site['site']['email_to'] ?? 'info@masconsultancy.org'; // set in Admin > Site Settings
$STORE = __DIR__ . '/subscribers.txt'; // keep this file private (see README / .htaccess)

function fail($msg) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => $msg]);
    exit;
}

// Add the email to the Brevo "MAS Newsletter" list (ID 3). Returns true on
// success (201 created, or 204 for an existing contact updated). Never throws.
function brevo_subscribe(string $email): bool
{
    $apiKey = getenv('BREVO_API_KEY');
    if (!$apiKey) {
        return false;
    }
    $payload = json_encode([
        'email' => $email,
        'listIds' => [3], // "MAS Newsletter" list in Brevo
        'updateEnabled' => true,
    ]);
    $headers = [
        'accept: application/json',
        'content-type: application/json',
        'api-key: ' . $apiKey,
    ];
    if (function_exists('curl_init')) {
        $ch = curl_init('https://api.brevo.com/v3/contacts');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);
        curl_close($ch);
        if ($err !== '') {
            error_log('MAS Brevo subscribe cURL error: ' . $err);
            return false;
        }
        return $status === 201 || $status === 204;
    }
    $ctx = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => implode("\r\n", $headers),
            'content' => $payload,
            'timeout' => 10,
            'ignore_errors' => true,
        ],
    ]);
    $result = @file_get_contents('https://api.brevo.com/v3/contacts', false, $ctx);
    if ($result === false || empty($http_response_header[0])) {
        return false;
    }
    return strpos($http_response_header[0], '201') !== false
        || strpos($http_response_header[0], '204') !== false;
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

if (getenv('BREVO_API_KEY') && !brevo_subscribe($email)) {
    error_log('MAS Brevo subscribe failed for ' . $email . ' (saved in subscribers.txt)');
}

$body = "New newsletter signup from masconsultancy.org\n\nEmail: $email\n";
$result = send_site_mail($TO, '[MAS Website] New newsletter subscriber', $body);
if (!$result['ok']) {
    error_log('MAS newsletter mail failed: ' . $result['error']);
}
// The signup is saved in subscribers.txt either way.
echo json_encode(['ok' => true]);
