<?php $items = $data['items'] ?? []; ?>
<div class="card shadow-sm border-0">
    <div class="card-header">
        <h2 class="h5 mb-0">Contacts inbox</h2>
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Received</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?php echo e($item['name']); ?></td>
                        <td><?php echo e($item['email']); ?></td>
                        <td><?php echo e($item['message']); ?></td>
                        <td><?php echo date('M d, Y H:i', strtotime($item['created_at'])); ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($items)): ?>
                    <tr><td colspan="4" class="text-center text-muted">No contacts yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
