<?php $items = $data['items'] ?? []; ?>
<div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="h5 mb-0">Services</h2>
        <button class="btn btn-sm btn-primary" data-bs-toggle="collapse" data-bs-target="#serviceFormCollapse">Add service</button>
    </div>
    <div class="collapse" id="serviceFormCollapse">
        <div class="card-body">
            <form method="post" id="serviceForm">
                <?php echo Csrf::field(); ?>
                <input type="hidden" name="id" value="">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Icon</label>
                        <input type="text" name="icon" class="form-control" value="bi-stars">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
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
                            <button type="submit" class="btn btn-primary">Save service</button>
                            <button type="button" class="btn btn-outline-secondary" data-reset-form="serviceForm">Clear</button>
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
                    <th>Status</th>
                    <th>Order</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?php echo e($item['name']); ?></td>
                        <td><span class="badge bg-<?php echo $item['status'] === 'published' ? 'success' : 'secondary'; ?>"><?php echo e($item['status']); ?></span></td>
                        <td><?php echo e($item['sort_order']); ?></td>
                        <td class="text-end">
                            <?php $servicePayload = json_encode([
                                'id' => $item['id'],
                                'name' => $item['name'],
                                'description' => $item['description'],
                                'icon' => $item['icon'],
                                'status' => $item['status'],
                                'sort_order' => $item['sort_order'],
                            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>
                            <button type="button" class="btn btn-sm btn-outline-secondary me-1" data-edit="serviceForm" data-fields='<?php echo e($servicePayload); ?>'>Edit</button>
                            <form method="post" class="d-inline" onsubmit="return confirm('Delete this service?');">
                                <?php echo Csrf::field(); ?>
                                <input type="hidden" name="delete" value="<?php echo e($item['id']); ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($items)): ?>
                    <tr><td colspan="4" class="text-center text-muted">No services yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
