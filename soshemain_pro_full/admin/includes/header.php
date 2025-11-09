<?php
require_once __DIR__ . '/../../core/helpers.php';
require_once BASE_PATH . '/core/auth.php';
require_admin();
$user = current_user();
?><!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title ?? 'Admin — SOSHEMAIN') ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/admin/assets/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body border-bottom sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="/admin/dashboard.php">SOSHEMAIN Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav" aria-controls="adminNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="adminNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="/admin/dashboard.php">Dashboard</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Content</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/admin/pages.php">Pages</a></li>
                        <li><a class="dropdown-item" href="/admin/posts.php">Posts</a></li>
                        <li><a class="dropdown-item" href="/admin/media.php">Media</a></li>
                        <li><a class="dropdown-item" href="/admin/contacts.php">Contacts</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Commerce</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/admin/products.php">Products</a></li>
                        <li><a class="dropdown-item" href="/admin/variants.php">Variants</a></li>
                        <li><a class="dropdown-item" href="/admin/categories.php">Categories</a></li>
                        <li><a class="dropdown-item" href="/admin/orders.php">Orders</a></li>
                        <li><a class="dropdown-item" href="/admin/customers.php">Customers</a></li>
                        <li><a class="dropdown-item" href="/admin/inventory.php">Inventory</a></li>
                        <li><a class="dropdown-item" href="/admin/coupons.php">Coupons</a></li>
                        <li><a class="dropdown-item" href="/admin/taxes.php">Taxes</a></li>
                        <li><a class="dropdown-item" href="/admin/shipping.php">Shipping</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">System</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/admin/users.php">Users</a></li>
                        <li><a class="dropdown-item" href="/admin/roles.php">Roles</a></li>
                        <li><a class="dropdown-item" href="/admin/settings.php">Settings</a></li>
                        <li><a class="dropdown-item" href="/admin/backups.php">Backups</a></li>
                        <li><a class="dropdown-item" href="/admin/maintenance.php">Maintenance</a></li>
                    </ul>
                </li>
            </ul>
            <div class="d-flex align-items-center gap-3">
                <span class="text-secondary small"><?= e($user['name'] ?? $user['email'] ?? 'Administrator') ?></span>
                <a class="btn btn-sm btn-outline-danger" href="/admin/logout.php">Logout</a>
            </div>
        </div>
    </div>
</nav>
<main class="container-fluid py-4">
