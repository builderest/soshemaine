<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/helpers.php';

function cart_items(): array
{
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    return $_SESSION['cart'];
}

function add_to_cart(int $productId, ?int $variantId = null, int $quantity = 1): void
{
    $key = $variantId ? $productId . ':' . $variantId : (string) $productId;
    $cart = cart_items();
    if (!isset($cart[$key])) {
        $cart[$key] = ['product_id' => $productId, 'variant_id' => $variantId, 'quantity' => 0];
    }
    $cart[$key]['quantity'] += max(1, $quantity);
    $_SESSION['cart'] = $cart;
}

function update_cart_item(string $key, int $quantity): void
{
    if ($quantity <= 0) {
        unset($_SESSION['cart'][$key]);
        return;
    }
    if (isset($_SESSION['cart'][$key])) {
        $_SESSION['cart'][$key]['quantity'] = $quantity;
    }
}

function clear_cart(): void
{
    $_SESSION['cart'] = [];
}

function get_product(int $productId): ?array
{
    return run_query_one('SELECT * FROM products WHERE id = ? AND status = "published"', [$productId]);
}

function get_product_variant(int $variantId): ?array
{
    return run_query_one('SELECT * FROM variants WHERE id = ?', [$variantId]);
}

function get_product_price(array $product, ?array $variant = null): float
{
    $price = (float) $product['price'];
    if ($variant && !empty($variant['price_override'])) {
        $price = (float) $variant['price_override'];
    }
    return $price;
}

function calculate_cart_summary(array $cart): array
{
    $items = [];
    $subtotal = 0.0;

    foreach ($cart as $key => $entry) {
        $product = get_product($entry['product_id']);
        if (!$product) {
            continue;
        }
        $variant = $entry['variant_id'] ? get_product_variant($entry['variant_id']) : null;
        $price = get_product_price($product, $variant);
        $lineTotal = $price * $entry['quantity'];
        $items[] = [
            'key' => $key,
            'product' => $product,
            'variant' => $variant,
            'price' => $price,
            'quantity' => $entry['quantity'],
            'total' => $lineTotal,
        ];
        $subtotal += $lineTotal;
    }

    $taxRate = run_query_one('SELECT rate_percent FROM tax_rates WHERE is_default = 1 LIMIT 1');
    $tax = $taxRate ? ($subtotal * ((float) $taxRate['rate_percent'] / 100)) : 0;

    $shippingMethod = run_query_one('SELECT * FROM shipping_methods WHERE status = "active" ORDER BY sort_order IS NULL, sort_order LIMIT 1');
    $shipping = 0;
    if ($shippingMethod) {
        if ($shippingMethod['type'] === 'flat') {
            $shipping = (float) $shippingMethod['cost'];
        } elseif ($shippingMethod['type'] === 'free') {
            $shipping = 0;
        }
    }

    $total = $subtotal + $tax + $shipping;

    return compact('items', 'subtotal', 'tax', 'shipping', 'total');
}

function apply_coupon(string $code, float $subtotal): array
{
    $coupon = run_query_one('SELECT * FROM coupons WHERE code = ? AND status = "active" AND (usage_limit IS NULL OR usage_limit > usage_count) AND (start_at IS NULL OR start_at <= NOW()) AND (end_at IS NULL OR end_at >= NOW())', [$code]);
    if (!$coupon) {
        return ['discount' => 0, 'coupon' => null];
    }
    if ($subtotal < (float) $coupon['min_amount']) {
        return ['discount' => 0, 'coupon' => null];
    }
    $discount = 0;
    if ($coupon['type'] === 'fixed') {
        $discount = min($subtotal, (float) $coupon['value']);
    } elseif ($coupon['type'] === 'percent') {
        $discount = $subtotal * ((float) $coupon['value'] / 100);
    }
    return ['discount' => $discount, 'coupon' => $coupon];
}
