<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../models/Settings.php';
$settingsModel = new Settings();
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf()) {
    $settingsModel->update('maintenance_mode', ['value' => $_POST['maintenance_mode'] ?? 'off']);
    $message = 'Modo actualizado.';
}
$maintenance = site_setting('maintenance_mode', 'off');
?>
<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3">Mantenimiento</h1>
            <p class="text-secondary">Activa un mensaje global de pausa operativa.</p>
        </div>
    </div>
    <?php if ($message): ?><div class="alert alert-info"><?= htmlspecialchars($message) ?></div><?php endif; ?>
    <form method="post" class="card-glass p-4 d-grid gap-3" style="max-width: 540px;">
        <?= csrf_input() ?>
        <div>
            <label class="form-label">Estado</label>
            <select name="maintenance_mode" class="form-select">
                <option value="off" <?= $maintenance === 'off' ? 'selected' : '' ?>>Sitio activo</option>
                <option value="on" <?= $maintenance === 'on' ? 'selected' : '' ?>>Modo mantenimiento</option>
            </select>
        </div>
        <p class="text-secondary small">Cuando está activo, los visitantes verán un mensaje informando que estamos realizando mejoras.</p>
        <button class="btn btn-primary">Guardar</button>
    </form>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
