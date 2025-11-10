<?php
require_once __DIR__ . '/init.php';
$data = [
    'products' => $controller->products(),
    'categories' => $controller->services()
];
render_view('products', $data);
