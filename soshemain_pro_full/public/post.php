<?php
require_once __DIR__ . '/../core/helpers.php';
require_once BASE_PATH . '/core/db.php';

$slug = $_GET['slug'] ?? '';
$post = run_query_one('SELECT * FROM posts WHERE slug = ? AND status = "published" LIMIT 1', [$slug]);
if (!$post) {
    http_response_code(404);
    echo 'Post not found';
    exit;
}

$related = run_query('SELECT title, slug FROM posts WHERE status = "published" AND id != ? ORDER BY published_at DESC LIMIT 4', [$post['id']]);

ob_start();
?>
<section class="py-5 bg-body-tertiary">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/blog.php">Insights</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= e($post['title']) ?></li>
            </ol>
        </nav>
        <article class="row g-5">
            <div class="col-lg-8">
                <img class="img-fluid rounded-4 shadow mb-4" src="/images/blog/<?= e($post['hero_image']) ?>" alt="<?= e($post['title']) ?>">
                <span class="badge bg-primary-subtle text-primary mb-3"><?= date('M j, Y', strtotime($post['published_at'])) ?></span>
                <h1 class="display-5 fw-bold mb-4"><?= e($post['title']) ?></h1>
                <div class="fs-5 lh-lg">
                    <?= $post['body'] ?>
                </div>
                <div class="mt-5 p-4 bg-body rounded-4 shadow-sm">
                    <h2 class="h5 fw-bold mb-2">Share this article</h2>
                    <div class="d-flex gap-3">
                        <a class="btn btn-outline-primary btn-sm" href="https://twitter.com/intent/tweet?url=<?= urlencode(APP_URL . '/post.php?slug=' . $post['slug']) ?>&text=<?= urlencode($post['title']) ?>">Twitter</a>
                        <a class="btn btn-outline-primary btn-sm" href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode(APP_URL . '/post.php?slug=' . $post['slug']) ?>">LinkedIn</a>
                    </div>
                </div>
            </div>
            <aside class="col-lg-4">
                <div class="border rounded-4 p-4 mb-4">
                    <h2 class="h5 fw-bold mb-3">Key takeaways</h2>
                    <p class="text-secondary mb-0"><?= e($post['excerpt']) ?></p>
                </div>
                <div class="border rounded-4 p-4">
                    <h2 class="h5 fw-bold mb-3">More insights</h2>
                    <ul class="list-unstyled mb-0">
                        <?php foreach ($related as $rel): ?>
                        <li class="mb-2"><a href="/post.php?slug=<?= urlencode($rel['slug']) ?>" class="text-secondary"><?= e($rel['title']) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </aside>
        </article>
    </div>
</section>
<?php
$content = ob_get_clean();
$title = e($post['title']) . ' — SOSHEMAIN insights';
$metaDescription = strip_tags($post['meta_description'] ?? $post['excerpt']);
require BASE_PATH . '/views/layouts/main.php';
