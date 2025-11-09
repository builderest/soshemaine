<?php
require_once __DIR__ . '/../core/helpers.php';

$orderNumber = $_GET['order'] ?? 'SO-DEMO1234';

ob_start();
?>
<section class="py-5 bg-body-tertiary">
    <div class="container text-center">
        <div class="mb-4">
            <i class="bi bi-check-circle-fill text-success display-3"></i>
        </div>
        <h1 class="display-5 fw-bold">Thank you! Your order is confirmed.</h1>
        <p class="lead text-secondary">Order <strong>#<?= e($orderNumber) ?></strong> is being processed. You will receive an email with tracking details shortly.</p>
        <div class="d-flex justify-content-center gap-3 mt-4">
            <a class="btn btn-primary" href="/account.php">View account</a>
            <a class="btn btn-outline-secondary" href="/products.php">Continue shopping</a>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
$title = 'Order confirmed — SOSHEMAIN';
$metaDescription = 'Your SOSHEMAIN order is confirmed. Access order details, invoices, and updates from your account dashboard.';
require BASE_PATH . '/views/layouts/main.php';
