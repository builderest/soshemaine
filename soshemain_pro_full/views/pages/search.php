<section class="py-5 bg-body-tertiary">
    <div class="container">
        <h1 class="display-5 fw-semibold mb-4">Search results</h1>
        <form action="search.php" class="input-group mb-4">
            <input type="search" class="form-control" name="q" value="<?php echo e($query); ?>" placeholder="Search the site">
            <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
        </form>
        <div class="list-group shadow-sm">
            <?php foreach ($results as $item): ?>
                <a href="<?php echo e($item['url'] ?? '#'); ?>" class="list-group-item list-group-item-action">
                    <div class="d-flex justify-content-between">
                        <h2 class="h6 mb-1"><?php echo e($item['title']); ?></h2>
                        <span class="badge bg-primary-subtle text-primary text-uppercase"><?php echo e($item['type']); ?></span>
                    </div>
                </a>
            <?php endforeach; ?>
            <?php if ($query && empty($results)): ?>
                <div class="list-group-item text-muted">No results found.</div>
            <?php endif; ?>
        </div>
    </div>
</section>
