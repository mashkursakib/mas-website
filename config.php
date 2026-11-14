<?php
// MAS Consultancy — admin configuration.
// ---------------------------------------------------------------------------
// CHANGE THE PASSWORD on first login (Admin > Settings > Change password).
// Default login:  admin / changeme123
// This file is blocked from direct web access by .htaccess — never remove
// that rule, and never share this file.
// ---------------------------------------------------------------------------

define('ADMIN_USER', 'admin');

// bcrypt hash of the admin password. The Settings page rewrites this line
// when the password is changed — do not edit it by hand.
define('ADMIN_PASS_HASH', '$2b$12$Woal3.t6LBL4bxSm66UEvuY8bb14htD6oDGsEU0EJvQpYdU.zYYay');

// Login brute-force protection: lock out for 10 minutes after 5 failures.
define('LOGIN_MAX_ATTEMPTS', 5);
define('LOGIN_LOCKOUT_SECONDS', 600);
