<?php $items = $data['items'] ?? []; ?>
<div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="h5 mb-0">Portfolio projects</h2>
        <button class="btn btn-sm btn-primary" data-bs-toggle="collapse" data-bs-target="#portfolioFormCollapse">Add project</button>
    </div>
    <div class="collapse" id="portfolioFormCollapse">
        <div class="card-body">
            <form method="post" id="portfolioForm" enctype="multipart/form-data">
                <?php echo Csrf::field(); ?>
                <input type="hidden" name="id" value="">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" class="form-control" placeholder="auto-generate if blank">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Category</label>
                        <input type="text" name="category" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Client</label>
                        <input type="text" name="client" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="draft">Draft</option>
                            <option value="published" selected>Published</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Video URL</label>
                        <input type="url" name="video_url" class="form-control" placeholder="https://youtube.com/...">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">External link</label>
                        <input type="url" name="link" class="form-control" placeholder="https://">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Featured</label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" name="featured" value="1">
                            <label class="form-check-label">Show on homepage</label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Current thumbnail filename</label>
                        <input type="text" name="thumbnail" class="form-control" placeholder="uploads filename">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Upload thumbnail</label>
                        <input type="file" name="thumbnail_file" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Upload gallery images</label>
                        <input type="file" name="gallery_files[]" class="form-control" accept="image/*" multiple>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Gallery filenames (JSON)</label>
                        <textarea name="images_json" class="form-control" rows="2">[]</textarea>
                        <small class="text-muted">Existing filenames are kept. Uploading new images appends to this list.</small>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="portfolioDescription" class="form-control tinymce-editor"></textarea>
                    </div>
                    <div class="col-12 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Save project</button>
                        <button type="button" class="btn btn-outline-secondary" data-reset-form="portfolioForm">Clear</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Featured</th>
                    <th>Updated</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <?php $createdAt = !empty($item['created_at']) ? date('M d, Y', strtotime($item['created_at'])) : '—'; ?>
                    <tr>
                        <td><?php echo e($item['title']); ?></td>
                        <td><?php echo e($item['category'] ?: '—'); ?></td>
                        <td><span class="badge bg-<?php echo $item['status'] === 'published' ? 'success' : 'secondary'; ?>"><?php echo e($item['status']); ?></span></td>
                        <td><?php echo $item['featured'] ? '<span class="badge bg-primary">Featured</span>' : '<span class="text-muted">No</span>'; ?></td>
                        <td><?php echo e($createdAt); ?></td>
                        <td class="text-end">
                            <?php $payload = json_encode([
                                'id' => $item['id'],
                                'title' => $item['title'],
                                'slug' => $item['slug'],
                                'category' => $item['category'],
                                'client' => $item['client'],
                                'status' => $item['status'],
                                'video_url' => $item['video_url'],
                                'link' => $item['link'],
                                'featured' => $item['featured'],
                                'thumbnail' => $item['thumbnail'],
                                'images_json' => json_encode($item['images'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                                'description' => $item['description'],
                            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>
                            <button type="button" class="btn btn-sm btn-outline-secondary me-1" data-edit="portfolioForm" data-fields='<?php echo e($payload); ?>'>Edit</button>
                            <form method="post" class="d-inline" onsubmit="return confirm('Delete this project?');">
                                <?php echo Csrf::field(); ?>
                                <input type="hidden" name="delete" value="<?php echo e($item['id']); ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($items)): ?>
                    <tr><td colspan="6" class="text-center text-muted">No portfolio projects yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
