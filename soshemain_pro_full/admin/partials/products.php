<?php $items = $data['items'] ?? []; ?>
<div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="h5 mb-0">Products</h2>
        <button class="btn btn-sm btn-primary" data-bs-toggle="collapse" data-bs-target="#productFormCollapse">Add product</button>
    </div>
    <div class="collapse" id="productFormCollapse">
        <div class="card-body">
            <form method="post" id="productForm">
                <?php echo Csrf::field(); ?>
                <input type="hidden" name="id" value="">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Price</label>
                        <input type="number" step="0.01" name="price" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">SKU</label>
                        <input type="text" name="sku" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Stock</label>
                        <input type="number" name="stock" class="form-control" value="0">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="productDescription" class="form-control tinymce-editor"></textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Featured</label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" name="featured" value="1">
                            <label class="form-check-label">Featured product</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Gallery (JSON)</label>
                        <textarea name="gallery_json" class="form-control" rows="2">[]</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Variants (JSON)</label>
                        <textarea name="variants_json" class="form-control" rows="2">[]</textarea>
                    </div>
                    <div class="col-12">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Save product</button>
                            <button type="button" class="btn btn-outline-secondary" data-reset-form="productForm">Clear</button>
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
                    <th>Name</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Stock</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?php echo e($item['name']); ?></td>
                        <td>$<?php echo number_format((float) $item['price'], 2); ?></td>
                        <td><span class="badge bg-<?php echo $item['status'] === 'published' ? 'success' : 'secondary'; ?>"><?php echo e($item['status']); ?></span></td>
                        <td><?php echo e($item['stock']); ?></td>
                        <td class="text-end">
                            <?php $productPayload = json_encode([
                                'id' => $item['id'],
                                'name' => $item['name'],
                                'slug' => $item['slug'],
                                'price' => $item['price'],
                                'sku' => $item['sku'],
                                'stock' => $item['stock'],
                                'description' => $item['description'],
                                'status' => $item['status'],
                                'featured' => $item['featured'],
                                'gallery_json' => $item['gallery'],
                                'variants_json' => $item['variants'],
                            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>
                            <button type="button" class="btn btn-sm btn-outline-secondary me-1" data-edit="productForm" data-fields='<?php echo e($productPayload); ?>'>Edit</button>
                            <form method="post" class="d-inline" onsubmit="return confirm('Delete this product?');">
                                <?php echo Csrf::field(); ?>
                                <input type="hidden" name="delete" value="<?php echo e($item['id']); ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($items)): ?>
                    <tr><td colspan="5" class="text-center text-muted">No products yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
