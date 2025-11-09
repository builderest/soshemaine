<?php
$title = 'Tax rates';
require_once __DIR__ . '/includes/header.php';
require_once BASE_PATH . '/core/db.php';
$taxRates = run_query('SELECT name, country, region, rate_percent, is_default FROM tax_rates ORDER BY is_default DESC, name');
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h4 fw-bold mb-0">Tax rates</h1>
    <a class="btn btn-primary" href="#">Add rate</a>
</div>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Region</th>
                        <th>Rate</th>
                        <th>Default</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($taxRates as $rate): ?>
                    <tr>
                        <td><?= e($rate['name']) ?></td>
                        <td><?= e($rate['country']) ?> <?= e($rate['region']) ?></td>
                        <td><?= e($rate['rate_percent']) ?>%</td>
                        <td><?= $rate['is_default'] ? '<i class="bi bi-check-circle text-success"></i>' : '' ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
