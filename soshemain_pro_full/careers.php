<?php
require_once __DIR__ . '/core/bootstrap.php';

$page = ['title' => 'Careers'];
$content = view('pages/careers');
echo view('layouts/main', [
    'title' => 'Careers',
    'page' => $page,
    'content' => $content,
]);
