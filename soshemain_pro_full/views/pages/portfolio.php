<?php $projects = $projects ?? []; ?>
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold">Portfolio</h1>
            <p class="lead text-muted">Explore the engagements and digital products we deliver for ambitious teams.</p>
        </div>
        <div class="row g-4">
            <?php foreach ($projects as $project): ?>
                <div class="col-md-6 col-xl-4">
                    <article class="card border-0 shadow-sm portfolio-card h-100">
                        <?php $thumb = $project['thumbnail'] ?: ($project['images'][0] ?? ''); ?>
                        <?php if ($thumb): ?>
                            <div class="ratio ratio-4x3">
                                <img src="<?php echo e(asset('uploads/' . $thumb)); ?>" class="card-img-top object-fit-cover" alt="<?php echo e($project['title']); ?>" loading="lazy" decoding="async">
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <?php if ($project['featured']): ?><span class="badge bg-dark text-uppercase mb-2">Featured</span><?php endif; ?>
                            <h2 class="h5"><a href="portfolio-item.php?slug=<?php echo e($project['slug']); ?>" class="stretched-link text-decoration-none"><?php echo e($project['title']); ?></a></h2>
                            <p class="text-muted small mb-2"><?php echo e($project['category'] ?: 'Case study'); ?><?php if (!empty($project['client'])): ?> • <?php echo e($project['client']); ?><?php endif; ?></p>
                            <p class="text-muted mb-0"><?php echo e(mb_strimwidth(strip_tags((string) ($project['description'] ?? '')), 0, 140, '…')); ?></p>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
            <?php if (empty($projects)): ?>
                <div class="col-12">
                    <div class="alert alert-info border-0">No portfolio projects are published yet. Add projects from the admin dashboard.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
