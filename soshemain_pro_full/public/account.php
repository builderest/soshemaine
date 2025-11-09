<?php
require_once __DIR__ . '/../core/helpers.php';
require_once BASE_PATH . '/core/db.php';
require_once BASE_PATH . '/core/auth.php';

$user = current_user();
if (!$user) {
    // Demo preview for static site
    $user = run_query_one('SELECT * FROM customers LIMIT 1');
}

$orders = run_query('SELECT order_number, total, status, created_at FROM orders WHERE customer_id = ? ORDER BY created_at DESC', [$user['id'] ?? 0]);
$addresses = run_query('SELECT * FROM addresses WHERE customer_id = ? ORDER BY type', [$user['id'] ?? 0]);

ob_start();
?>
<section class="py-5 bg-body-tertiary">
    <div class="container">
        <h1 class="display-5 fw-bold mb-4">Account overview</h1>
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="border rounded-4 p-4 bg-body shadow-sm">
                    <h2 class="h5 fw-bold">Profile</h2>
                    <p class="mb-1"><strong>Name:</strong> <?= e($user['name'] ?? 'Guest') ?></p>
                    <p class="mb-1"><strong>Email:</strong> <?= e($user['email'] ?? 'guest@example.com') ?></p>
                    <p class="mb-1"><strong>Phone:</strong> <?= e($user['phone'] ?? '—') ?></p>
                    <a class="btn btn-outline-secondary btn-sm mt-3" href="/admin/index.php">Admin login</a>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="border rounded-4 p-4 bg-body shadow-sm mb-4">
                    <h2 class="h5 fw-bold mb-3">Recent orders</h2>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td><a href="/order-success.php?order=<?= urlencode($order['order_number']) ?>">#<?= e($order['order_number']) ?></a></td>
                                    <td><span class="badge bg-primary-subtle text-primary text-capitalize"><?= e($order['status']) ?></span></td>
                                    <td><?= format_currency((float) $order['total']) ?></td>
                                    <td><?= date('M j, Y', strtotime($order['created_at'])) ?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if (!$orders): ?>
                                <tr><td colspan="4" class="text-secondary">No orders yet.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="border rounded-4 p-4 bg-body shadow-sm">
                    <h2 class="h5 fw-bold mb-3">Saved addresses</h2>
                    <div class="row g-3">
                        <?php foreach ($addresses as $address): ?>
                        <div class="col-md-6">
                            <div class="border rounded-3 p-3">
                                <span class="badge bg-secondary text-uppercase mb-2"><?= e($address['type']) ?></span>
                                <p class="mb-0"><?= e($address['line1']) ?><br><?= e($address['city']) ?>, <?= e($address['region']) ?> <?= e($address['postal_code']) ?><br><?= e($address['country']) ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php if (!$addresses): ?>
                        <div class="col"><p class="text-secondary mb-0">Add your billing and shipping addresses during checkout.</p></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
$title = 'My account — SOSHEMAIN';
$metaDescription = 'View recent orders, saved addresses, and manage your SOSHEMAIN profile.';
require BASE_PATH . '/views/layouts/main.php';
