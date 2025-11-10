<?php
require_once __DIR__ . '/core/bootstrap.php';

$page = ['title' => 'Contact'];
$content = view('pages/contact', ['settings' => $GLOBALS['settings'] ?? []]);
echo view('layouts/main', [
    'title' => 'Contact',
    'page' => $page,
    'content' => $content,
]);
