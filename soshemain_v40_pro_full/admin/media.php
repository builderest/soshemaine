<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../models/Media.php';
$mediaModel = new Media();
$message = '';
$uploadDir = __DIR__ . '/../public/uploads/';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf()) {
        $message = 'Token inválido.';
    } elseif (!empty($_FILES['files'])) {
        foreach ($_FILES['files']['tmp_name'] as $index => $tmpName) {
            if (!is_uploaded_file($tmpName)) {
                continue;
            }
            $name = basename($_FILES['files']['name'][$index]);
            $size = (int)$_FILES['files']['size'][$index];
            $mime = mime_content_type($tmpName);
            if ($size > 5 * 1024 * 1024) {
                $message = 'Archivo demasiado grande (máximo 5MB).';
                continue;
            }
            if (!preg_match('/image\/(png|jpeg|jpg|webp)/', $mime)) {
                $message = 'Formato no permitido.';
                continue;
            }
            $safeName = time() . '-' . preg_replace('/[^a-z0-9\.\-]/i', '_', $name);
            $destination = $uploadDir . $safeName;
            if (move_uploaded_file($tmpName, $destination)) {
                $width = $height = 0;
                if ($info = @getimagesize($destination)) {
                    [$width, $height] = $info;
                }
                $mediaModel->create([
                    'file_name' => $safeName,
                    'alt' => trim($_POST['alt'] ?? ''),
                    'width' => $width,
                    'height' => $height,
                    'mime' => $mime,
                    'size' => $size,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                if (function_exists('imagewebp') && !str_ends_with(strtolower($safeName), '.webp')) {
                    $source = null;
                    if (str_contains($mime, 'jpeg')) {
                        $source = imagecreatefromjpeg($destination);
                    } elseif (str_contains($mime, 'png')) {
                        $source = imagecreatefrompng($destination);
                    }
                    if ($source) {
                        imagepalettetotruecolor($source);
                        imagewebp($source, $uploadDir . pathinfo($safeName, PATHINFO_FILENAME) . '.webp', 80);
                        imagedestroy($source);
                    }
                }
            }
        }
        $message = $message ?: 'Archivos cargados correctamente.';
    }
}
if (isset($_GET['delete'])) {
    $item = $mediaModel->find((int)$_GET['delete']);
    if ($item) {
        @unlink($uploadDir . $item['file_name']);
        $mediaModel->delete($item['id']);
    }
    header('Location: media.php');
    exit;
}
$mediaFiles = $mediaModel->all();
?>
<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3">Biblioteca</h1>
            <p class="text-secondary">Administra imágenes y activos.</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">Subir archivos</button>
    </div>
    <?php if ($message): ?><div class="alert alert-info"><?= htmlspecialchars($message) ?></div><?php endif; ?>
    <div class="row g-4">
        <?php foreach ($mediaFiles as $file): ?>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card-glass p-3 h-100 d-flex flex-column">
                <img src="../public/uploads/<?= htmlspecialchars($file['file_name']) ?>" alt="<?= htmlspecialchars($file['alt']) ?>" class="rounded mb-3" loading="lazy">
                <div class="small text-secondary"><?= htmlspecialchars($file['mime']) ?> · <?= round($file['size']/1024, 1) ?>KB</div>
                <code class="small text-break">uploads/<?= htmlspecialchars($file['file_name']) ?></code>
                <a href="?delete=<?= $file['id'] ?>" class="btn btn-outline-danger btn-sm mt-3" onclick="return confirm('¿Eliminar archivo?');">Eliminar</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-white">
            <form method="post" enctype="multipart/form-data" class="modal-body d-grid gap-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="h5 mb-0">Subir archivos</h2>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <?= csrf_input() ?>
                <div>
                    <label class="form-label">Seleccionar imágenes</label>
                    <input type="file" name="files[]" class="form-control" accept="image/png,image/jpeg,image/webp" multiple required>
                </div>
                <div>
                    <label class="form-label">Texto alternativo</label>
                    <input type="text" name="alt" class="form-control" placeholder="Descripción accesible">
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Subir</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
