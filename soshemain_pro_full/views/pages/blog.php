<section class="py-5 bg-body-tertiary">
    <div class="container">
        <div class="row justify-content-between align-items-end mb-4">
            <div class="col-lg-8">
                <h1 class="display-5 fw-semibold">Insights &amp; analysis</h1>
                <p class="text-muted lead">Ideas, playbooks, and stories from the SOSHEMAIN team.</p>
            </div>
            <div class="col-lg-4">
                <form action="search.php" class="input-group">
                    <input type="search" class="form-control" name="q" placeholder="Search the blog" aria-label="Search">
                    <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                </form>
            </div>
        </div>
        <div class="row g-4">
            <?php foreach ($items as $post): ?>
                <div class="col-md-6 col-xl-4">
                    <article class="card h-100 border-0 shadow-sm hover-lift">
                        <div class="card-body">
                            <span class="badge bg-soft-primary text-primary mb-3"><?php echo e($post['categories']); ?></span>
                            <h2 class="h4"><a href="post.php?slug=<?php echo e($post['slug']); ?>" class="stretched-link text-decoration-none"><?php echo e($post['title']); ?></a></h2>
                            <p class="text-muted"><?php echo e($post['excerpt']); ?></p>
                            <div class="small text-muted">By <?php echo e($post['author']); ?> • <?php echo date('M d, Y', strtotime($post['published_at'])); ?></div>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
            <?php if (empty($items)): ?>
                <div class="col-12 text-center text-muted">No posts yet.</div>
            <?php endif; ?>
        </div>
        <?php if (!empty($pagination) && $pagination['total_pages'] > 1): ?>
            <nav class="mt-4" aria-label="Blog pagination">
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
