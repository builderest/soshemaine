<?php
require_once __DIR__ . '/../core/helpers.php';
require_once BASE_PATH . '/core/auth.php';
require_once BASE_PATH . '/core/security.php';

$success = flash('success');
$error = flash('error');

if (is_post()) {
    if (!verify_csrf()) {
        flash('error', 'Security token mismatch.');
        redirect('/admin/index.php');
    }
    if (!check_rate_limit('admin_login', 5, 600)) {
        flash('error', 'Too many login attempts. Try again later.');
        redirect('/admin/index.php');
    }
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if (authenticate($email, $password)) {
        clear_rate_limit('admin_login');
        flash('success', 'Welcome back!');
        redirect('/admin/dashboard.php');
    }
    flash('error', 'Invalid credentials.');
    redirect('/admin/index.php');
}

?><!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SOSHEMAIN Admin Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-body-tertiary">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h1 class="h4 fw-bold mb-4 text-center">SOSHEMAIN Admin</h1>
                        <?php if ($success): ?><div class="alert alert-success"><?= e($success) ?></div><?php endif; ?>
                        <?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
                        <form method="post">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input class="form-control" id="email" type="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="password">Password</label>
                                <input class="form-control" id="password" type="password" name="password" required>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <a class="small" href="#">Forgot password?</a>
                            </div>
                            <button class="btn btn-primary w-100" type="submit">Sign in</button>
                        </form>
                    </div>
                </div>
                <p class="text-center small text-secondary mt-3">Default admin: admin@soshemain.com / ChangeMe!2025</p>
            </div>
        </div>
    </div>
</body>
</html>
