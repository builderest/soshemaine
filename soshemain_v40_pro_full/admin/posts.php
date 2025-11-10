<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../controllers/AdminController.php';
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../models/Category.php';
$controller = new AdminController();
$postModel = new Post();
$categories = (new Category())->all();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf()) {
        $message = 'Token inválido.';
    } else {
        $data = [
            'title' => trim($_POST['title'] ?? ''),
            'slug' => trim($_POST['slug'] ?? ''),
            'excerpt' => trim($_POST['excerpt'] ?? ''),
            'content' => $_POST['content'] ?? '',
            'author_id' => Auth::user()['id'],
            'cover' => trim($_POST['cover'] ?? ''),
            'status' => $_POST['status'] ?? 'draft',
            'meta_title' => trim($_POST['meta_title'] ?? ''),
            'meta_desc' => trim($_POST['meta_desc'] ?? ''),
            'published_at' => $_POST['published_at'] ?? date('Y-m-d H:i:s')
        ];
        $id = $_POST['id'] ?? null;
        $message = $controller->genericSave('posts', $data, $id ? (int)$id : null) ? 'Post guardado.' : 'No se pudo guardar.';
    }
}
if (isset($_GET['delete'])) {
    $controller->genericDelete('posts', (int)$_GET['delete']);
    header('Location: posts.php');
    exit;
}
$posts = $postModel->all();
?>
<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3">Blog</h1>
            <p class="text-secondary">Publica insights y noticias.</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#postModal">Nuevo post</button>
    </div>
    <?php if ($message): ?><div class="alert alert-info"><?= htmlspecialchars($message) ?></div><?php endif; ?>
    <div class="card-glass p-4">
        <div class="table-responsive">
            <table class="table table-dark align-middle">
                <thead><tr><th>Título</th><th>Estado</th><th>Publicado</th><th></th></tr></thead>
                <tbody>
                    <?php foreach ($posts as $post): ?>
                    <tr>
                        <td><?= htmlspecialchars($post['title']) ?></td>
                        <td><?= htmlspecialchars($post['status']) ?></td>
                        <td><?= htmlspecialchars($post['published_at']) ?></td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-light" data-bs-toggle="modal" data-bs-target="#postModal" data-post='<?= htmlspecialchars(json_encode($post), ENT_QUOTES, "UTF-8") ?>'>Editar</button>
                            <a href="?delete=<?= $post['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar post?');">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="postModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content bg-dark text-white">
            <form method="post" class="modal-body d-grid gap-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="h5 mb-0">Post</h2>
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
                            <option value="published">Publicado</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="form-label">Extracto</label>
                    <textarea name="excerpt" class="form-control" rows="2"></textarea>
                </div>
                <div>
                    <label class="form-label">Contenido</label>
                    <textarea id="postContent" name="content" data-editor="wysiwyg"></textarea>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Imagen de portada</label>
                        <input type="text" name="cover" class="form-control" placeholder="portada.jpg" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Meta título</label>
                        <input type="text" name="meta_title" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Fecha publicación</label>
                        <input type="datetime-local" name="published_at" class="form-control">
                    </div>
                </div>
                <div>
                    <label class="form-label">Meta descripción</label>
                    <textarea name="meta_desc" class="form-control" rows="2"></textarea>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    const postModal = document.getElementById('postModal');
    postModal?.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const form = postModal.querySelector('form');
        if (!button || !form) return;
        const data = button.getAttribute('data-post');
    form.reset();
    form.querySelector('[name="id"]').value = '';
    const editor = tinymce.get('postContent');
    if (editor) {
        editor.setContent('');
    }
    form.querySelector('[name="content"]').value = '';
    if (data) {
        const post = JSON.parse(data);
        form.querySelector('[name="id"]').value = post.id;
        form.querySelector('[name="title"]').value = post.title;
        form.querySelector('[name="slug"]').value = post.slug;
        form.querySelector('[name="status"]').value = post.status;
        form.querySelector('[name="excerpt"]').value = post.excerpt;
        form.querySelector('[name="cover"]').value = post.cover;
        form.querySelector('[name="meta_title"]').value = post.meta_title;
        form.querySelector('[name="meta_desc"]').value = post.meta_desc;
        form.querySelector('[name="published_at"]').value = post.published_at ? post.published_at.replace(' ', 'T') : '';
        if (editor) {
            editor.setContent(post.content || '');
        }
        form.querySelector('[name="content"]').value = post.content;
    }
    });
</script>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
