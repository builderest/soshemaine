<?php
require_once __DIR__ . '/core/bootstrap.php';

$slug = $_GET['slug'] ?? '';
$controller = new BlogController();
$controller->show($slug);
