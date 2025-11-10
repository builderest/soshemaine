<?php

class Security
{
    public static function rateLimit(string $key, int $limit = 5, int $decay = 900): bool
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $bucket = $_SESSION['rate_limit'][$key] ?? ['attempts' => 0, 'expires' => time() + $decay];
        if ($bucket['expires'] < time()) {
            $bucket = ['attempts' => 0, 'expires' => time() + $decay];
        }
        $bucket['attempts']++;
        $_SESSION['rate_limit'][$key] = $bucket;
        return $bucket['attempts'] <= $limit;
    }

    public static function clearRateLimit(string $key): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        unset($_SESSION['rate_limit'][$key]);
    }
}

