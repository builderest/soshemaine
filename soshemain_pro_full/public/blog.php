<?php
require_once __DIR__ . '/../core/helpers.php';
require_once BASE_PATH . '/core/db.php';

$page = max(1, (int) ($_GET['page'] ?? 1));
$perPage = 6;
$offset = ($page - 1) * $perPage;
$posts = run_query("SELECT id, title, slug, excerpt, hero_image, published_at FROM posts WHERE status = 'published' ORDER BY published_at DESC LIMIT $perPage OFFSET $offset");
$total = run_query_one('SELECT COUNT(*) as count FROM posts WHERE status = "published"')['count'] ?? 0;
$totalPages = max(1, (int) ceil($total / $perPage));
$categories = run_query('SELECT name, slug FROM categories WHERE type = "post" ORDER BY name');

ob_start();
?>
<section class="py-5 bg-body-tertiary">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold mb-3">SOSHEMAIN insights</h1>
                <p class="text-secondary mb-0">Analysis on emerging technology, growth marketing, and digital experience design.</p>
            </div>
        </div>
    </div>
</section>
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="row g-4">
                    <?php foreach ($posts as $post): ?>
                    <div class="col-md-6">
                        <article class="card h-100 border-0 shadow-sm">
                            <img class="card-img-top" src="/images/blog/<?= e($post['hero_image']) ?>" alt="<?= e($post['title']) ?>">
                            <div class="card-body d-flex flex-column">
                                <span class="badge bg-primary-subtle text-primary mb-3"><?= date('M j, Y', strtotime($post['published_at'])) ?></span>
                                <h2 class="h5 fw-bold"><a class="text-decoration-none" href="/post.php?slug=<?= urlencode($post['slug']) ?>"><?= e($post['title']) ?></a></h2>
                                <p class="text-secondary flex-grow-1"><?= e($post['excerpt']) ?></p>
                                <a class="fw-semibold" href="/post.php?slug=<?= urlencode($post['slug']) ?>">Read more <i class="bi bi-arrow-up-right"></i></a>
                            </div>
                        </article>
                    </div>
                    <?php endforeach; ?>
                </div>
                <nav class="mt-4" aria-label="Blog pagination">
                    <ul class="pagination">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= $i === $page ? 'active' : '' ?>"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-4">
                <div class="border rounded-4 p-4 mb-4">
                    <h5 class="fw-bold mb-3">Categories</h5>
                    <ul class="list-unstyled mb-0">
                        <?php foreach ($categories as $category): ?>
                        <li class="mb-2"><a href="/blog.php?category=<?= urlencode($category['slug']) ?>" class="text-secondary"><?= e($category['name']) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="border rounded-4 p-4">
                    <h5 class="fw-bold mb-3">Subscribe</h5>
                    <p class="text-secondary">Monthly round-up on innovation and digital growth.</p>
                    <form>
                        <div class="mb-3">
                            <label class="form-label" for="subscribeEmail">Email</label>
                            <input class="form-control" id="subscribeEmail" type="email" placeholder="you@example.com">
                        </div>
                        <button class="btn btn-primary w-100" type="button">Join newsletter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
$title = 'Blog — SOSHEMAIN';
$metaDescription = 'Thought leadership from the SOSHEMAIN team covering AI, ecommerce, customer experience, and marketing innovation.';
require BASE_PATH . '/views/layouts/main.php';
