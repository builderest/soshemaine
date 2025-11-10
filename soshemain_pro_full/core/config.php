<?php
// SOSHEMAIN configuration

define('APP_NAME', 'SOSHEMAIN');
define('APP_URL', 'https://soshemaine.net');

define('DB_HOST', 'localhost');
define('DB_NAME', 'u212136830_soshemaine');
define('DB_USER', 'u212136830_kings');
define('DB_PASS', '@Rm4766102');
define('DB_CHARSET', 'utf8mb4');

define('BASE_PATH', realpath(__DIR__ . '/..'));
define('PUBLIC_PATH', BASE_PATH);

define('APP_ENV', 'production');
define('APP_TIMEZONE', 'UTC');
date_default_timezone_set(APP_TIMEZONE);

// SMTP placeholders (editable via admin settings)
define('SMTP_HOST', 'smtp.example.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'no-reply@example.com');
define('SMTP_PASS', 'secret');
define('SMTP_FROM_EMAIL', 'no-reply@example.com');
define('SMTP_FROM_NAME', 'SOSHEMAIN Notifications');

define('RECAPTCHA_SITE_KEY', '');
define('RECAPTCHA_SECRET_KEY', '');

define('STRIPE_PUBLISHABLE_KEY', 'pk_test_xxx');
define('STRIPE_SECRET_KEY', 'sk_test_xxx');
define('PAYPAL_CLIENT_ID', '');

