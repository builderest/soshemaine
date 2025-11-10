<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../models/Role.php';
$roleModel = new Role();
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf()) {
    $permissions = json_decode($_POST['permissions'] ?? '[]', true);
    $data = [
        'name' => trim($_POST['name'] ?? ''),
        'permissions' => json_encode($permissions)
    ];
    $id = $_POST['id'] ?? null;
    if ($id) {
        $roleModel->update($id, $data);
    } else {
        $roleModel->create($data);
    }
    $message = 'Rol actualizado.';
}
if (isset($_GET['delete'])) {
    $roleModel->delete((int)$_GET['delete']);
    header('Location: roles.php');
    exit;
}
$roles = $roleModel->all();
?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3">Roles</h1>
            <p class="text-secondary">Define permisos personalizados.</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#roleModal">Nuevo rol</button>
    </div>
    <?php if ($message): ?><div class="alert alert-info"><?= htmlspecialchars($message) ?></div><?php endif; ?>
    <div class="card-glass p-4">
        <table class="table table-dark align-middle">
            <thead><tr><th>Nombre</th><th>Permisos</th><th></th></tr></thead>
            <tbody>
                <?php foreach ($roles as $role): ?>
                <tr>
                    <td><?= htmlspecialchars($role['name']) ?></td>
                    <td><pre class="small text-secondary mb-0"><?= htmlspecialchars($role['permissions']) ?></pre></td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-light" data-bs-toggle="modal" data-bs-target="#roleModal" data-role='<?= htmlspecialchars(json_encode($role), ENT_QUOTES, "UTF-8") ?>'>Editar</button>
                        <a href="?delete=<?= $role['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar rol?');">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="roleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark text-white">
            <form method="post" class="modal-body d-grid gap-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="h5 mb-0">Rol</h2>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <?= csrf_input() ?>
                <input type="hidden" name="id">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Permisos (JSON)</label>
                        <textarea name="permissions" class="form-control" rows="5">{"pages":true,"products":true}</textarea>
                    </div>
                </div>
                <div class="text-end">
                    <button class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    const roleModal = document.getElementById('roleModal');
    roleModal?.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const form = roleModal.querySelector('form');
        if (!button || !form) return;
        const data = button.getAttribute('data-role');
        form.reset();
        form.querySelector('[name="id"]').value = '';
        if (data) {
            const role = JSON.parse(data);
            form.querySelector('[name="id"]').value = role.id;
            form.querySelector('[name="name"]').value = role.name;
            form.querySelector('[name="permissions"]').value = role.permissions;
        }
    });
</script>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
