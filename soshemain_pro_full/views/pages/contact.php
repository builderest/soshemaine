<section class="py-5 bg-body-tertiary">
    <div class="container">
        <div class="row g-4 align-items-start">
            <div class="col-lg-5">
                <h1 class="display-5 fw-semibold">Let’s build something great</h1>
                <p class="lead text-muted">Tell us about your goals and we’ll assemble a tailored roadmap to reach them.</p>
                <ul class="list-unstyled text-muted">
                    <li class="mb-2"><i class="bi bi-geo-alt me-2"></i><?php echo e($settings['company_address'] ?? 'Portland, Maine'); ?></li>
                    <li class="mb-2"><i class="bi bi-envelope me-2"></i><?php echo e($settings['company_email'] ?? 'hello@example.com'); ?></li>
                    <li><i class="bi bi-telephone me-2"></i><?php echo e($settings['company_phone'] ?? '+1 555 123 4567'); ?></li>
                </ul>
            </div>
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="h4 mb-4">Share your project</h2>
                        <?php if ($message = flash('contact_success')): ?>
                            <div class="alert alert-success"><?php echo e($message); ?></div>
                        <?php endif; ?>
                        <?php if ($error = flash('contact_error')): ?>
                            <div class="alert alert-danger"><?php echo e($error); ?></div>
                        <?php endif; ?>
                        <form method="post" action="contact-submit.php" class="row g-3">
                            <?php echo Csrf::field(); ?>
                            <div class="col-md-6">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Message</label>
                                <textarea class="form-control" name="message" rows="4" required></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
