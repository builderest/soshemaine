<?php
require_once __DIR__ . '/core/bootstrap.php';

$slug = $_GET['slug'] ?? '';
if (!$slug) {
    (new PageController())->render404();
    return;
}

$controller = new PortfolioController();
$controller->show($slug);
