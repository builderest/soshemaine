<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../controllers/AdminController.php';
require_once __DIR__ . '/../models/Category.php';
$controller = new AdminController();
$categoryModel = new Category();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf()) {
        $message = 'Token inválido.';
    } else {
        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'slug' => trim($_POST['slug'] ?? ''),
            'type' => $_POST['type'] ?? 'product',
            'created_at' => date('Y-m-d H:i:s')
        ];
        $id = $_POST['id'] ?? null;
        $message = $controller->genericSave('categories', $data, $id ? (int)$id : null) ? 'Categoría guardada.' : 'No se pudo guardar.';
    }
}
if (isset($_GET['delete'])) {
    $controller->genericDelete('categories', (int)$_GET['delete']);
    header('Location: categories.php');
    exit;
}
$categories = $categoryModel->all();
?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3">Categorías</h1>
            <p class="text-secondary">Organiza servicios, productos y contenidos.</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoryModal">Nueva categoría</button>
    </div>
    <?php if ($message): ?><div class="alert alert-info"><?= htmlspecialchars($message) ?></div><?php endif; ?>
    <div class="card-glass p-4">
        <table class="table table-dark align-middle">
            <thead><tr><th>Nombre</th><th>Slug</th><th>Tipo</th><th></th></tr></thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?= htmlspecialchars($category['name']) ?></td>
                    <td><code><?= htmlspecialchars($category['slug']) ?></code></td>
                    <td><?= htmlspecialchars($category['type']) ?></td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-light" data-bs-toggle="modal" data-bs-target="#categoryModal" data-category='<?= htmlspecialchars(json_encode($category), ENT_QUOTES, "UTF-8") ?>'>Editar</button>
                        <a href="?delete=<?= $category['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar?');">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark text-white">
            <form method="post" class="modal-body d-grid gap-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="h5 mb-0">Categoría</h2>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <?= csrf_input() ?>
                <input type="hidden" name="id">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tipo</label>
                        <select name="type" class="form-select">
                            <option value="product">Producto</option>
                            <option value="post">Post</option>
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
    const categoryModal = document.getElementById('categoryModal');
    categoryModal?.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const form = categoryModal.querySelector('form');
        if (!button || !form) return;
        const data = button.getAttribute('data-category');
        form.reset();
        form.querySelector('[name="id"]').value = '';
        if (data) {
            const category = JSON.parse(data);
            form.querySelector('[name="id"]').value = category.id;
            form.querySelector('[name="name"]').value = category.name;
            form.querySelector('[name="slug"]').value = category.slug;
            form.querySelector('[name="type"]').value = category.type;
        }
    });
</script>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
