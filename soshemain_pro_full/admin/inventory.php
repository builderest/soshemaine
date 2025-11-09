<?php
$title = 'Inventory';
require_once __DIR__ . '/includes/header.php';
require_once BASE_PATH . '/core/db.php';
$inventory = run_query('SELECT p.name, v.sku, v.stock FROM variants v JOIN products p ON p.id = v.product_id ORDER BY v.stock ASC');
?>
<h1 class="h4 fw-bold mb-4">Inventory</h1>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>SKU</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($inventory as $item): ?>
                    <tr class="<?= $item['stock'] <= 5 ? 'table-warning' : '' ?>">
                        <td><?= e($item['name']) ?></td>
                        <td><?= e($item['sku']) ?></td>
                        <td><?= e($item['stock']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
