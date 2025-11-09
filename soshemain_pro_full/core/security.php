<?php
require_once __DIR__ . '/helpers.php';

function csrf_token(): string
{
    if (empty($_SESSION[CSRF_TOKEN_NAME])) {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }
    return $_SESSION[CSRF_TOKEN_NAME];
}

function csrf_field(): string
{
    return '<input type="hidden" name="_token" value="' . e(csrf_token()) . '">';
}

function verify_csrf(): bool
{
    if (!isset($_POST['_token'], $_SESSION[CSRF_TOKEN_NAME])) {
        return false;
    }
    return hash_equals($_SESSION[CSRF_TOKEN_NAME], $_POST['_token']);
}

function rate_limit_key(string $action): string
{
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'cli';
    return sha1($action . '|' . $ip);
}

function check_rate_limit(string $action, int $maxAttempts = RATE_LIMIT_MAX_ATTEMPTS, int $windowSeconds = RATE_LIMIT_WINDOW): bool
{
    $key = rate_limit_key($action);
    $attempts = $_SESSION['rate_limit'][$key]['attempts'] ?? 0;
    $firstAttempt = $_SESSION['rate_limit'][$key]['first'] ?? time();

    if (time() - $firstAttempt > $windowSeconds) {
        $_SESSION['rate_limit'][$key] = ['attempts' => 1, 'first' => time()];
        return true;
    }

    if ($attempts >= $maxAttempts) {
        return false;
    }

    $_SESSION['rate_limit'][$key]['attempts'] = $attempts + 1;
    $_SESSION['rate_limit'][$key]['first'] = $firstAttempt;
    return true;
}

function clear_rate_limit(string $action): void
{
    $key = rate_limit_key($action);
    unset($_SESSION['rate_limit'][$key]);
}
