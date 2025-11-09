<?php
$title = 'Roles';
require_once __DIR__ . '/includes/header.php';
require_once BASE_PATH . '/core/db.php';
$roles = run_query('SELECT id, name, permissions FROM roles ORDER BY name');
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h4 fw-bold mb-0">Roles & Permissions</h1>
    <a class="btn btn-primary" href="#">Add role</a>
</div>
<div class="row g-4">
    <?php foreach ($roles as $role): ?>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <h2 class="h5 fw-bold mb-3"><?= e($role['name']) ?></h2>
                <pre class="bg-body-tertiary rounded-3 p-3 small mb-0"><?= e(json_encode(json_decode($role['permissions'], true), JSON_PRETTY_PRINT)) ?></pre>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
