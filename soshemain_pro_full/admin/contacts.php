<?php
$title = 'Contact requests';
require_once __DIR__ . '/includes/header.php';
require_once BASE_PATH . '/core/db.php';
$contacts = run_query('SELECT name, email, company, phone, message, created_at FROM contacts ORDER BY created_at DESC');
?>
<h1 class="h4 fw-bold mb-4">Contact requests</h1>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Company</th>
                        <th>Phone</th>
                        <th>Message</th>
                        <th>Received</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contacts as $contact): ?>
                    <tr>
                        <td><?= e($contact['name']) ?></td>
                        <td><?= e($contact['email']) ?></td>
                        <td><?= e($contact['company']) ?></td>
                        <td><?= e($contact['phone']) ?></td>
                        <td><?= e($contact['message']) ?></td>
                        <td><?= date('M j, Y g:i a', strtotime($contact['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
