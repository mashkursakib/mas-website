<?php
// MAS Consultancy — dependency-free SMTP mailer.
//
// PHP's mail() has no mail server inside the Render Docker image, so the
// contact and newsletter forms send through SMTP instead. Settings come
// from environment variables (set in the Render dashboard, never in the
// repo — this repo is public):
//
//   SMTP_HOST       e.g. mail.spacemail.com
//   SMTP_PORT       465 (implicit TLS) or 587 (STARTTLS)
//   SMTP_SECURE     ssl | tls | none   (default: ssl on 465, tls on 587)
//   SMTP_USER       full mailbox address, e.g. info@masconsultancy.org
//   SMTP_PASS       the mailbox password
//   SMTP_FROM       From address (default: SMTP_USER)
//   SMTP_FROM_NAME  From display name (default: MAS Website)

function smtp_env($key, $default = '') {
    $v = getenv($key);
    if ($v === false && isset($_SERVER[$key])) {
        $v = $_SERVER[$key];
    }
    return ($v === false || $v === '') ? $default : $v;
}

function smtp_configured() {
    return smtp_env('SMTP_HOST') !== ''
        && smtp_env('SMTP_USER') !== ''
        && smtp_env('SMTP_PASS') !== '';
}

// Read one SMTP response (possibly multi-line). Returns [code, text].
function smtp_read($fp) {
    $text = '';
    $code = 0;
    while (($line = fgets($fp, 1024)) !== false) {
        $text .= $line;
        if (preg_match('/^(\d{3})([ -])/', $line, $m)) {
            $code = (int) $m[1];
            if ($m[2] === ' ') {
                break;
            }
        }
    }
    return [$code, trim($text)];
}

// Send one command and check the response code is in $want.
function smtp_cmd($fp, $cmd, array $want) {
    fwrite($fp, $cmd . "\r\n");
    [$code, $text] = smtp_read($fp);
    if (!in_array($code, $want, true)) {
        throw new Exception("SMTP error after [$cmd]: $code $text");
    }
    return $text;
}

// Encode a header value with non-ASCII chars (RFC 2047, base64 UTF-8).
function smtp_encode_header($value) {
    if (!preg_match('/[^\x20-\x7E]/', $value)) {
        return $value;
    }
    return '=?UTF-8?B?' . base64_encode($value) . '?=';
}

// Send a plain-text email. Returns ['ok' => bool, 'error' => string].
function send_mail_smtp($to, $subject, $body, $replyTo = '') {
    if (!smtp_configured()) {
        return ['ok' => false, 'error' => 'SMTP is not configured (SMTP_HOST/SMTP_USER/SMTP_PASS).'];
    }
    $host   = smtp_env('SMTP_HOST');
    $port   = (int) smtp_env('SMTP_PORT', '465');
    $secure = strtolower(smtp_env('SMTP_SECURE', $port === 587 ? 'tls' : 'ssl'));
    $user   = smtp_env('SMTP_USER');
    $pass   = smtp_env('SMTP_PASS');
    $from   = smtp_env('SMTP_FROM', $user);
    $fromName = smtp_env('SMTP_FROM_NAME', 'MAS Website');

    $context = stream_context_create([
        'ssl' => [
            'verify_peer' => true,
            'verify_peer_name' => true,
            'allow_self_signed' => false,
            'SNI_enabled' => true,
            'peer_name' => $host,
        ],
    ]);

    try {
        if ($secure === 'ssl') {
            $fp = @stream_socket_client(
                "ssl://$host:$port", $errno, $errstr, 15,
                STREAM_CLIENT_CONNECT, $context
            );
        } else {
            $fp = @stream_socket_client(
                "tcp://$host:$port", $errno, $errstr, 15,
                STREAM_CLIENT_CONNECT, $context
            );
        }
        if (!$fp) {
            return ['ok' => false, 'error' => "Could not connect to SMTP $host:$port ($errstr)."];
        }
        stream_set_timeout($fp, 15);

        [$code] = smtp_read($fp);
        if ($code !== 220) {
            fclose($fp);
            return ['ok' => false, 'error' => "SMTP greeting failed ($code)."];
        }

        $ehloHost = $_SERVER['HTTP_HOST'] ?? 'masconsultancy.org';
        smtp_cmd($fp, "EHLO $ehloHost", [250]);

        if ($secure === 'tls') {
            smtp_cmd($fp, 'STARTTLS', [220]);
            $crypto = @stream_socket_enable_crypto($fp, true, STREAM_CRYPTO_METHOD_TLS_CLIENT, $context);
            if (!$crypto) {
                fclose($fp);
                return ['ok' => false, 'error' => 'STARTTLS negotiation failed.'];
            }
            smtp_cmd($fp, "EHLO $ehloHost", [250]);
        }

        smtp_cmd($fp, 'AUTH LOGIN', [334]);
        smtp_cmd($fp, base64_encode($user), [334]);
        smtp_cmd($fp, base64_encode($pass), [235]);

        smtp_cmd($fp, "MAIL FROM:<$from>", [250]);
        smtp_cmd($fp, "RCPT TO:<$to>", [250, 251]);
        smtp_cmd($fp, 'DATA', [354]);

        $headers = '';
        $headers .= 'From: ' . smtp_encode_header($fromName) . " <$from>\r\n";
        $headers .= "To: <$to>\r\n";
        if ($replyTo !== '') {
            $headers .= "Reply-To: <$replyTo>\r\n";
        }
        $headers .= 'Subject: ' . smtp_encode_header($subject) . "\r\n";
        $headers .= 'Date: ' . date('r') . "\r\n";
        $headers .= 'Message-ID: <' . bin2hex(random_bytes(8)) . '@' . $ehloHost . ">\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $headers .= "Content-Transfer-Encoding: 8bit\r\n";
        $headers .= "MIME-Version: 1.0\r\n";

        // Dot-stuff lines starting with a dot; normalize line endings.
        $body = str_replace(["\r\n", "\r"], "\n", $body);
        $lines = explode("\n", $body);
        foreach ($lines as &$line) {
            if (str_starts_with($line, '.')) {
                $line = '.' . $line;
            }
        }
        unset($line);
        $data = $headers . "\r\n" . implode("\r\n", $lines) . "\r\n.";

        smtp_cmd($fp, $data, [250]);
        fwrite($fp, "QUIT\r\n");
        fclose($fp);
        return ['ok' => true, 'error' => ''];
    } catch (Exception $e) {
        if (isset($fp) && is_resource($fp)) {
            fclose($fp);
        }
        return ['ok' => false, 'error' => $e->getMessage()];
    }
}
