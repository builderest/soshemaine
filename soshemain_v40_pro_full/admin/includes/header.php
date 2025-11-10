<?php
require_once __DIR__ . '/../../core/auth.php';
require_once __DIR__ . '/../../core/helpers.php';
require_once __DIR__ . '/../../core/security.php';
require_once __DIR__ . '/../../models/Contact.php';
require_once __DIR__ . '/../../models/Product.php';
require_once __DIR__ . '/../../models/Post.php';
if (!Auth::check()) {
    header('Location: index.php');
    exit;
}
$user = Auth::user();
$metrics = [
    'visits' => site_setting('visits_placeholder', 15230),
    'contacts' => count((new Contact())->all()),
    'products' => count((new Product())->all()),
    'posts' => count((new Post())->all())
];
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel SOSHEMAIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js" defer></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin" defer></script>
    <script src="assets/js/admin.js" defer></script>
</head>
<body class="d-flex">
    <aside class="sidebar d-flex flex-column p-4" style="width: 280px;">
        <div class="d-flex align-items-center gap-2 mb-5">
            <span class="badge bg-primary rounded-pill">SOSHEMAIN</span>
            <span class="fw-semibold">Control Center</span>
        </div>
        <nav class="nav nav-pills flex-column gap-2">
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active' : '' ?>" href="dashboard.php"><i class="bi bi-graph-up"></i> Dashboard</a>
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'pages.php' ? 'active' : '' ?>" href="pages.php"><i class="bi bi-layers"></i> Páginas</a>
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'products.php' ? 'active' : '' ?>" href="products.php"><i class="bi bi-box"></i> Productos</a>
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'categories.php' ? 'active' : '' ?>" href="categories.php"><i class="bi bi-tags"></i> Categorías</a>
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'posts.php' ? 'active' : '' ?>" href="posts.php"><i class="bi bi-journal-text"></i> Blog</a>
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'media.php' ? 'active' : '' ?>" href="media.php"><i class="bi bi-images"></i> Medios</a>
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'contacts.php' ? 'active' : '' ?>" href="contacts.php"><i class="bi bi-inbox"></i> Contactos</a>
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'menus.php' ? 'active' : '' ?>" href="menus.php"><i class="bi bi-menu-button"></i> Menús</a>
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'users.php' ? 'active' : '' ?>" href="users.php"><i class="bi bi-people"></i> Usuarios</a>
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'settings.php' ? 'active' : '' ?>" href="settings.php"><i class="bi bi-gear"></i> Ajustes</a>
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'backups.php' ? 'active' : '' ?>" href="backups.php"><i class="bi bi-hdd-network"></i> Backups</a>
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'maintenance.php' ? 'active' : '' ?>" href="maintenance.php"><i class="bi bi-tools"></i> Mantenimiento</a>
        </nav>
        <div class="mt-auto small text-secondary">
            <p class="mb-2">Conectado como <strong><?= htmlspecialchars($user['name']) ?></strong></p>
            <a href="logout.php" class="btn btn-outline-light btn-sm">Cerrar sesión</a>
        </div>
    </aside>
    <main class="flex-grow-1 p-4">
