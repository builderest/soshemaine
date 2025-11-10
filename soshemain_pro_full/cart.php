<?php
require_once __DIR__ . '/core/bootstrap.php';

$page = ['title' => 'Cart'];
$content = view('pages/cart');
echo view('layouts/main', [
    'title' => 'Cart',
    'page' => $page,
    'content' => $content,
]);
