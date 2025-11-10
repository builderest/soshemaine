<section class="py-5 bg-body-tertiary">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6">
                <div class="ratio ratio-4x3 rounded-4 overflow-hidden shadow-sm bg-light">
                    <img src="images/product-placeholder.svg" class="img-fluid object-fit-cover" alt="<?php echo e($product['name']); ?>">
                </div>
                <div class="d-flex gap-3 mt-3">
                    <?php foreach (($product['gallery'] ?? []) as $image): ?>
                        <img src="<?php echo e($image); ?>" class="img-thumbnail" alt="Gallery image" loading="lazy">
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-lg-6">
                <h1 class="display-5 fw-semibold"><?php echo e($product['name']); ?></h1>
                <div class="fs-4 fw-semibold text-primary mb-3">$<?php echo number_format((float) $product['price'], 2); ?></div>
                <div class="text-muted mb-4">SKU: <?php echo e($product['sku']); ?> • Stock: <?php echo e($product['stock']); ?></div>
                <div class="lead mb-4">
                    <?php echo $product['description']; ?>
                </div>
                <form class="d-flex gap-3 align-items-center" action="cart.php" method="post">
                    <?php echo Csrf::field(); ?>
                    <input type="hidden" name="product_id" value="<?php echo e($product['id']); ?>">
                    <label class="form-label mb-0">Qty</label>
                    <input type="number" name="quantity" class="form-control w-auto" value="1" min="1">
                    <button type="submit" class="btn btn-primary">Add to cart</button>
                </form>
                <?php if (!empty($product['variants'])): ?>
                    <div class="mt-4">
                        <h2 class="h6 text-uppercase">Variants</h2>
                        <ul class="list-group">
                            <?php foreach ($product['variants'] as $variant): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><?php echo e($variant['name']); ?></span>
                                    <span class="fw-semibold">$<?php echo number_format((float) $variant['price'], 2); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <div class="mt-4">
                    <h2 class="h6 text-uppercase">Secure checkout</h2>
                    <p class="text-muted">Transactions are powered by Stripe Checkout and PayPal for a safe, sandbox-ready experience.</p>
                    <div class="d-flex gap-3">
                        <img src="images/stripe-logo.svg" alt="Stripe" height="24" loading="lazy">
                        <img src="images/paypal-logo.svg" alt="PayPal" height="24" loading="lazy">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
