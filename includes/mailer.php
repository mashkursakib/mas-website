<?php
// MAS Consultancy — email sender via the Resend HTTPS API.
//
// Render blocks outbound SMTP (ports 465 and 587 both time out from the
// service), so the contact and newsletter forms send through Resend
// instead, over HTTPS on port 443. Settings come from environment
// variables (set in the Render dashboard, never in the repo — this repo
// is public):
//
//   RESEND_API_KEY   e.g. re_... (from resend.com/api-keys)
//   RESEND_FROM      From address (default: MAS Website <info@masconsultancy.org>;
//                    must be on a domain verified in Resend)

function mailer_env($key, $default = '') {
    $v = getenv($key);
    if ($v === false && isset($_SERVER[$key])) {
        $v = $_SERVER[$key];
    }
    return ($v === false || $v === '') ? $default : $v;
}

function site_mail_configured() {
    return mailer_env('RESEND_API_KEY') !== '';
}

// Send a plain-text email. Returns ['ok' => bool, 'error' => string].
function send_site_mail($to, $subject, $body, $replyTo = '') {
    $key = mailer_env('RESEND_API_KEY');
    if ($key === '') {
        return ['ok' => false, 'error' => 'Email is not configured (RESEND_API_KEY).'];
    }

    $payload = [
        'from' => mailer_env('RESEND_FROM', 'MAS Website <info@masconsultancy.org>'),
        'to' => [$to],
        'subject' => $subject,
        'text' => $body,
    ];
    if ($replyTo !== '') {
        $payload['reply_to'] = $replyTo;
    }

    $ctx = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => "Authorization: Bearer $key\r\nContent-Type: application/json\r\n",
            'content' => json_encode($payload),
            'timeout' => 20,
            'ignore_errors' => true,
        ],
        'ssl' => [
            'verify_peer' => true,
            'verify_peer_name' => true,
        ],
    ]);

    $response = @file_get_contents('https://api.resend.com/emails', false, $ctx);

    $status = 0;
    if (isset($http_response_header) && is_array($http_response_header)) {
        foreach ($http_response_header as $h) {
            if (preg_match('#^HTTP/\S+\s+(\d{3})#', $h, $m)) {
                $status = (int) $m[1];
            }
        }
    }

    if ($response === false) {
        return ['ok' => false, 'error' => 'Could not reach the email API.'];
    }
    if ($status === 200) {
        return ['ok' => true, 'error' => ''];
    }
    $data = json_decode($response, true);
    $msg = $data['message'] ?? ('Email API error (HTTP ' . $status . ').');
    return ['ok' => false, 'error' => $msg];
}
