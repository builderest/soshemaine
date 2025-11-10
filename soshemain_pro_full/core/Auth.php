<?php

class Auth
{
    private const SESSION_KEY = 'soshemaine_user_id';

    public static function attempt(string $email, string $password): bool
    {
        $userModel = new UserModel();
        $user = $userModel->findByEmail($email);
        if (!$user) {
            return false;
        }
        if (!password_verify($password, $user['password'])) {
            return false;
        }
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        session_regenerate_id(true);
        $_SESSION[self::SESSION_KEY] = (int) $user['id'];
        $_SESSION['soshemaine_user'] = $user;
        return true;
    }

    public static function user(): ?array
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        return $_SESSION['soshemaine_user'] ?? null;
    }

    public static function check(): bool
    {
        return self::user() !== null;
    }

    public static function requireAuth(): void
    {
        if (!self::check()) {
            redirect('admin/login.php');
        }
    }

    public static function logout(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        unset($_SESSION[self::SESSION_KEY], $_SESSION['soshemaine_user']);
        session_regenerate_id(true);
    }
}

