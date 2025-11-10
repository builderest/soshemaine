<?php $items = $data['items'] ?? []; ?>
<div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="h5 mb-0">Menus</h2>
        <button class="btn btn-sm btn-primary" data-bs-toggle="collapse" data-bs-target="#menuFormCollapse">Add menu</button>
    </div>
    <div class="collapse" id="menuFormCollapse">
        <div class="card-body">
            <form method="post" id="menuForm">
                <?php echo Csrf::field(); ?>
                <input type="hidden" name="id" value="">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Location</label>
                        <select name="location" class="form-select">
                            <option value="primary">Primary</option>
                            <option value="footer">Footer</option>
                            <option value="utility">Utility</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Items (JSON)</label>
                        <textarea name="items" class="form-control" rows="3">[{"label":"Home","url":"/"}]</textarea>
                    </div>
                    <div class="col-12">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Save menu</button>
                            <button type="button" class="btn btn-outline-secondary" data-reset-form="menuForm">Clear</button>
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
                    <th>Location</th>
                    <th>Items</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?php echo e($item['name']); ?></td>
                        <td><?php echo e($item['location']); ?></td>
                        <td><code class="small text-wrap d-block" style="max-width:320px; white-space:pre-wrap;"><?php echo e($item['items']); ?></code></td>
                        <td class="text-end">
                            <?php $menuPayload = json_encode([
                                'id' => $item['id'],
                                'name' => $item['name'],
                                'location' => $item['location'],
                                'items' => $item['items'],
                            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>
                            <button type="button" class="btn btn-sm btn-outline-secondary me-1" data-edit="menuForm" data-fields='<?php echo e($menuPayload); ?>'>Edit</button>
                            <form method="post" class="d-inline" onsubmit="return confirm('Delete this menu?');">
                                <?php echo Csrf::field(); ?>
                                <input type="hidden" name="delete" value="<?php echo e($item['id']); ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($items)): ?>
                    <tr><td colspan="4" class="text-center text-muted">No menus yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
