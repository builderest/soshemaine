<?php
$title = 'Users';
require_once __DIR__ . '/includes/header.php';
require_once BASE_PATH . '/core/db.php';
$users = run_query('SELECT id, name, email, role, last_login_at FROM users ORDER BY created_at DESC');
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h4 fw-bold mb-0">Team members</h1>
    <a class="btn btn-primary" href="#">Add user</a>
</div>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Last login</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= e($user['name']) ?></td>
                        <td><?= e($user['email']) ?></td>
                        <td><span class="badge bg-primary-subtle text-primary text-uppercase"><?= e($user['role']) ?></span></td>
                        <td><?= $user['last_login_at'] ? date('M j, Y g:i a', strtotime($user['last_login_at'])) : 'Never' ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
