<?php
require_once __DIR__ . '/../core/helpers.php';
require_once BASE_PATH . '/core/db.php';

$categorySlug = $_GET['category'] ?? null;
$search = trim($_GET['search'] ?? '');
$sort = $_GET['sort'] ?? 'latest';
$page = max(1, (int) ($_GET['page'] ?? 1));
$perPage = 9;
$offset = ($page - 1) * $perPage;

$where = ['status = "published"'];
$params = [];
if ($categorySlug) {
    $where[] = 'id IN (SELECT product_id FROM product_category WHERE category_id = (SELECT id FROM categories WHERE slug = ? LIMIT 1))';
    $params[] = $categorySlug;
}
if ($search !== '') {
    $where[] = '(name LIKE ? OR short_description LIKE ? OR description LIKE ?)';
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}
$order = 'ORDER BY created_at DESC';
if ($sort === 'price_asc') {
    $order = 'ORDER BY price ASC';
} elseif ($sort === 'price_desc') {
    $order = 'ORDER BY price DESC';
} elseif ($sort === 'featured') {
    $order = 'ORDER BY featured DESC, created_at DESC';
}

$whereSql = implode(' AND ', $where);
$total = run_query_one("SELECT COUNT(*) as count FROM products WHERE $whereSql", $params)['count'] ?? 0;
$products = run_query("SELECT * FROM products WHERE $whereSql $order LIMIT $perPage OFFSET $offset", $params);
$categories = run_query('SELECT id, name, slug FROM categories WHERE type = "product" ORDER BY name');
$totalPages = max(1, (int) ceil($total / $perPage));

ob_start();
?>
<section class="py-5 bg-body-tertiary">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold mb-3">Digital products built to activate growth</h1>
                <p class="text-secondary mb-0">Toolkits, playbooks, and automation frameworks curated by the SOSHEMAIN team to accelerate your next sprint.</p>
            </div>
            <div class="col-lg-4">
                <form class="d-flex" method="get">
                    <input class="form-control me-2" type="search" name="search" placeholder="Search products" value="<?= e($search) ?>">
                    <button class="btn btn-primary" type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>
</section>
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3">
                <div class="border rounded-4 p-4 mb-4">
                    <h5 class="fw-bold mb-3">Categories</h5>
                    <ul class="list-unstyled">
                        <li><a class="<?= $categorySlug ? 'text-secondary' : 'fw-semibold' ?>" href="/products.php">All products</a></li>
                        <?php foreach ($categories as $category): ?>
                        <li class="mt-2"><a class="<?= $categorySlug === $category['slug'] ? 'fw-semibold' : 'text-secondary' ?>" href="?category=<?= urlencode($category['slug']) ?>"><?= e($category['name']) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="border rounded-4 p-4">
                    <h5 class="fw-bold mb-3">Sort by</h5>
                    <select class="form-select" onchange="window.location = '?<?= http_build_query(array_merge($_GET, ['sort' => ''])) ?>'.replace('sort=', 'sort=' + this.value)">
                        <option value="latest" <?= $sort === 'latest' ? 'selected' : '' ?>>Newest</option>
                        <option value="price_asc" <?= $sort === 'price_asc' ? 'selected' : '' ?>>Price: Low to High</option>
                        <option value="price_desc" <?= $sort === 'price_desc' ? 'selected' : '' ?>>Price: High to Low</option>
                        <option value="featured" <?= $sort === 'featured' ? 'selected' : '' ?>>Featured</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="row g-4">
                    <?php foreach ($products as $product): ?>
                    <div class="col-md-6 col-xl-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <img class="card-img-top" src="/images/products/<?= e($product['slug']) ?>.jpg" alt="<?= e($product['name']) ?>">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= e($product['name']) ?></h5>
                                <p class="text-secondary flex-grow-1"><?= e($product['short_description']) ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-semibold"><?= format_currency((float) $product['price']) ?></span>
                                    <a class="btn btn-sm btn-primary" href="/product.php?slug=<?= urlencode($product['slug']) ?>">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php if (!$products): ?>
                        <div class="col">
                            <div class="alert alert-info">No products matched your filters. Try adjusting your search.</div>
                        </div>
                    <?php endif; ?>
                </div>
                <nav class="mt-4" aria-label="Product pagination">
                    <ul class="pagination">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= $i === $page ? 'active' : '' ?>"><a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"><?= $i ?></a></li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
$title = 'Products — SOSHEMAIN';
$metaDescription = 'Browse the SOSHEMAIN digital product catalog featuring automation playbooks, UX audits, and AI accelerators.';
require BASE_PATH . '/views/layouts/main.php';
