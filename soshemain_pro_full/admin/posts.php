<?php
$title = 'Blog posts';
require_once __DIR__ . '/includes/header.php';
require_once BASE_PATH . '/core/db.php';
$posts = run_query('SELECT title, slug, status, published_at FROM posts ORDER BY published_at DESC');
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h4 fw-bold mb-0">Blog posts</h1>
    <a class="btn btn-primary" href="#">New post</a>
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
                        <th>Published</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post): ?>
                    <tr>
                        <td><?= e($post['title']) ?></td>
                        <td><?= e($post['slug']) ?></td>
                        <td><span class="badge bg-<?= $post['status'] === 'published' ? 'success' : 'secondary' ?> text-uppercase"><?= e($post['status']) ?></span></td>
                        <td><?= $post['published_at'] ? date('M j, Y', strtotime($post['published_at'])) : '—' ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
