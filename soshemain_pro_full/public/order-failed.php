<?php
require_once __DIR__ . '/../core/helpers.php';

ob_start();
?>
<section class="py-5 bg-body-tertiary">
    <div class="container text-center">
        <div class="mb-4">
            <i class="bi bi-x-circle-fill text-danger display-3"></i>
        </div>
        <h1 class="display-5 fw-bold">Payment unsuccessful</h1>
        <p class="lead text-secondary">We were unable to process your payment. Please try again or use a different method.</p>
        <div class="d-flex justify-content-center gap-3 mt-4">
            <a class="btn btn-primary" href="/checkout.php">Try again</a>
            <a class="btn btn-outline-secondary" href="/contact.php">Contact support</a>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
$title = 'Payment failed — SOSHEMAIN';
$metaDescription = 'Your SOSHEMAIN payment could not be processed. Retry checkout or contact our support team for assistance.';
require BASE_PATH . '/views/layouts/main.php';
