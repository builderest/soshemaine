<?php
require_once __DIR__ . '/core/bootstrap.php';

$page = ['title' => 'Terms'];
$content = view('pages/terms');
echo view('layouts/main', [
    'title' => 'Terms',
    'page' => $page,
    'content' => $content,
]);
