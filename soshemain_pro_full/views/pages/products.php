<section class="py-5 bg-body-tertiary">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h1 class="display-5 fw-semibold">Products</h1>
                <p class="text-muted mb-0">Explore our curated solutions designed to unlock your next stage of growth.</p>
            </div>
            <a href="cart.php" class="btn btn-primary"><i class="bi bi-bag me-2"></i>View cart</a>
        </div>
        <div class="row g-4">
            <?php foreach ($items as $product): ?>
                <div class="col-md-6 col-xl-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="ratio ratio-4x3 bg-light rounded-top">
                            <img src="images/product-placeholder.svg" class="img-fluid object-fit-cover" alt="<?php echo e($product['name']); ?>">
                        </div>
                        <div class="card-body">
                            <h2 class="h5"><a href="product.php?slug=<?php echo e($product['slug']); ?>" class="stretched-link text-decoration-none"><?php echo e($product['name']); ?></a></h2>
                            <p class="text-muted small"><?php echo e(substr(strip_tags($product['description']), 0, 100)); ?>...</p>
                            <div class="fw-semibold">$<?php echo number_format((float) $product['price'], 2); ?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($items)): ?>
                <div class="col-12 text-center text-muted">No products available right now.</div>
            <?php endif; ?>
        </div>
        <?php if (!empty($pagination) && $pagination['total_pages'] > 1): ?>
            <nav class="mt-4" aria-label="Product pagination">
                <ul class="pagination justify-content-center">
                    <?php if ($pagination['has_prev']): ?>
                        <li class="page-item"><a class="page-link" href="?page=<?php echo e($pagination['prev']); ?>">Previous</a></li>
                    <?php endif; ?>
                    <?php for ($p = 1; $p <= $pagination['total_pages']; $p++): ?>
                        <li class="page-item <?php echo $p === $pagination['current'] ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo e($p); ?>"><?php echo e($p); ?></a>
                        </li>
                    <?php endfor; ?>
                    <?php if ($pagination['has_next']): ?>
                        <li class="page-item"><a class="page-link" href="?page=<?php echo e($pagination['next']); ?>">Next</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</section>
