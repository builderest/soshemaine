<?php
require_once __DIR__ . '/init.php';
$slug = $_GET['slug'] ?? '';
$post = $controller->post($slug);
if (!$post) {
    http_response_code(404);
    render_view('errors/404', []);
    exit;
}
render_view('post', ['post' => $post]);
