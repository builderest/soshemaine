<?php
require_once __DIR__ . '/core/bootstrap.php';

$page = ['title' => 'Account'];
$content = view('pages/account');
echo view('layouts/main', [
    'title' => 'Account',
    'page' => $page,
    'content' => $content,
]);
