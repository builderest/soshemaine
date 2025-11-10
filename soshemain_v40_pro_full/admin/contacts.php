<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../models/Contact.php';
$contactModel = new Contact();
if (isset($_GET['status'], $_GET['id'])) {
    if (csrf_valid($_GET[app_config('security')['csrf_token_name']])) {
        $contactModel->update((int)$_GET['id'], ['status' => $_GET['status']]);
    }
    header('Location: contacts.php');
    exit;
}
$contacts = $contactModel->all();
?>
<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3">Contactos</h1>
            <p class="text-secondary">Gestiona solicitudes recibidas desde el sitio.</p>
        </div>
    </div>
    <div class="card-glass p-4">
        <div class="table-responsive">
            <table class="table table-dark align-middle">
                <thead><tr><th>Nombre</th><th>Correo</th><th>Teléfono</th><th>Mensaje</th><th>Estado</th><th>Fecha</th><th></th></tr></thead>
                <tbody>
                    <?php foreach ($contacts as $contact): ?>
                    <tr>
                        <td><?= htmlspecialchars($contact['name']) ?></td>
                        <td><a href="mailto:<?= htmlspecialchars($contact['email']) ?>" class="text-primary"><?= htmlspecialchars($contact['email']) ?></a></td>
                        <td><?= htmlspecialchars($contact['phone']) ?></td>
                        <td class="text-break" style="max-width: 240px;">
                            <?= nl2br(htmlspecialchars($contact['message'])) ?>
                        </td>
                        <td><?= htmlspecialchars($contact['status']) ?></td>
                        <td><?= htmlspecialchars($contact['created_at']) ?></td>
                        <td class="text-end">
                            <div class="btn-group">
                                <a href="?id=<?= $contact['id'] ?>&status=en%20proceso&<?= app_config('security')['csrf_token_name'] ?>=<?= csrf_token() ?>" class="btn btn-sm btn-outline-light">En proceso</a>
                                <a href="?id=<?= $contact['id'] ?>&status=atendido&<?= app_config('security')['csrf_token_name'] ?>=<?= csrf_token() ?>" class="btn btn-sm btn-outline-success">Resuelto</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
