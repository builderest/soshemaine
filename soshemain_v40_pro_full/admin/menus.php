<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../models/Menu.php';
$menuModel = new Menu();
$message = '';
$menu = $menuModel->findBy(['name' => 'principal']);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf()) {
    $items = json_decode($_POST['items'] ?? '[]', true);
    if (!$menu) {
        $menuModel->create(['name' => 'principal', 'items' => json_encode($items)]);
    } else {
        $menuModel->update($menu['id'], ['items' => json_encode($items)]);
    }
    $message = 'Menú actualizado.';
    $menu = $menuModel->findBy(['name' => 'principal']);
}
$items = $menu && $menu['items'] ? json_decode($menu['items'], true) : [];
?>
<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3">Menú principal</h1>
            <p class="text-secondary">Administra enlaces y orden de navegación.</p>
        </div>
    </div>
    <?php if ($message): ?><div class="alert alert-info"><?= htmlspecialchars($message) ?></div><?php endif; ?>
    <form method="post" class="card-glass p-4">
        <?= csrf_input() ?>
        <p class="small text-secondary">Edita el JSON del menú. Ejemplo: <code>[{"label":"Inicio","url":"/public/index.php"}]</code></p>
        <textarea name="items" class="form-control" rows="6"><?= htmlspecialchars(json_encode($items, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)) ?></textarea>
        <div class="text-end mt-3">
            <button class="btn btn-primary">Guardar menú</button>
        </div>
    </form>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
