<?php
$title = 'Media library';
require_once __DIR__ . '/includes/header.php';
require_once BASE_PATH . '/core/db.php';
$media = run_query('SELECT id, filename, mime_type, size, created_at FROM media ORDER BY created_at DESC');
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h4 fw-bold mb-0">Media library</h1>
    <a class="btn btn-primary" href="#">Upload files</a>
</div>
<div class="row g-4">
    <?php foreach ($media as $item): ?>
    <div class="col-md-3">
        <div class="card shadow-sm border-0 h-100">
            <img src="/uploads/<?= e($item['filename']) ?>" class="card-img-top" alt="<?= e($item['filename']) ?>">
            <div class="card-body">
                <h2 class="h6 fw-bold mb-1"><?= e($item['filename']) ?></h2>
                <p class="text-secondary small mb-0"><?= e($item['mime_type']) ?> • <?= number_format($item['size'] / 1024, 1) ?> KB</p>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
