<?php
require_once __DIR__ . '/init.php';
$data = [
    'services' => $controller->services()
];
render_view('services', $data);
