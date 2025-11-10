<section class="py-5 bg-body-tertiary">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="display-5 fw-semibold">Services</h1>
            <p class="lead text-muted">From strategy to execution, SOSHEMAIN delivers end-to-end capabilities.</p>
        </div>
        <div class="row g-4">
            <?php foreach ($services as $service): ?>
                <div class="col-md-6 col-xl-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="icon-circle bg-primary-subtle text-primary mb-3"><i class="bi <?php echo e($service['icon']); ?>"></i></div>
                            <h2 class="h5 fw-semibold"><?php echo e($service['name']); ?></h2>
                            <p class="text-muted"><?php echo e($service['description']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
