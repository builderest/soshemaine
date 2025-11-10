<?php
require_once __DIR__ . '/init.php';
$slug = $_GET['slug'] ?? '';
$page = $controller->page($slug);
if (!$page || ($page['status'] ?? 'published') !== 'published') {
    http_response_code(404);
    render_view('errors/404', []);
    exit;
}
render_view('generic-page', ['page' => $page]);
