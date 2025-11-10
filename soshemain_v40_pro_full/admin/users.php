<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../controllers/AdminController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Role.php';
$controller = new AdminController();
$roles = (new Role())->all();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf()) {
        $message = 'Token de seguridad inválido.';
    } else {
        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'role' => $_POST['role'] ?? 'editor',
            'status' => $_POST['status'] ?? 'active',
        ];
        if (!empty($_POST['password'])) {
            $data['password'] = $_POST['password'];
        }
        $id = $_POST['id'] ?? null;
        $message = $controller->saveUser($data, $id ? (int)$id : null) ? 'Usuario guardado.' : 'No se pudo guardar el usuario.';
    }
}

if (isset($_GET['delete'])) {
    $controller->deleteUser((int)$_GET['delete']);
    header('Location: users.php');
    exit;
}

$users = $controller->users();
?>
<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3">Usuarios</h1>
            <p class="text-secondary">Gestiona accesos y roles del equipo.</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal"><i class="bi bi-plus"></i> Nuevo usuario</button>
    </div>
    <?php if ($message): ?><div class="alert alert-info"><?= htmlspecialchars($message) ?></div><?php endif; ?>
    <div class="card-glass p-4">
        <div class="table-responsive">
            <table class="table table-dark align-middle">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><span class="badge bg-primary-subtle text-primary text-uppercase"><?= htmlspecialchars($user['role']) ?></span></td>
                        <td><?= htmlspecialchars($user['status']) ?></td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-light" data-bs-toggle="modal" data-bs-target="#userModal" data-user='<?= htmlspecialchars(json_encode($user), ENT_QUOTES, "UTF-8") ?>'>Editar</button>
                            <a href="?delete=<?= $user['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar usuario?');">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark text-white">
            <form method="post" class="modal-body d-grid gap-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="h5 mb-0">Usuario</h2>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <?= csrf_input() ?>
                <input type="hidden" name="id" id="userId">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nombre completo</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Correo</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Rol</label>
                        <select name="role" class="form-select">
                            <?php foreach ($roles as $role): ?>
                                <option value="<?= htmlspecialchars($role['name']) ?>"><?= htmlspecialchars($role['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Estado</label>
                        <select name="status" class="form-select">
                            <option value="active">Activo</option>
                            <option value="inactive">Inactivo</option>
                        </select>
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    const userModal = document.getElementById('userModal');
    userModal?.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const form = userModal.querySelector('form');
        if (!button || !form) return;
        const data = button.getAttribute('data-user');
        form.reset();
        form.querySelector('[name="id"]').value = '';
        if (data) {
            const user = JSON.parse(data);
            form.querySelector('[name="id"]').value = user.id;
            form.querySelector('[name="name"]').value = user.name;
            form.querySelector('[name="email"]').value = user.email;
            form.querySelector('[name="role"]').value = user.role;
            form.querySelector('[name="status"]').value = user.status;
        }
    });
</script>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
