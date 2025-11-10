<?php
require_once __DIR__ . '/init.php';
$data = $controller->home();
render_view('home', $data);
