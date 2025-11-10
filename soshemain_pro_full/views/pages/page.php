<?php $sections = $page['sections'] ?? []; ?>
<section class="py-5 bg-body-tertiary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h1 class="display-5 fw-semibold mb-3"><?php echo e($page['title'] ?? 'Page'); ?></h1>
                <p class="lead text-muted"><?php echo e($page['excerpt'] ?? ''); ?></p>
            </div>
        </div>
    </div>
</section>
<?php foreach ($sections as $section): ?>
    <section class="py-5">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6">
                    <h2 class="h3 fw-semibold"><?php echo e($section['title'] ?? ''); ?></h2>
                    <p class="text-muted"><?php echo e($section['body'] ?? ''); ?></p>
                    <?php if (!empty($section['cta'])): ?>
                        <a class="btn btn-primary" href="<?php echo e($section['cta']['url']); ?>"><?php echo e($section['cta']['label']); ?></a>
                    <?php endif; ?>
                </div>
                <div class="col-lg-6">
                    <?php if (!empty($section['image'])): ?>
                        <img src="<?php echo e($section['image']); ?>" class="img-fluid rounded-4 shadow-sm" alt="<?php echo e($section['title']); ?>">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php endforeach; ?>
