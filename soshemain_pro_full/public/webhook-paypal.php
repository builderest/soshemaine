<?php
require_once __DIR__ . '/../core/helpers.php';
require_once BASE_PATH . '/core/db.php';

if (file_exists(BASE_PATH . '/vendor/autoload.php')) {
    require_once BASE_PATH . '/vendor/autoload.php';
}

$payload = file_get_contents('php://input');
$data = json_decode($payload, true);
$eventType = $data['event_type'] ?? '';

if ($eventType === 'PAYMENT.CAPTURE.COMPLETED') {
    $orderId = $data['resource']['supplementary_data']['related_ids']['order_id'] ?? null;
    execute_query('UPDATE orders SET status = "paid" WHERE payment_reference = ?', [$orderId]);
}

audit_log('paypal_webhook', $eventType, $payload);

echo json_encode(['ack' => 'ok']);
