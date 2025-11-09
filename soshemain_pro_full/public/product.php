<?php
require_once __DIR__ . '/../core/helpers.php';
require_once BASE_PATH . '/core/db.php';
require_once BASE_PATH . '/core/ecommerce.php';
require_once BASE_PATH . '/core/security.php';

$slug = $_GET['slug'] ?? '';
$product = run_query_one('SELECT * FROM products WHERE slug = ? AND status = "published" LIMIT 1', [$slug]);
if (!$product) {
    http_response_code(404);
    echo 'Product not found';
    exit;
}

$gallery = run_query('SELECT path, alt FROM product_images WHERE product_id = ? ORDER BY sort_order', [$product['id']]);
$variants = run_query('SELECT id, sku, attributes, price_override, stock FROM variants WHERE product_id = ? ORDER BY id', [$product['id']]);
$related = run_query('SELECT name, slug, price FROM products WHERE status = "published" AND id != ? ORDER BY featured DESC LIMIT 3', [$product['id']]);

if (is_post()) {
    if (!verify_csrf()) {
        flash('error', 'Security token mismatch. Please try again.');
        redirect($_SERVER['REQUEST_URI']);
    }
    $variantId = isset($_POST['variant_id']) && $_POST['variant_id'] !== '' ? (int) $_POST['variant_id'] : null;
    add_to_cart((int) $product['id'], $variantId, max(1, (int) $_POST['quantity']));
    flash('success', 'Product added to cart.');
    redirect('/cart.php');
}

ob_start();
?>
<section class="py-5 bg-body-tertiary">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="/products.php">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= e($product['name']) ?></li>
            </ol>
        </nav>
        <div class="row g-5">
            <div class="col-lg-6">
                <div class="ratio ratio-4x3 rounded-4 overflow-hidden mb-3">
                    <img class="w-100 h-100 object-fit-cover" src="/images/products/<?= e($product['slug']) ?>.jpg" alt="<?= e($product['name']) ?>">
                </div>
                <div class="d-flex gap-3">
                    <?php foreach ($gallery as $image): ?>
                        <img class="rounded" src="/images/products/<?= e($image['path']) ?>" alt="<?= e($image['alt']) ?>" width="96" height="96">
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-lg-6">
                <h1 class="fw-bold mb-3"><?= e($product['name']) ?></h1>
                <p class="text-secondary lead"><?= e($product['short_description']) ?></p>
                <p class="fs-3 fw-bold text-primary"><?= format_currency((float) $product['price']) ?></p>
                <div class="mb-4">
                    <?= $product['description'] ?>
                </div>
                <form method="post" class="border rounded-4 p-4 bg-body">
                    <?= csrf_field() ?>
                    <?php if ($variants): ?>
                    <div class="mb-3">
                        <label class="form-label" for="variant">Select option</label>
                        <select class="form-select" id="variant" name="variant_id">
                            <option value="">Choose an option</option>
                            <?php foreach ($variants as $variant): ?>
                            <option value="<?= $variant['id'] ?>" data-price="<?= e($variant['price_override']) ?>" data-stock="<?= e($variant['stock']) ?>">
                                <?= e($variant['attributes']) ?> — <?= format_currency((float) ($variant['price_override'] ?: $product['price'])) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>
                    <div class="mb-3">
                        <label class="form-label" for="quantity">Quantity</label>
                        <input class="form-control" type="number" id="quantity" name="quantity" value="1" min="1">
                    </div>
                    <button class="btn btn-primary btn-lg w-100" type="submit"><i class="bi bi-cart-plus"></i> Add to cart</button>
                </form>
                <div class="mt-4">
                    <p class="mb-1"><strong>SKU:</strong> <?= e($product['sku']) ?></p>
                    <p class="mb-1"><strong>Stock:</strong> <?= e($product['stock_status'] ?? 'In stock') ?></p>
                    <p class="mb-1"><strong>Tags:</strong> <?= e($product['tags'] ?? 'Digital, Innovation, Growth') ?></p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="py-5">
    <div class="container">
        <h2 class="fw-bold mb-4">You may also like</h2>
        <div class="row g-4">
            <?php foreach ($related as $rel): ?>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <img class="card-img-top" src="/images/products/<?= e($rel['slug']) ?>.jpg" alt="<?= e($rel['name']) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= e($rel['name']) ?></h5>
                        <p class="fw-semibold text-primary"><?= format_currency((float) $rel['price']) ?></p>
                        <a class="stretched-link" href="/product.php?slug=<?= urlencode($rel['slug']) ?>">View product</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
$title = e($product['name']) . ' — SOSHEMAIN';
$metaDescription = strip_tags($product['meta_description'] ?? $product['short_description']);
require BASE_PATH . '/views/layouts/main.php';
