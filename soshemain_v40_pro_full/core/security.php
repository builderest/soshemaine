<?php
if (session_status() === PHP_SESSION_NONE) {
    $config = require __DIR__ . '/config.php';
    session_name($config['security']['session_name']);
    session_start();
}

function csrf_token(): string
{
    $config = require __DIR__ . '/config.php';
    $name = $config['security']['csrf_token_name'];
    if (empty($_SESSION[$name])) {
        $_SESSION[$name] = bin2hex(random_bytes(32));
    }
    return $_SESSION[$name];
}

function csrf_input(): string
{
    $config = require __DIR__ . '/config.php';
    $name = $config['security']['csrf_token_name'];
    return '<input type="hidden" name="' . htmlspecialchars($name) . '" value="' . htmlspecialchars(csrf_token()) . '">';
}

function verify_csrf(): bool
{
    $config = require __DIR__ . '/config.php';
    $name = $config['security']['csrf_token_name'];
    $token = $_POST[$name] ?? '';
    return hash_equals($_SESSION[$name] ?? '', $token);
}

function rate_limited(string $action, int $max, int $decaySeconds): bool
{
    $key = 'rate_' . $action . '_' . md5($_SERVER['REMOTE_ADDR'] ?? 'cli');
    $bucket = $_SESSION[$key] ?? ['count' => 0, 'expires' => time() + $decaySeconds];
    if ($bucket['expires'] < time()) {
        $bucket = ['count' => 0, 'expires' => time() + $decaySeconds];
    }
    if ($bucket['count'] >= $max) {
        $_SESSION[$key] = $bucket;
        return true;
    }
    $bucket['count']++;
    $_SESSION[$key] = $bucket;
    return false;
}

function csrf_valid($token): bool
{
    $config = require __DIR__ . '/config.php';
    $name = $config['security']['csrf_token_name'];
    return hash_equals($_SESSION[$name] ?? '', $token ?? '');
}
