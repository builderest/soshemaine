<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../controllers/AdminController.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Category.php';
$controller = new AdminController();
$productModel = new Product();
$categories = (new Category())->all();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf()) {
        $message = 'Token inválido.';
    } else {
        $images = array_map('trim', explode(',', $_POST['images'] ?? ''));
        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'slug' => trim($_POST['slug'] ?? ''),
            'description' => $_POST['description'] ?? '',
            'price' => (float)($_POST['price'] ?? 0),
            'sku' => trim($_POST['sku'] ?? ''),
            'stock' => (int)($_POST['stock'] ?? 0),
            'category_id' => (int)($_POST['category_id'] ?? 0),
            'images' => json_encode(array_filter($images)),
            'featured' => isset($_POST['featured']) ? 1 : 0,
            'meta_title' => trim($_POST['meta_title'] ?? ''),
            'meta_desc' => trim($_POST['meta_desc'] ?? ''),
            'meta_json' => $_POST['meta_json'] ?? '',
            'created_at' => $_POST['created_at'] ?? date('Y-m-d H:i:s')
        ];
        $id = $_POST['id'] ?? null;
        $message = $controller->genericSave('products', $data, $id ? (int)$id : null) ? 'Producto guardado.' : 'Error al guardar.';
    }
}
if (isset($_GET['delete'])) {
    $controller->genericDelete('products', (int)$_GET['delete']);
    header('Location: products.php');
    exit;
}
$products = $productModel->all();
?>
<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3">Productos</h1>
            <p class="text-secondary">Gestiona el catálogo de soluciones.</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal">Nuevo producto</button>
    </div>
    <?php if ($message): ?><div class="alert alert-info"><?= htmlspecialchars($message) ?></div><?php endif; ?>
    <div class="card-glass p-4">
        <div class="table-responsive">
            <table class="table table-dark align-middle">
                <thead><tr><th>Nombre</th><th>Precio</th><th>SKU</th><th>Stock</th><th>Destacado</th><th></th></tr></thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td><?= format_currency($product['price']) ?></td>
                        <td><?= htmlspecialchars($product['sku']) ?></td>
                        <td><?= htmlspecialchars($product['stock']) ?></td>
                        <td><?= $product['featured'] ? '<span class="badge bg-success">Sí</span>' : 'No' ?></td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-light" data-bs-toggle="modal" data-bs-target="#productModal" data-product='<?= htmlspecialchars(json_encode($product), ENT_QUOTES, "UTF-8") ?>'>Editar</button>
                            <a href="?delete=<?= $product['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar producto?');">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content bg-dark text-white">
            <form method="post" class="modal-body d-grid gap-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="h5 mb-0">Producto</h2>
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
                        <label class="form-label">Categoría</label>
                        <select name="category_id" class="form-select">
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Precio</label>
                        <input type="number" step="0.01" name="price" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">SKU</label>
                        <input type="text" name="sku" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Stock</label>
                        <input type="number" name="stock" class="form-control" required>
                    </div>
                </div>
                <div>
                    <label class="form-label">Descripción</label>
                    <textarea id="productDescription" name="description" data-editor="wysiwyg"></textarea>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Imágenes (separadas por coma)</label>
                        <input type="text" name="images" class="form-control" placeholder="imagen1.jpg, imagen2.webp">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Meta título</label>
                        <input type="text" name="meta_title" class="form-control">
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Meta descripción</label>
                        <textarea name="meta_desc" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Meta JSON</label>
                        <textarea name="meta_json" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="featured" id="featuredSwitch">
                    <label class="form-check-label" for="featuredSwitch">Destacar producto</label>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    const productModal = document.getElementById('productModal');
    productModal?.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const form = productModal.querySelector('form');
        if (!button || !form) return;
        const data = button.getAttribute('data-product');
    form.reset();
    form.querySelector('[name="id"]').value = '';
    form.querySelector('[name="featured"]').checked = false;
    const editor = tinymce.get('productDescription');
    if (editor) {
        editor.setContent('');
    }
    form.querySelector('[name="description"]').value = '';
    if (data) {
        const product = JSON.parse(data);
        form.querySelector('[name="id"]').value = product.id;
        form.querySelector('[name="name"]').value = product.name;
        form.querySelector('[name="slug"]').value = product.slug;
        form.querySelector('[name="category_id"]').value = product.category_id;
        form.querySelector('[name="price"]').value = product.price;
        form.querySelector('[name="sku"]').value = product.sku;
        form.querySelector('[name="stock"]').value = product.stock;
        form.querySelector('[name="images"]').value = (JSON.parse(product.images || '[]') || []).join(',');
        form.querySelector('[name="meta_title"]').value = product.meta_title;
        form.querySelector('[name="meta_desc"]').value = product.meta_desc;
        form.querySelector('[name="meta_json"]').value = product.meta_json;
        form.querySelector('[name="featured"]').checked = product.featured == 1;
        if (editor) {
            editor.setContent(product.description || '');
        }
        form.querySelector('[name="description"]').value = product.description;
    }
    });
</script>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
