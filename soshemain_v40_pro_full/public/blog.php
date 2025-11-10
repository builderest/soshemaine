<?php
require_once __DIR__ . '/init.php';
$data = [
    'posts' => $controller->posts()
];
render_view('blog', $data);
