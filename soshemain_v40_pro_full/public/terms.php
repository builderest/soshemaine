<?php
require_once __DIR__ . '/init.php';
$data = [
    'terms' => $controller->page('terminos')
];
render_view('terms', $data);
