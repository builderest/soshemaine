<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../controllers/AdminController.php';
require_once __DIR__ . '/../models/Page.php';
$controller = new AdminController();
$pageModel = new Page();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf()) {
        $message = 'Token inválido.';
    } else {
        $id = $_POST['id'] ?? null;
        $data = [
            'title' => trim($_POST['title'] ?? ''),
            'slug' => trim($_POST['slug'] ?? ''),
            'content' => $_POST['content'] ?? '',
            'featured_image' => trim($_POST['featured_image'] ?? ''),
            'meta_title' => trim($_POST['meta_title'] ?? ''),
            'meta_desc' => trim($_POST['meta_desc'] ?? ''),
            'schema_json' => $_POST['schema_json'] ?? '',
            'status' => $_POST['status'] ?? 'draft',
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $message = $controller->genericSave('pages', $data, $id ? (int)$id : null) ? 'Página guardada.' : 'No se pudo guardar.';
    }
}

if (isset($_GET['delete'])) {
    $controller->genericDelete('pages', (int)$_GET['delete']);
    header('Location: pages.php');
    exit;
}

$pages = $pageModel->all();
?>
<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3">Páginas</h1>
            <p class="text-secondary">Gestiona secciones del sitio público.</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pageModal">Nueva página</button>
    </div>
    <?php if ($message): ?><div class="alert alert-info"><?= htmlspecialchars($message) ?></div><?php endif; ?>
    <div class="card-glass p-4">
        <div class="table-responsive">
            <table class="table table-dark align-middle">
                <thead><tr><th>Título</th><th>Slug</th><th>Estado</th><th>Actualización</th><th></th></tr></thead>
                <tbody>
                    <?php foreach ($pages as $page): ?>
                    <tr>
                        <td><?= htmlspecialchars($page['title']) ?></td>
                        <td><code><?= htmlspecialchars($page['slug']) ?></code></td>
                        <td><span class="badge bg-<?= $page['status'] === 'published' ? 'success' : 'warning' ?>"><?= htmlspecialchars($page['status']) ?></span></td>
                        <td><?= htmlspecialchars($page['updated_at']) ?></td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-light" data-bs-toggle="modal" data-bs-target="#pageModal" data-page='<?= htmlspecialchars(json_encode($page), ENT_QUOTES, "UTF-8") ?>'>Editar</button>
                            <a href="?delete=<?= $page['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar página?');">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="pageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content bg-dark text-white">
            <form method="post" class="modal-body d-grid gap-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="h5 mb-0">Página</h2>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <?= csrf_input() ?>
                <input type="hidden" name="id">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Título</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Estado</label>
                        <select name="status" class="form-select">
                            <option value="draft">Borrador</option>
                            <option value="published">Publicada</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="form-label">Contenido</label>
                    <textarea id="pageContent" name="content" data-editor="wysiwyg"></textarea>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Imagen destacada</label>
                        <input type="text" name="featured_image" class="form-control" placeholder="archivo.jpg">
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
                        <label class="form-label">Schema JSON-LD</label>
                        <textarea name="schema_json" class="form-control" rows="2"></textarea>
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
    const pageModal = document.getElementById('pageModal');
    pageModal?.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const form = pageModal.querySelector('form');
        if (!button || !form) return;
        const data = button.getAttribute('data-page');
    form.reset();
    form.querySelector('[name="id"]').value = '';
    const editor = tinymce.get('pageContent');
    if (editor) {
        editor.setContent('');
    }
    form.querySelector('[name="content"]').value = '';
    if (data) {
        const page = JSON.parse(data);
        form.querySelector('[name="id"]').value = page.id;
        form.querySelector('[name="title"]').value = page.title;
        form.querySelector('[name="slug"]').value = page.slug;
        form.querySelector('[name="status"]').value = page.status;
        form.querySelector('[name="featured_image"]').value = page.featured_image;
        form.querySelector('[name="meta_title"]').value = page.meta_title;
        form.querySelector('[name="meta_desc"]').value = page.meta_desc;
        form.querySelector('[name="schema_json"]').value = page.schema_json;
        if (editor) {
            editor.setContent(page.content || '');
        }
        form.querySelector('[name="content"]').value = page.content;
    }
});
</script>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
