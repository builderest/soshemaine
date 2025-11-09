<?php
$title = 'Shipping methods';
require_once __DIR__ . '/includes/header.php';
require_once BASE_PATH . '/core/db.php';
$methods = run_query('SELECT name, type, cost, min_total, status FROM shipping_methods ORDER BY sort_order');
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h4 fw-bold mb-0">Shipping methods</h1>
    <a class="btn btn-primary" href="#">Add method</a>
</div>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Cost</th>
                        <th>Minimum order</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($methods as $method): ?>
                    <tr>
                        <td><?= e($method['name']) ?></td>
                        <td><?= e(ucfirst($method['type'])) ?></td>
                        <td><?= $method['type'] === 'free' ? 'Free' : format_currency((float) $method['cost']) ?></td>
                        <td><?= $method['min_total'] ? format_currency((float) $method['min_total']) : '—' ?></td>
                        <td><span class="badge bg-<?= $method['status'] === 'active' ? 'success' : 'secondary' ?> text-uppercase"><?= e($method['status']) ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
