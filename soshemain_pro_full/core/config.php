<?php
/**
 * SOSHEMAIN configuration file.
 * Update credentials and application settings before deploying.
 */

// Application configuration
define('APP_NAME', 'SOSHEMAIN');
define('APP_TAGLINE', 'Innovation that drives results.');
define('APP_URL', 'https://example.com');
define('APP_ENV', 'production');

define('APP_TIMEZONE', 'UTC');
@date_default_timezone_set(APP_TIMEZONE);

// Database credentials
define('DB_HOST', '127.0.0.1');
define('DB_PORT', 3306);
define('DB_NAME', 'soshemain');
define('DB_USER', 'root');
define('DB_PASS', '');

// Security keys
if (!defined('APP_KEY')) {
    define('APP_KEY', bin2hex(random_bytes(16)));
}

define('SESSION_NAME', 'soshemain_session');
define('CSRF_TOKEN_NAME', 'soshemain_csrf_token');

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
define('STRIPE_WEBHOOK_SECRET', 'whsec_xxx');

define('PAYPAL_CLIENT_ID', '');
define('PAYPAL_CLIENT_SECRET', '');
define('PAYPAL_WEBHOOK_ID', '');

// File upload settings
define('UPLOAD_MAX_SIZE', 5 * 1024 * 1024); // 5MB
$allowedImageTypes = ['image/jpeg', 'image/png', 'image/webp'];

define('MAINTENANCE_MODE', false);

define('EMAIL_BRAND_COLOR', '#2563EB');

define('PASSWORD_RESET_EXPIRY', 60 * 60); // 1 hour

define('RATE_LIMIT_WINDOW', 900); // 15 minutes

define('RATE_LIMIT_MAX_ATTEMPTS', 10);

// Paths
if (!defined('BASE_PATH')) {
    define('BASE_PATH', realpath(__DIR__ . '/..'));
}

define('PUBLIC_PATH', BASE_PATH . '/public');
define('ADMIN_PATH', BASE_PATH . '/admin');

define('LOG_PATH', BASE_PATH . '/storage/logs');
if (!is_dir(LOG_PATH)) {
    @mkdir(LOG_PATH, 0775, true);
}
