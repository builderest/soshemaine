<?php $items = $data['items'] ?? []; ?>
<div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="h5 mb-0">Pages</h2>
        <button class="btn btn-sm btn-primary" data-bs-toggle="collapse" data-bs-target="#pageFormCollapse">Add page</button>
    </div>
    <div class="collapse" id="pageFormCollapse">
        <div class="card-body">
            <form method="post" id="pageForm">
                <?php echo Csrf::field(); ?>
                <input type="hidden" name="id" value="">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" class="form-control" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Hero (JSON)</label>
                        <textarea name="hero_json" class="form-control" rows="2">{"title":"New Page","subtitle":"Subheading","cta":{"label":"Learn more","url":"#"}}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Sections (JSON)</label>
                        <textarea name="sections_json" class="form-control" rows="3">[]</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">SEO (JSON)</label>
                        <textarea name="seo_json" class="form-control" rows="2">{"meta_title":"New Page","meta_description":"Description"}</textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Order</label>
                        <input type="number" name="sort_order" class="form-control" value="0">
                    </div>
                    <div class="col-12">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Save page</button>
                            <button type="button" class="btn btn-outline-secondary" data-reset-form="pageForm">Clear</button>
                        </div>
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
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Order</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?php echo e($item['title']); ?></td>
                        <td><code><?php echo e($item['slug']); ?></code></td>
                        <td><span class="badge bg-<?php echo $item['status'] === 'published' ? 'success' : 'secondary'; ?>"><?php echo e($item['status']); ?></span></td>
                        <td><?php echo e($item['sort_order']); ?></td>
                        <td class="text-end">
                            <?php $pagePayload = json_encode([
                                'id' => $item['id'],
                                'title' => $item['title'],
                                'slug' => $item['slug'],
                                'hero_json' => $item['hero'],
                                'sections_json' => $item['sections'],
                                'seo_json' => $item['seo'],
                                'status' => $item['status'],
                                'sort_order' => $item['sort_order'],
                            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>
                            <button type="button" class="btn btn-sm btn-outline-secondary me-1" data-edit="pageForm" data-fields='<?php echo e($pagePayload); ?>'>Edit</button>
                            <form method="post" class="d-inline" onsubmit="return confirm('Delete this page?');">
                                <?php echo Csrf::field(); ?>
                                <input type="hidden" name="delete" value="<?php echo e($item['id']); ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($items)): ?>
                    <tr><td colspan="5" class="text-center text-muted">No pages created yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
