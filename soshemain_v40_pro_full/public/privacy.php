<?php
require_once __DIR__ . '/init.php';
$data = [
    'privacy' => $controller->page('privacidad')
];
render_view('privacy', $data);
