<?php
require_once __DIR__ . '/../core/bootstrap.php';

if (Auth::check()) {
    redirect('admin/index.php');
}

$error = null;
if (is_post()) {
    if (!Csrf::verify()) {
        $error = 'Invalid request, please try again.';
    } else {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $key = 'login_' . ($email ?: 'guest');
        if (!Security::rateLimit($key, 5, 900)) {
            $error = 'Too many attempts. Please wait before trying again.';
        } elseif (Auth::attempt($email, $password)) {
            Security::clearRateLimit($key);
            redirect('admin/index.php');
        } else {
            $error = 'Invalid credentials.';
        }
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login &mdash; <?php echo e(APP_NAME); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/tokens.css">
    <link rel="stylesheet" href="../css/site.css">
</head>
<body class="bg-body-tertiary">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h1 class="h3 text-center mb-3">Welcome back</h1>
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo e($error); ?></div>
                    <?php endif; ?>
                    <form method="post" class="needs-validation" novalidate>
                        <?php echo Csrf::field(); ?>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <a href="forgot.php" class="small">Forgot password?</a>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Sign in</button>
                    </form>
                </div>
            </div>
            <p class="text-center text-muted small mt-3">&copy; <?php echo date('Y'); ?> <?php echo e(APP_NAME); ?></p>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
