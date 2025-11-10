<?php
require_once __DIR__ . '/core/bootstrap.php';

$id = (int) ($_GET['id'] ?? 0);
$controller = new ServiceController();
$controller->show($id);
