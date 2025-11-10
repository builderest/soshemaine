<?php
require_once __DIR__ . '/core/bootstrap.php';

$page = ['title' => 'Privacy policy'];
$content = view('pages/privacy');
echo view('layouts/main', [
    'title' => 'Privacy policy',
    'page' => $page,
    'content' => $content,
]);
