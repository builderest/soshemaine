<?php
$footerMenuItems = $footerMenu['items'] ?? [];
$socialLinks = json_decode($settings['social_links'] ?? '[]', true) ?? [];
?>
<footer class="site-footer mt-5 pt-5 bg-body-tertiary border-top">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <h2 class="h5 fw-semibold mb-3"><?php echo e($settings['company_name'] ?? APP_NAME); ?></h2>
                <p><?php echo e($settings['meta_description'] ?? 'SOSHEMAIN helps you grow in the digital era.'); ?></p>
                <ul class="list-unstyled text-muted small">
                    <li><i class="bi bi-geo-alt me-2"></i><?php echo e($settings['company_address'] ?? 'Portland, Maine'); ?></li>
                    <li><i class="bi bi-telephone me-2"></i><?php echo e($settings['company_phone'] ?? '+1 555 123 4567'); ?></li>
                    <li><i class="bi bi-envelope me-2"></i><?php echo e($settings['company_email'] ?? 'hello@example.com'); ?></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h2 class="h6 text-uppercase">Quick links</h2>
                <ul class="list-unstyled">
                    <?php foreach ($footerMenuItems as $item): ?>
                        <li><a class="text-decoration-none" href="<?php echo e($item['url']); ?>"><?php echo e($item['label']); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="col-md-4">
                <h2 class="h6 text-uppercase">Stay in touch</h2>
                <form class="d-flex flex-column gap-2" action="contact-submit.php" method="post">
                    <?php echo Csrf::field(); ?>
                    <input type="email" class="form-control" name="email" placeholder="Your email" required>
                    <button class="btn btn-primary" type="submit">Subscribe</button>
                </form>
                <div class="d-flex gap-3 mt-3">
                    <?php foreach ($socialLinks as $link): ?>
                        <a href="<?php echo e($link['url']); ?>" class="text-decoration-none" target="_blank" rel="noopener" aria-label="<?php echo e($link['platform']); ?>">
                            <i class="bi bi-<?php echo strtolower($link['platform']); ?> fs-4"></i>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="border-top mt-4 pt-3 d-flex flex-wrap justify-content-between text-muted small">
            <span>&copy; <?php echo date('Y'); ?> <?php echo e($settings['company_name'] ?? APP_NAME); ?>. All rights reserved.</span>
            <div class="d-flex gap-3">
                <a href="privacy.php" class="text-decoration-none">Privacy</a>
                <a href="terms.php" class="text-decoration-none">Terms</a>
                <a href="returns.php" class="text-decoration-none">Returns</a>
            </div>
        </div>
    </div>
</footer>
