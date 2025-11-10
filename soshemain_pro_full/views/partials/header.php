<?php
$primaryMenuItems = $primaryMenu['items'] ?? [];
?>
<header class="site-header border-bottom">
    <div class="bg-light text-dark small py-2">
        <div class="container d-flex flex-wrap justify-content-between align-items-center">
            <span><i class="bi bi-geo-alt me-2"></i><?php echo e($settings['company_address'] ?? 'Portland, Maine'); ?></span>
            <div class="d-flex gap-3">
                <a href="tel:<?php echo e($settings['company_phone'] ?? '+1 555 123 4567'); ?>" class="text-decoration-none"><i class="bi bi-telephone me-1"></i><?php echo e($settings['company_phone'] ?? '+1 555 123 4567'); ?></a>
                <a href="mailto:<?php echo e($settings['company_email'] ?? 'hello@example.com'); ?>" class="text-decoration-none"><i class="bi bi-envelope me-1"></i><?php echo e($settings['company_email'] ?? 'hello@example.com'); ?></a>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg bg-body">
        <div class="container">
            <a class="navbar-brand fw-semibold" href="index.php"><?php echo e($settings['company_name'] ?? APP_NAME); ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <?php foreach ($primaryMenuItems as $item): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e($item['url']); ?>"><?php echo e($item['label']); ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="d-flex align-items-center gap-2 ms-lg-3">
                    <a href="cart.php" class="btn btn-outline-primary btn-sm"><i class="bi bi-bag"></i> <span class="d-none d-md-inline">Cart</span></a>
                    <button class="btn btn-sm btn-secondary" id="themeToggle" aria-label="Toggle theme"><i class="bi bi-moon-stars"></i></button>
                </div>
            </div>
        </div>
    </nav>
</header>
