<?php
$hero = $page['hero'] ?? [];
$sections = $page['sections'] ?? [];
?>
<section class="hero position-relative overflow-hidden py-5 py-lg-7">
    <div class="container position-relative z-1">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-3"><?php echo e($hero['title'] ?? 'Build meaningful digital experiences'); ?></h1>
                <p class="lead text-muted mb-4"><?php echo e($hero['subtitle'] ?? 'SOSHEMAIN blends strategy, creativity, and technology to accelerate your growth.'); ?></p>
                <div class="d-flex gap-3">
                    <a href="<?php echo e($hero['cta']['url'] ?? 'contact.php'); ?>" class="btn btn-primary btn-lg"><?php echo e($hero['cta']['label'] ?? 'Start project'); ?></a>
                    <a href="services.php" class="btn btn-outline-primary btn-lg">View services</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ratio ratio-4x3 rounded-4 shadow-lg overflow-hidden bg-gradient">
                    <img src="images/hero-team.svg" alt="Team working" class="img-fluid object-fit-cover">
                </div>
            </div>
        </div>
    </div>
</section>
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-soft-primary text-primary rounded-pill">Our services</span>
            <h2 class="display-6 fw-semibold mt-3">How we help organizations</h2>
        </div>
        <div class="row g-4">
            <?php foreach ($services as $service): ?>
                <div class="col-md-6 col-xl-4">
                    <div class="card h-100 border-0 shadow-sm hover-lift">
                        <div class="card-body">
                            <div class="icon-circle bg-primary-subtle text-primary mb-3"><i class="bi <?php echo e($service['icon']); ?>"></i></div>
                            <h3 class="h5 fw-semibold"><?php echo e($service['name']); ?></h3>
                            <p class="text-muted"><?php echo e($service['description']); ?></p>
                            <a href="services.php" class="stretched-link">Learn more</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php if (!empty($portfolioProjects)): ?>
<section class="py-5 bg-body-tertiary">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <span class="badge bg-soft-primary text-primary rounded-pill">Portfolio</span>
                <h2 class="display-6 fw-semibold mt-3 mb-0">Recent work in focus</h2>
            </div>
            <a href="portfolio.php" class="btn btn-outline-primary">View all projects</a>
        </div>
        <div class="row g-4">
            <?php foreach ($portfolioProjects as $project): ?>
                <div class="col-md-6 col-xl-3">
                    <article class="card border-0 shadow-sm portfolio-card h-100">
                        <?php $thumb = $project['thumbnail'] ?: ($project['images'][0] ?? ''); ?>
                        <?php if ($thumb): ?>
                            <div class="ratio ratio-4x3">
                                <img src="<?php echo e(asset('uploads/' . $thumb)); ?>" alt="<?php echo e($project['title']); ?>" class="card-img-top object-fit-cover" loading="lazy" decoding="async">
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <span class="badge bg-dark text-uppercase mb-3">Featured</span>
                            <h3 class="h5 mb-2"><a href="portfolio-item.php?slug=<?php echo e($project['slug']); ?>" class="stretched-link text-decoration-none"><?php echo e($project['title']); ?></a></h3>
                            <p class="text-muted small mb-2"><?php echo e($project['category'] ?: 'Case study'); ?><?php if (!empty($project['client'])): ?> • <?php echo e($project['client']); ?><?php endif; ?></p>
                            <p class="mb-0 text-muted"><?php echo e(mb_strimwidth(strip_tags((string) ($project['description'] ?? '')), 0, 120, '…')); ?></p>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
<section class="py-5 bg-body-tertiary">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h2 class="h4">Featured products</h2>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($products as $product): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        <span class="fw-semibold"><?php echo e($product['name']); ?></span><br>
                                        <span class="text-muted small"><?php echo e(substr(strip_tags($product['description']), 0, 70)); ?>...</span>
                                    </span>
                                    <span class="fw-semibold">$<?php echo number_format((float) $product['price'], 2); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h2 class="h4">Key metrics</h2>
                        <div class="row g-4">
                            <?php foreach ($stats as $stat): ?>
                                <div class="col-6">
                                    <div class="stat-tile">
                                        <span class="label"><?php echo e($stat['label']); ?></span>
                                        <span class="value"><?php echo e($stat['value']); ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="py-5">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-5">
                <h2 class="display-6 fw-semibold">What clients say</h2>
                <p class="text-muted">Stories from teams that transformed their digital presence with SOSHEMAIN.</p>
                <a href="contact.php" class="btn btn-primary">Book consultation</a>
            </div>
            <div class="col-lg-7">
                <div class="row g-4">
                    <?php foreach ($testimonials as $testimonial): ?>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <p class="text-muted">“<?php echo e($testimonial['quote']); ?>”</p>
                                    <div class="fw-semibold"><?php echo e($testimonial['author']); ?></div>
                                    <span class="small text-muted"><?php echo e($testimonial['role']); ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="py-5 bg-body-tertiary">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <h2 class="h4 mb-1">Insights &amp; resources</h2>
                <p class="text-muted mb-0">The latest perspectives from our strategy team.</p>
            </div>
            <a href="blog.php" class="btn btn-outline-primary">View all posts</a>
        </div>
        <div class="row g-4">
            <?php foreach ($posts as $post): ?>
                <div class="col-md-4">
                    <article class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <span class="badge bg-soft-primary text-primary mb-3">Featured</span>
                            <h3 class="h5"><a href="post.php?slug=<?php echo e($post['slug']); ?>" class="stretched-link text-decoration-none"><?php echo e($post['title']); ?></a></h3>
                            <p class="text-muted"><?php echo e($post['excerpt']); ?></p>
                            <div class="small text-muted">By <?php echo e($post['author']); ?> • <?php echo date('M d, Y', strtotime($post['published_at'])); ?></div>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<section class="py-5">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5">
                        <h2 class="h3">Ready to partner with SOSHEMAIN?</h2>
                        <p class="text-muted">Share your goals and our consultants will craft a tailored roadmap to get you there.</p>
                        <form action="contact-submit.php" method="post" class="row g-3">
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
                                <label class="form-label">How can we help?</label>
                                <textarea class="form-control" name="message" rows="3" required></textarea>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Send message</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ratio ratio-16x9 rounded-4 overflow-hidden shadow-sm">
                    <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="SOSHEMAIN" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
