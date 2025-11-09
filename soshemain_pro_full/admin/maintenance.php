<?php
$title = 'Maintenance';
require_once __DIR__ . '/includes/header.php';
?>
<h1 class="h4 fw-bold mb-4">Maintenance mode</h1>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <p class="text-secondary">Toggle maintenance mode to temporarily hide the storefront while performing updates.</p>
        <form class="d-flex align-items-center gap-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="maintenanceSwitch" <?= MAINTENANCE_MODE ? 'checked' : '' ?>>
                <label class="form-check-label" for="maintenanceSwitch">Enable maintenance mode</label>
            </div>
            <button class="btn btn-primary" type="button">Save</button>
        </form>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
