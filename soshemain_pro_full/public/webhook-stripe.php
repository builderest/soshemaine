<?php
require_once __DIR__ . '/../core/helpers.php';
require_once BASE_PATH . '/core/db.php';

if (file_exists(BASE_PATH . '/vendor/autoload.php')) {
    require_once BASE_PATH . '/vendor/autoload.php';
}

$payload = @file_get_contents('php://input');
$sigHeader = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';
$event = null;

try {
    if (class_exists('Stripe\\Webhook')) {
        $event = Stripe\Webhook::constructEvent($payload, $sigHeader, STRIPE_WEBHOOK_SECRET);
    } else {
        $event = json_decode($payload, true);
    }
} catch (Exception $e) {
    http_response_code(400);
    exit('Invalid payload');
}

$type = $event['type'] ?? ($event['type'] ?? '');
if ($type === 'checkout.session.completed') {
    $session = $event['data']['object'];
    execute_query('UPDATE orders SET status = "paid" WHERE payment_reference = ?', [$session['id'] ?? null]);
}

audit_log('stripe_webhook', $type, $payload);

echo json_encode(['received' => true]);
