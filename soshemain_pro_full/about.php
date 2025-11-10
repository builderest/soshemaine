<?php
require_once __DIR__ . '/core/bootstrap.php';

$controller = new PageController();
$controller->show('about');
