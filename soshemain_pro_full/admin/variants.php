<?php
$title = 'Variants';
require_once __DIR__ . '/includes/header.php';
require_once BASE_PATH . '/core/db.php';
$variants = run_query('SELECT v.id, p.name, v.sku, v.price_override, v.stock, v.attributes FROM variants v JOIN products p ON p.id = v.product_id ORDER BY v.id DESC');
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h4 fw-bold mb-0">Product variants</h1>
    <a class="btn btn-primary" href="#">Add variant</a>
</div>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>SKU</th>
                        <th>Attributes</th>
                        <th>Price override</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($variants as $variant): ?>
                    <tr>
                        <td><?= e($variant['name']) ?></td>
                        <td><?= e($variant['sku']) ?></td>
                        <td><?= e($variant['attributes']) ?></td>
                        <td><?= $variant['price_override'] ? format_currency((float) $variant['price_override']) : '—' ?></td>
                        <td><?= e($variant['stock']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
