<?php $items = $data['items'] ?? []; ?>
<div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="h5 mb-0">Media Library</h2>
        <button class="btn btn-sm btn-primary" data-bs-toggle="collapse" data-bs-target="#mediaForm">Upload</button>
    </div>
    <div class="collapse" id="mediaForm">
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <?php echo Csrf::field(); ?>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Select file</label>
                        <input type="file" name="media" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Alt text</label>
                        <input type="text" name="alt" class="form-control">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Upload media</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row g-3 p-3">
        <?php foreach ($items as $item): ?>
            <div class="col-sm-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm">
                    <img src="<?php echo e('../uploads/' . $item['filename']); ?>" class="card-img-top" alt="<?php echo e($item['alt']); ?>" loading="lazy">
                    <div class="card-body small">
                        <div class="fw-semibold text-truncate"><?php echo e($item['filename']); ?></div>
                        <div class="text-muted">Size: <?php echo number_format($item['size'] / 1024, 1); ?> KB</div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php if (empty($items)): ?>
            <div class="col-12 text-muted text-center">No media uploaded yet.</div>
        <?php endif; ?>
    </div>
</div>
