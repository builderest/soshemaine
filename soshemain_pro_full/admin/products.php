<?php
$title = 'Products';
require_once __DIR__ . '/includes/header.php';
require_once BASE_PATH . '/core/db.php';
$products = run_query('SELECT id, name, sku, price, status, stock_status FROM products ORDER BY created_at DESC');
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h4 fw-bold mb-0">Products</h1>
    <a class="btn btn-primary" href="#">Add product</a>
</div>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>SKU</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Inventory</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= e($product['name']) ?></td>
                        <td><?= e($product['sku']) ?></td>
                        <td><?= format_currency((float) $product['price']) ?></td>
                        <td><span class="badge bg-<?= $product['status'] === 'published' ? 'success' : 'secondary' ?> text-uppercase"><?= e($product['status']) ?></span></td>
                        <td><?= e($product['stock_status']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
