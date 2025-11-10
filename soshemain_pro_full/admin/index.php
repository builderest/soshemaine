<?php
require_once __DIR__ . '/../core/bootstrap.php';
Auth::requireAuth();

$view = $_GET['view'] ?? 'dashboard';
$title = 'Dashboard';
$data = [];

switch ($view) {
    case 'pages':
        $title = 'Pages';
        $controller = new PageManagerController();
        if (is_post() && Csrf::verify()) {
            if (isset($_POST['delete'])) {
                $controller->remove((int) $_POST['delete']);
                flash('admin_success', 'Page removed.');
            } else {
                $payload = $_POST;
                $payload['hero'] = json_decode($_POST['hero_json'] ?? '[]', true) ?? [];
                $payload['sections'] = json_decode($_POST['sections_json'] ?? '[]', true) ?? [];
                $payload['seo'] = json_decode($_POST['seo_json'] ?? '[]', true) ?? [];
                $controller->save($payload);
                flash('admin_success', 'Page saved.');
            }
            redirect('admin/index.php?view=pages');
        }
        $data['items'] = $controller->all();
        break;
    case 'posts':
        $title = 'Posts';
        $controller = new PostManagerController();
        if (is_post() && Csrf::verify()) {
            if (isset($_POST['delete'])) {
                $controller->remove((int) $_POST['delete']);
                flash('admin_success', 'Post removed.');
            } else {
                $payload = $_POST;
                $payload['meta'] = json_decode($_POST['meta_json'] ?? '[]', true) ?? [];
                $controller->save($payload);
                flash('admin_success', 'Post saved.');
            }
            redirect('admin/index.php?view=posts');
        }
        $data['items'] = $controller->all();
        break;
    case 'services':
        $title = 'Services';
        $controller = new ServiceManagerController();
        if (is_post() && Csrf::verify()) {
            if (isset($_POST['delete'])) {
                $controller->remove((int) $_POST['delete']);
                flash('admin_success', 'Service removed.');
            } else {
                $controller->save($_POST);
                flash('admin_success', 'Service saved.');
            }
            redirect('admin/index.php?view=services');
        }
        $data['items'] = $controller->all();
        break;
    case 'products':
        $title = 'Products';
        $controller = new ProductManagerController();
        if (is_post() && Csrf::verify()) {
            if (isset($_POST['delete'])) {
                $controller->remove((int) $_POST['delete']);
                flash('admin_success', 'Product removed.');
            } else {
                $payload = $_POST;
                $payload['gallery'] = json_decode($_POST['gallery_json'] ?? '[]', true) ?? [];
                $payload['variants'] = json_decode($_POST['variants_json'] ?? '[]', true) ?? [];
                $controller->save($payload);
                flash('admin_success', 'Product saved.');
            }
            redirect('admin/index.php?view=products');
        }
        $data['items'] = $controller->all();
        break;
    case 'menus':
        $title = 'Menus';
        $controller = new MenuManagerController();
        if (is_post() && Csrf::verify()) {
            if (isset($_POST['delete'])) {
                $controller->remove((int) $_POST['delete']);
                flash('admin_success', 'Menu removed.');
            } else {
                $controller->save($_POST);
                flash('admin_success', 'Menu saved.');
            }
            redirect('admin/index.php?view=menus');
        }
        $data['items'] = $controller->all();
        break;
    case 'settings':
        $title = 'Settings';
        $controller = new SettingController();
        if (is_post() && Csrf::verify()) {
            $controller->update([
                'company_name' => $_POST['company_name'] ?? '',
                'company_email' => $_POST['company_email'] ?? '',
                'company_phone' => $_POST['company_phone'] ?? '',
                'company_address' => $_POST['company_address'] ?? '',
                'theme_default' => $_POST['theme_default'] ?? Theme::getDefault(),
                'brand_colors' => $_POST['brand_colors'] ?? '',
                'font_primary' => $_POST['font_primary'] ?? '',
                'meta_description' => $_POST['meta_description'] ?? '',
                'social_links' => $_POST['social_links'] ?? '[]',
            ]);
            flash('admin_success', 'Settings updated.');
            redirect('admin/index.php?view=settings');
        }
        $data['settings'] = $GLOBALS['settings'];
        $data['themes'] = Theme::available();
        break;
    case 'media':
        $title = 'Media Library';
        $controller = new MediaManagerController();
        if (is_post() && Csrf::verify()) {
            $uploaded = $controller->handleUpload($_FILES['media'] ?? [], $_POST['alt'] ?? '');
            if ($uploaded) {
                flash('admin_success', 'Media uploaded.');
            } else {
                flash('admin_error', 'Upload failed. Ensure the file is a supported image under 5MB.');
            }
            redirect('admin/index.php?view=media');
        }
        $data['items'] = $controller->all();
        break;
    case 'contacts':
        $title = 'Contacts';
        $model = new ContactModel();
        $data['items'] = $model->all();
        break;
    default:
        $title = 'Dashboard';
        $controller = new DashboardController();
        $data = $controller->index();
        break;
}

$success = flash('admin_success');
$error = flash('admin_error');
$user = Auth::user();
?><!DOCTYPE html>
<html lang="en" data-theme="<?php echo e($GLOBALS['settings']['theme_default'] ?? 'light'); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e($title); ?> &mdash; Admin | <?php echo e(APP_NAME); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/tokens.css">
    <link rel="stylesheet" href="../css/site.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js" defer></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>document.addEventListener('DOMContentLoaded', () => { if (document.querySelector('.tinymce-editor')) { tinymce.init({ selector:'.tinymce-editor', height:300 }); }});</script>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom">
    <div class="container-fluid">
        <a class="navbar-brand fw-semibold" href="index.php"><?php echo e(APP_NAME); ?> Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="adminNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link<?php echo $view === 'dashboard' ? ' active' : ''; ?>" href="index.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link<?php echo $view === 'pages' ? ' active' : ''; ?>" href="?view=pages">Pages</a></li>
                <li class="nav-item"><a class="nav-link<?php echo $view === 'posts' ? ' active' : ''; ?>" href="?view=posts">Posts</a></li>
                <li class="nav-item"><a class="nav-link<?php echo $view === 'services' ? ' active' : ''; ?>" href="?view=services">Services</a></li>
                <li class="nav-item"><a class="nav-link<?php echo $view === 'products' ? ' active' : ''; ?>" href="?view=products">Products</a></li>
                <li class="nav-item"><a class="nav-link<?php echo $view === 'menus' ? ' active' : ''; ?>" href="?view=menus">Menus</a></li>
                <li class="nav-item"><a class="nav-link<?php echo $view === 'media' ? ' active' : ''; ?>" href="?view=media">Media</a></li>
                <li class="nav-item"><a class="nav-link<?php echo $view === 'contacts' ? ' active' : ''; ?>" href="?view=contacts">Contacts</a></li>
                <li class="nav-item"><a class="nav-link<?php echo $view === 'settings' ? ' active' : ''; ?>" href="?view=settings">Settings</a></li>
            </ul>
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted small"><i class="bi bi-person-circle me-1"></i><?php echo e($user['name'] ?? $user['email'] ?? 'Admin'); ?></span>
                <a href="logout.php" class="btn btn-sm btn-outline-danger">Sign out</a>
            </div>
        </div>
    </div>
</nav>
<main class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-3"><?php echo e($title); ?></h1>
            <?php if ($success): ?><div class="alert alert-success"><?php echo e($success); ?></div><?php endif; ?>
            <?php if ($error): ?><div class="alert alert-danger"><?php echo e($error); ?></div><?php endif; ?>
            <?php include __DIR__ . '/partials/' . $view . '.php'; ?>
        </div>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/admin.js"></script>
</body>
</html>
