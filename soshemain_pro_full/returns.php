<?php
require_once __DIR__ . '/core/bootstrap.php';

$page = ['title' => 'Returns'];
$content = view('pages/returns');
echo view('layouts/main', [
    'title' => 'Returns',
    'page' => $page,
    'content' => $content,
]);
