<?php
require_once __DIR__ . '/../core/bootstrap.php';

$message = null;
if (is_post() && Csrf::verify()) {
    $message = 'If the email exists we have sent reset instructions.';
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password reset &mdash; <?php echo e(APP_NAME); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/tokens.css">
    <link rel="stylesheet" href="../css/site.css">
</head>
<body class="bg-body-tertiary">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h1 class="h4 mb-3">Reset password</h1>
                    <?php if ($message): ?>
                        <div class="alert alert-success"><?php echo e($message); ?></div>
                    <?php endif; ?>
                    <form method="post">
                        <?php echo Csrf::field(); ?>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Send reset link</button>
                    </form>
                </div>
            </div>
            <p class="text-center small mt-3"><a href="login.php">Back to login</a></p>
        </div>
    </div>
</div>
</body>
</html>
