<article class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <span class="badge bg-soft-primary text-primary mb-3"><?php echo e($post['categories']); ?></span>
                <h1 class="display-4 fw-semibold mb-3"><?php echo e($post['title']); ?></h1>
                <div class="text-muted mb-4">By <?php echo e($post['author']); ?> • <?php echo date('F d, Y', strtotime($post['published_at'])); ?></div>
                <img src="images/blog-placeholder.svg" class="img-fluid rounded-4 mb-4" alt="<?php echo e($post['title']); ?>">
                <div class="post-content lead">
                    <?php echo $post['content']; ?>
                </div>
                <div class="border-top mt-5 pt-4 d-flex justify-content-between flex-wrap gap-3">
                    <div>
                        <strong>Tags:</strong>
                        <?php foreach (array_filter(array_map('trim', explode(',', $post['tags'] ?? ''))) as $tag): ?>
                            <span class="badge bg-primary-subtle text-primary me-2"><?php echo e($tag); ?></span>
                        <?php endforeach; ?>
                    </div>
                    <a href="blog.php" class="btn btn-outline-primary">Back to blog</a>
                </div>
            </div>
        </div>
    </div>
</article>
