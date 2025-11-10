<?php
require_once __DIR__ . '/../core/helpers.php';
require_once __DIR__ . '/../core/security.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf()) {
        $message = 'Token inválido.';
    } else {
        $message = 'Si el correo existe, enviaremos instrucciones para restablecer la contraseña.';
    }
}
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recuperar contraseña | SOSHEMAIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body class="d-flex align-items-center justify-content-center">
    <div class="card-glass p-5" style="max-width: 420px; width: 100%;">
        <h1 class="h4 mb-3">Recuperar contraseña</h1>
        <p class="text-secondary">Ingresa tu correo para recibir un enlace temporal.</p>
        <?php if ($message): ?><div class="alert alert-info"><?= htmlspecialchars($message) ?></div><?php endif; ?>
        <form method="post" class="d-grid gap-3">
            <?= csrf_input() ?>
            <div>
                <label class="form-label">Correo</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <button class="btn btn-primary">Enviar instrucciones</button>
            <a href="index.php" class="text-secondary text-center">Volver al login</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
