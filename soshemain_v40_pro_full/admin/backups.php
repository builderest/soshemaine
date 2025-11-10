<?php
require_once __DIR__ . '/includes/header.php';
$message = '';
$backupDir = __DIR__ . '/../backups/';
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0755, true);
}
if (isset($_POST['create_backup']) && verify_csrf()) {
    $filename = 'backup-' . date('Ymd-His') . '.zip';
    $zipPath = $backupDir . $filename;
    $zip = new ZipArchive();
    if ($zip->open($zipPath, ZipArchive::CREATE) === true) {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__ . '/../public/uploads/', RecursiveDirectoryIterator::SKIP_DOTS));
        foreach ($iterator as $file) {
            $local = 'uploads/' . $iterator->getSubPathName();
            $zip->addFile($file->getPathname(), $local);
        }
        $zip->close();
        $message = 'Backup generado: ' . $filename;
    } else {
        $message = 'No se pudo generar el backup.';
    }
}
$backups = glob($backupDir . '*.zip');
?>
<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3">Backups</h1>
            <p class="text-secondary">Descarga respaldos de uploads y base de datos.</p>
        </div>
        <form method="post">
            <?= csrf_input() ?>
            <button class="btn btn-primary" name="create_backup">Generar backup</button>
        </form>
    </div>
    <?php if ($message): ?><div class="alert alert-info"><?= htmlspecialchars($message) ?></div><?php endif; ?>
    <div class="card-glass p-4">
        <table class="table table-dark align-middle">
            <thead><tr><th>Archivo</th><th>Fecha</th><th>Peso</th><th></th></tr></thead>
            <tbody>
                <?php foreach ($backups as $file): $basename = basename($file); ?>
                <tr>
                    <td><?= htmlspecialchars($basename) ?></td>
                    <td><?= date('d/m/Y H:i', filemtime($file)) ?></td>
                    <td><?= round(filesize($file)/1024, 1) ?> KB</td>
                    <td><a href="../backups/<?= htmlspecialchars($basename) ?>" class="btn btn-outline-light btn-sm">Descargar</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
