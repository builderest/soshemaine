<?php
require_once __DIR__ . '/../core/helpers.php';
require_once BASE_PATH . '/core/ecommerce.php';
require_once BASE_PATH . '/core/security.php';

if (is_post()) {
    if (!verify_csrf()) {
        flash('error', 'Security token mismatch.');
        redirect('/cart.php');
    }
    if (isset($_POST['update']) && !empty($_POST['quantity'])) {
        foreach ((array) $_POST['quantity'] as $key => $qty) {
            update_cart_item($key, max(0, (int) $qty));
        }
        flash('success', 'Cart updated.');
    } elseif (isset($_POST['remove'])) {
        foreach (array_keys($_POST['remove']) as $key) {
            update_cart_item($key, 0);
        }
        flash('success', 'Item removed.');
    } elseif (isset($_POST['clear'])) {
        clear_cart();
        flash('success', 'Cart cleared.');
    }
    redirect('/cart.php');
}

$cart = cart_items();
$summary = calculate_cart_summary($cart);
$success = flash('success');
$error = flash('error');

ob_start();
?>
<section class="py-5 bg-body-tertiary">
    <div class="container">
        <h1 class="display-5 fw-bold mb-4">Your cart</h1>
        <?php if ($success): ?><div class="alert alert-success"><?= e($success) ?></div><?php endif; ?>
        <?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
        <form method="post">
            <?= csrf_field() ?>
            <div class="table-responsive shadow-sm rounded-4 overflow-hidden">
                <table class="table mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th width="140">Price</th>
                            <th width="120">Quantity</th>
                            <th width="140">Total</th>
                            <th width="80"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($summary['items'] as $item): ?>
                        <tr>
                            <td>
                                <strong><?= e($item['product']['name']) ?></strong><br>
                                <?php if ($item['variant']): ?>
                                    <span class="text-secondary small"><?= e($item['variant']['attributes']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?= format_currency($item['price']) ?></td>
                            <td>
                                <input class="form-control form-control-sm" type="number" min="0" name="quantity[<?= e($item['key']) ?>]" value="<?= e($item['quantity']) ?>">
                            </td>
                            <td><?= format_currency($item['total']) ?></td>
                            <td>
                                <button class="btn btn-link text-danger p-0" name="remove[<?= e($item['key']) ?>]" value="1"><i class="bi bi-x-circle"></i></button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (!$summary['items']): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">Your cart is empty. <a href="/products.php">Browse products</a>.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="d-flex flex-wrap justify-content-between align-items-center mt-4">
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary" type="submit" name="update">Update cart</button>
                    <button class="btn btn-outline-danger" type="submit" name="clear">Clear cart</button>
                </div>
                <a class="btn btn-primary" href="/checkout.php">Proceed to checkout</a>
            </div>
        </form>
        <div class="row mt-5">
            <div class="col-md-6 ms-auto">
                <div class="border rounded-4 p-4 bg-body shadow-sm">
                    <h2 class="h5 fw-bold mb-3">Order summary</h2>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <strong><?= format_currency($summary['subtotal']) ?></strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Estimated tax</span>
                        <strong><?= format_currency($summary['tax']) ?></strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping</span>
                        <strong><?= format_currency($summary['shipping']) ?></strong>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="fw-semibold">Total</span>
                        <strong class="fs-4 text-primary"><?= format_currency($summary['total']) ?></strong>
                    </div>
                    <a class="btn btn-primary w-100" href="/checkout.php">Checkout</a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
$title = 'Cart — SOSHEMAIN';
$metaDescription = 'Review the items currently in your SOSHEMAIN cart before completing checkout.';
require BASE_PATH . '/views/layouts/main.php';
