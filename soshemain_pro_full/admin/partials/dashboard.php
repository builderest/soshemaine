<?php
$metrics = $data;
?>
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body">
                <p class="text-muted text-uppercase small mb-1">Contacts</p>
                <h2 class="h3 mb-0"><?php echo e($metrics['contacts'] ?? 0); ?></h2>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body">
                <p class="text-muted text-uppercase small mb-1">Posts</p>
                <h2 class="h3 mb-0"><?php echo e($metrics['posts'] ?? 0); ?></h2>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body">
                <p class="text-muted text-uppercase small mb-1">Products</p>
                <h2 class="h3 mb-0"><?php echo e($metrics['products'] ?? 0); ?></h2>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body">
                <p class="text-muted text-uppercase small mb-1">Revenue</p>
                <h2 class="h3 mb-0">$<?php echo number_format((float) ($metrics['revenue'] ?? 0), 2); ?></h2>
            </div>
        </div>
    </div>
</div>
<div class="row g-4">
    <div class="col-xl-8">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <h2 class="h5">Traffic overview</h2>
                <canvas id="trafficChart" data-visits="<?php echo e(json_encode([120, 140, 110, 190, 220, 180, 210])); ?>"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <h2 class="h5">Recent contacts</h2>
                <ul class="list-group list-group-flush">
                    <?php foreach (($metrics['recentContacts'] ?? []) as $contact): ?>
                        <li class="list-group-item">
                            <div class="fw-semibold"><?php echo e($contact['name']); ?></div>
                            <div class="small text-muted"><?php echo e($contact['email']); ?> &bull; <?php echo e(date('M d, Y', strtotime($contact['created_at']))); ?></div>
                        </li>
                    <?php endforeach; ?>
                    <?php if (empty($metrics['recentContacts'])): ?>
                        <li class="list-group-item text-muted">No contacts yet.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
