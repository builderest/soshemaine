<?php
require_once __DIR__ . '/init.php';
$data = [
    'jobs' => $controller->jobs()
];
render_view('careers', $data);
