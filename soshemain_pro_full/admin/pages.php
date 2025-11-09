<?php
$title = 'Pages';
require_once __DIR__ . '/includes/header.php';
require_once BASE_PATH . '/core/db.php';
$pages = run_query('SELECT id, title, slug, status, updated_at FROM pages ORDER BY updated_at DESC');
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h4 fw-bold mb-0">Pages</h1>
    <a class="btn btn-primary" href="#">New page</a>
</div>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Updated</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pages as $page): ?>
                    <tr>
                        <td><?= e($page['title']) ?></td>
                        <td><?= e($page['slug']) ?></td>
                        <td><span class="badge bg-<?= $page['status'] === 'published' ? 'success' : 'secondary' ?> text-uppercase"><?= e($page['status']) ?></span></td>
                        <td><?= date('M j, Y g:i a', strtotime($page['updated_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
