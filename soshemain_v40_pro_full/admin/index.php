<?php
require_once __DIR__ . '/../core/auth.php';
require_once __DIR__ . '/../core/security.php';
require_once __DIR__ . '/../models/User.php';

if (Auth::check()) {
    header('Location: dashboard.php');
    exit;
}

$config = app_config('security');
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf()) {
        $message = 'Token CSRF inválido.';
    } elseif (rate_limited('admin_login', $config['rate_limit']['max_requests'], $config['rate_limit']['decay_minutes'] * 60)) {
        $message = 'Demasiados intentos. Intenta más tarde.';
    } else {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        if (Auth::attempt($email, $password)) {
            header('Location: dashboard.php');
            exit;
        }
        $message = 'Credenciales incorrectas.';
    }
}
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ingresar | SOSHEMAIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body class="d-flex align-items-center justify-content-center">
    <div class="card-glass p-5" style="max-width: 420px; width: 100%;">
        <div class="text-center mb-4">
            <span class="badge bg-primary rounded-pill">SOSHEMAIN</span>
            <h1 class="h4 mt-3">Panel administrativo</h1>
            <p class="text-secondary">Ingresa con tus credenciales.</p>
        </div>
        <?php if ($message): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <form method="post" class="d-grid gap-3">
            <?= csrf_input() ?>
            <div>
                <label class="form-label">Correo electrónico</label>
                <input type="email" name="email" class="form-control form-control-lg" required>
            </div>
            <div>
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control form-control-lg" required>
            </div>
            <div class="d-flex align-items-center justify-content-between">
                <label class="form-check-label text-secondary"><input type="checkbox" class="form-check-input"> Recordarme</label>
                <a href="password.php" class="text-primary">¿Olvidaste tu contraseña?</a>
            </div>
            <button type="submit" class="btn btn-primary btn-lg">Ingresar</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
