<?php
$title = 'Backups';
require_once __DIR__ . '/includes/header.php';
?>
<h1 class="h4 fw-bold mb-4">Database backups</h1>
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <p class="text-secondary">Create a downloadable SQL backup of your database for safekeeping.</p>
        <button class="btn btn-primary" type="button">Generate backup</button>
    </div>
</div>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <h2 class="h6 fw-bold mb-3">Recent backups</h2>
        <ul class="list-unstyled mb-0">
            <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                <span>2024-05-01 10:00 UTC</span>
                <a class="btn btn-sm btn-outline-secondary" href="#">Download</a>
            </li>
            <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                <span>2024-04-15 10:00 UTC</span>
                <a class="btn btn-sm btn-outline-secondary" href="#">Download</a>
            </li>
        </ul>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
