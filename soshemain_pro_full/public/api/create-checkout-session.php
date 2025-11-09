<?php
require_once __DIR__ . '/../../core/helpers.php';
require_once BASE_PATH . '/core/ecommerce.php';

header('Content-Type: application/json');

$summary = calculate_cart_summary(cart_items());
if (!$summary['items']) {
    echo json_encode(['error' => 'Empty cart']);
    exit;
}

$response = [
    'id' => 'cs_demo_' . bin2hex(random_bytes(6)),
    'amount' => $summary['total'],
];

echo json_encode($response);
