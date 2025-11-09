<?php
$title = 'Categories';
require_once __DIR__ . '/includes/header.php';
require_once BASE_PATH . '/core/db.php';
$categories = run_query('SELECT id, name, slug, type, parent_id FROM categories ORDER BY type, name');
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h4 fw-bold mb-0">Categories</h1>
    <a class="btn btn-primary" href="#">Add category</a>
</div>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Type</th>
                        <th>Parent</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?= e($category['name']) ?></td>
                        <td><?= e($category['slug']) ?></td>
                        <td><span class="badge bg-primary-subtle text-primary text-uppercase"><?= e($category['type']) ?></span></td>
                        <td><?= e($category['parent_id'] ?? '—') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
