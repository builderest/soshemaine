<?php
require_once __DIR__ . '/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_start();
}

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}

function is_post(): bool
{
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function old(string $key, $default = '')
{
    return $_POST[$key] ?? $default;
}

function flash(string $key, ?string $message = null)
{
    if ($message === null) {
        if (!isset($_SESSION['flash'][$key])) {
            return null;
        }
        $msg = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $msg;
    }
    $_SESSION['flash'][$key] = $message;
}

function app_asset(string $path): string
{
    return rtrim(APP_URL, '/') . '/' . ltrim($path, '/');
}

function format_currency(float $amount): string
{
    return '$' . number_format($amount, 2);
}

function current_user(): ?array
{
    return $_SESSION['auth_user'] ?? null;
}

function require_auth(): void
{
    if (!current_user()) {
        redirect('/admin/index.php');
    }
}

function maintenance_mode_guard(): void
{
    if (MAINTENANCE_MODE && (php_sapi_name() !== 'cli')) {
        $isAdminRoute = strpos($_SERVER['REQUEST_URI'] ?? '', '/admin') === 0;
        if ($isAdminRoute && current_user()) {
            return;
        }
        http_response_code(503);
        echo '<h1>Maintenance</h1><p>We are currently updating our site. Please check back soon.</p>';
        exit;
    }
}

maintenance_mode_guard();

function audit_log(string $action, string $label, string $payload = ''): void
{
    if (!file_exists(LOG_PATH)) {
        @mkdir(LOG_PATH, 0775, true);
    }
    $line = sprintf("%s\t%s\t%s\t%s\n", date('c'), $action, $label, substr($payload, 0, 5000));
    file_put_contents(LOG_PATH . '/audit.log', $line, FILE_APPEND);
}
