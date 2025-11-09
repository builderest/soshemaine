<?php
require_once __DIR__ . '/../core/helpers.php';
require_once BASE_PATH . '/core/ecommerce.php';
require_once BASE_PATH . '/core/security.php';
require_once BASE_PATH . '/core/mail.php';

$cart = cart_items();
$summary = calculate_cart_summary($cart);
if (!$summary['items']) {
    flash('error', 'Your cart is empty. Add items before checking out.');
    redirect('/cart.php');
}

$success = flash('success');
$error = flash('error');

if (is_post()) {
    if (!verify_csrf()) {
        flash('error', 'Security token mismatch.');
        redirect('/checkout.php');
    }

    $billingName = trim($_POST['billing_name'] ?? '');
    $billingEmail = filter_var($_POST['billing_email'] ?? '', FILTER_VALIDATE_EMAIL);
    $billingAddress = trim($_POST['billing_address'] ?? '');
    $billingCity = trim($_POST['billing_city'] ?? '');
    $billingCountry = trim($_POST['billing_country'] ?? '');

    if (!$billingName || !$billingEmail || !$billingAddress || !$billingCity || !$billingCountry) {
        flash('error', 'Please complete required billing details.');
        redirect('/checkout.php');
    }

    $orderNumber = 'SO-' . strtoupper(bin2hex(random_bytes(4)));
    flash('success', 'Order initialized. Complete payment using Stripe or PayPal below.');
    redirect('/order-success.php?order=' . urlencode($orderNumber));
}

ob_start();
?>
<section class="py-5 bg-body-tertiary">
    <div class="container">
        <h1 class="display-5 fw-bold mb-4">Checkout</h1>
        <?php if ($success): ?><div class="alert alert-success"><?= e($success) ?></div><?php endif; ?>
        <?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
        <div class="row g-5">
            <div class="col-lg-7">
                <form method="post" class="border rounded-4 p-4 bg-body shadow-sm">
                    <?= csrf_field() ?>
                    <h2 class="h5 fw-bold mb-3">Billing details</h2>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="billing_name">Full name</label>
                            <input class="form-control" id="billing_name" name="billing_name" value="<?= e(old('billing_name')) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="billing_email">Email</label>
                            <input class="form-control" type="email" id="billing_email" name="billing_email" value="<?= e(old('billing_email')) ?>" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="billing_address">Address</label>
                            <input class="form-control" id="billing_address" name="billing_address" value="<?= e(old('billing_address')) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="billing_city">City</label>
                            <input class="form-control" id="billing_city" name="billing_city" value="<?= e(old('billing_city')) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="billing_country">Country</label>
                            <input class="form-control" id="billing_country" name="billing_country" value="<?= e(old('billing_country')) ?>" required>
                        </div>
                    </div>
                    <hr class="my-4">
                    <h2 class="h5 fw-bold mb-3">Payment</h2>
                    <p class="text-secondary">Choose your payment provider to complete the transaction securely.</p>
                    <div class="mb-4">
                        <button class="btn btn-outline-primary w-100 mb-3" type="button" id="stripeCheckout">Pay with Stripe</button>
                        <div id="paypal-button-container"></div>
                    </div>
                    <p class="small text-secondary">By placing your order you agree to our <a href="/terms.php">terms of service</a> and <a href="/privacy.php">privacy policy</a>.</p>
                    <button class="btn btn-primary w-100" type="submit">Confirm order details</button>
                </form>
            </div>
            <div class="col-lg-5">
                <div class="border rounded-4 p-4 bg-body shadow-sm mb-4">
                    <h2 class="h5 fw-bold mb-3">Order summary</h2>
                    <?php foreach ($summary['items'] as $item): ?>
                        <div class="d-flex justify-content-between mb-2">
                            <span><?= e($item['product']['name']) ?> × <?= e($item['quantity']) ?></span>
                            <strong><?= format_currency($item['total']) ?></strong>
                        </div>
                    <?php endforeach; ?>
                    <hr>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <strong><?= format_currency($summary['subtotal']) ?></strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax</span>
                        <strong><?= format_currency($summary['tax']) ?></strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping</span>
                        <strong><?= format_currency($summary['shipping']) ?></strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-semibold">Total</span>
                        <strong class="fs-4 text-primary"><?= format_currency($summary['total']) ?></strong>
                    </div>
                </div>
                <div class="border rounded-4 p-4 bg-body shadow-sm">
                    <h2 class="h5 fw-bold mb-3">Secure checkout</h2>
                    <p class="text-secondary mb-0">Payments are processed through Stripe and PayPal. We never store card details on SOSHEMAIN servers.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<script>window.STRIPE_PUBLISHABLE_KEY = '<?= e(STRIPE_PUBLISHABLE_KEY) ?>';</script>
<script src="https://js.stripe.com/v3/"></script>
<script src="https://www.paypal.com/sdk/js?client-id=<?= urlencode(PAYPAL_CLIENT_ID) ?>&currency=USD"></script>
<script>
    document.getElementById('stripeCheckout').addEventListener('click', function () {
        fetch('/js/stripe-checkout.js').then(() => {
            console.log('Trigger Stripe checkout');
        });
    });
    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{ amount: { value: '<?= number_format($summary['total'], 2, '.', '') ?>' } }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                window.location.href = '/order-success.php?order=' + encodeURIComponent(details.id);
            });
        },
        onError: function(err) {
            console.error(err);
            window.location.href = '/order-failed.php';
        }
    }).render('#paypal-button-container');
</script>
<?php
$content = ob_get_clean();
$title = 'Checkout — SOSHEMAIN';
$metaDescription = 'Secure checkout for SOSHEMAIN digital products and services with Stripe and PayPal.';
require BASE_PATH . '/views/layouts/main.php';
