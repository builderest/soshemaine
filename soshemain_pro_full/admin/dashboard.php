<?php
$title = 'Dashboard';
require_once __DIR__ . '/includes/header.php';
require_once BASE_PATH . '/core/db.php';

$metrics = run_query_one('SELECT (
    SELECT SUM(total) FROM orders WHERE status IN ("paid","completed")
) AS revenue, (
    SELECT COUNT(*) FROM orders
) AS orders_count, (
    SELECT COUNT(*) FROM customers
) AS customers_count, (
    SELECT COUNT(*) FROM carts WHERE updated_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
) AS active_carts');
$recentOrders = run_query('SELECT order_number, customer_name, total, status, created_at FROM orders ORDER BY created_at DESC LIMIT 5');
$topProducts = run_query('SELECT name, price, total_sales FROM products ORDER BY total_sales DESC LIMIT 5');
?>
<div class="row g-4">
    <div class="col-md-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <p class="text-secondary text-uppercase small">Revenue</p>
                <h3 class="fw-bold"><?= format_currency((float) ($metrics['revenue'] ?? 0)) ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <p class="text-secondary text-uppercase small">Orders</p>
                <h3 class="fw-bold"><?= e($metrics['orders_count'] ?? 0) ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <p class="text-secondary text-uppercase small">Customers</p>
                <h3 class="fw-bold"><?= e($metrics['customers_count'] ?? 0) ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <p class="text-secondary text-uppercase small">Active carts</p>
                <h3 class="fw-bold"><?= e($metrics['active_carts'] ?? 0) ?></h3>
            </div>
        </div>
    </div>
</div>
<div class="row g-4 mt-1">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <h2 class="h5 fw-bold">Sales (Last 30 days)</h2>
                <canvas id="salesChart" height="140"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <h2 class="h5 fw-bold">Top products</h2>
                <ul class="list-unstyled mb-0">
                    <?php foreach ($topProducts as $product): ?>
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span><?= e($product['name']) ?></span>
                        <span><?= format_currency((float) $product['price']) ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="card shadow-sm border-0 mt-4">
    <div class="card-body">
        <h2 class="h5 fw-bold">Recent orders</h2>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Customer</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentOrders as $order): ?>
                    <tr>
                        <td>#<?= e($order['order_number']) ?></td>
                        <td><?= e($order['customer_name']) ?></td>
                        <td><span class="badge bg-primary-subtle text-primary text-capitalize"><?= e($order['status']) ?></span></td>
                        <td><?= format_currency((float) $order['total']) ?></td>
                        <td><?= date('M j, Y', strtotime($order['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    const salesChart = document.getElementById('salesChart');
    if (salesChart) {
        new Chart(salesChart, {
            type: 'line',
            data: {
                labels: <?= json_encode(array_map(fn($d) => $d['date'], run_query('SELECT DATE(created_at) as date FROM orders WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY) GROUP BY DATE(created_at)'))) ?>,
                datasets: [{
                    label: 'Revenue',
                    data: <?= json_encode(array_map(fn($d) => (float) $d['total'], run_query('SELECT DATE(created_at) as date, SUM(total) as total FROM orders WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY) GROUP BY DATE(created_at)'))) ?>,
                    borderColor: '#2563EB',
                    fill: false,
                    tension: 0.4
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: { y: { ticks: { callback: value => '$' + value } } }
            }
        });
    }
</script>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
