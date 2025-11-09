<?php
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/db.php';

function authenticate(string $email, string $password): bool
{
    $user = run_query_one('SELECT * FROM users WHERE email = ? LIMIT 1', [$email]);
    if (!$user || !password_verify($password, $user['password'])) {
        return false;
    }
    $_SESSION['auth_user'] = $user;
    return true;
}

function logout(): void
{
    unset($_SESSION['auth_user']);
}

function require_admin(): void
{
    if (!current_user()) {
        redirect('/admin/index.php');
    }
}
