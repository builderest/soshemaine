<?php
require_once __DIR__ . '/core/bootstrap.php';

$page = ['title' => 'Checkout'];
$content = view('pages/checkout');
echo view('layouts/main', [
    'title' => 'Checkout',
    'page' => $page,
    'content' => $content,
]);
