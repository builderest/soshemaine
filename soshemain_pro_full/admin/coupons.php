<?php
$title = 'Coupons';
require_once __DIR__ . '/includes/header.php';
require_once BASE_PATH . '/core/db.php';
$coupons = run_query('SELECT code, type, value, status, usage_limit, usage_count, start_at, end_at FROM coupons ORDER BY created_at DESC');
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h4 fw-bold mb-0">Coupons</h1>
    <a class="btn btn-primary" href="#">Create coupon</a>
</div>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Type</th>
                        <th>Value</th>
                        <th>Usage</th>
                        <th>Status</th>
                        <th>Valid period</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($coupons as $coupon): ?>
                    <tr>
                        <td><?= e($coupon['code']) ?></td>
                        <td><?= e(ucfirst($coupon['type'])) ?></td>
                        <td><?= $coupon['type'] === 'percent' ? e($coupon['value']) . '%' : format_currency((float) $coupon['value']) ?></td>
                        <td><?= e($coupon['usage_count'] ?? 0) ?> / <?= e($coupon['usage_limit'] ?? '∞') ?></td>
                        <td><span class="badge bg-<?= $coupon['status'] === 'active' ? 'success' : 'secondary' ?> text-uppercase"><?= e($coupon['status']) ?></span></td>
                        <td><?= $coupon['start_at'] ? date('M j', strtotime($coupon['start_at'])) : '—' ?> – <?= $coupon['end_at'] ? date('M j', strtotime($coupon['end_at'])) : '—' ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
