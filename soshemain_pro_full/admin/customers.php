<?php
$title = 'Customers';
require_once __DIR__ . '/includes/header.php';
require_once BASE_PATH . '/core/db.php';
$customers = run_query('SELECT id, name, email, phone, created_at FROM customers ORDER BY created_at DESC');
?>
<h1 class="h4 fw-bold mb-4">Customers</h1>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customers as $customer): ?>
                    <tr>
                        <td><?= e($customer['name']) ?></td>
                        <td><?= e($customer['email']) ?></td>
                        <td><?= e($customer['phone']) ?></td>
                        <td><?= date('M j, Y', strtotime($customer['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
