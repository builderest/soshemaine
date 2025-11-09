<?php
$title = 'Orders';
require_once __DIR__ . '/includes/header.php';
require_once BASE_PATH . '/core/db.php';
$orders = run_query('SELECT order_number, customer_name, status, total, payment_status, created_at FROM orders ORDER BY created_at DESC');
?>
<h1 class="h4 fw-bold mb-4">Orders</h1>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Customer</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Total</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>#<?= e($order['order_number']) ?></td>
                        <td><?= e($order['customer_name']) ?></td>
                        <td><span class="badge bg-primary-subtle text-primary text-capitalize"><?= e($order['status']) ?></span></td>
                        <td><?= e(ucfirst($order['payment_status'])) ?></td>
                        <td><?= format_currency((float) $order['total']) ?></td>
                        <td><?= date('M j, Y g:i a', strtotime($order['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
