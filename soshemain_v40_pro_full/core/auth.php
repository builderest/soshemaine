<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/security.php';

if (session_status() === PHP_SESSION_NONE) {
    $config = require __DIR__ . '/config.php';
    session_name($config['security']['session_name']);
    session_start();
}

class Auth
{
    public static function attempt(string $email, string $password): bool
    {
        global $pdo;
        $config = require __DIR__ . '/config.php';
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $attemptsKey = 'login_attempts_' . md5($_SERVER['REMOTE_ADDR'] ?? 'cli');
        $lockKey = 'login_locked_until_' . md5($_SERVER['REMOTE_ADDR'] ?? 'cli');

        if (!empty($_SESSION[$lockKey]) && time() < $_SESSION[$lockKey]) {
            return false;
        }

        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email AND status = "active" LIMIT 1');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role']
            ];
            $_SESSION[$attemptsKey] = 0;
            return true;
        }

        $attempts = ($_SESSION[$attemptsKey] ?? 0) + 1;
        $_SESSION[$attemptsKey] = $attempts;
        if ($attempts >= $config['security']['login_attempts']) {
            $_SESSION[$lockKey] = time() + ($config['security']['login_lock_minutes'] * 60);
        }
        return false;
    }

    public static function check(): bool
    {
        return !empty($_SESSION['user']);
    }

    public static function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    public static function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
    }
}
