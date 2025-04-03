<?php
require_once 'vendor/autoload.php';
require_once 'config.php';

\Stripe\Stripe::setApiKey(sk_test);

header('Content-Type: application/json');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['totalAmount']) && is_numeric($data['totalAmount'])) {
    $totalAmount = $data['totalAmount'] * 100;
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid totalAmount received']);
    exit();
}

try {

    $checkout_session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => 'Shopping Cart Total',
                ],
                'unit_amount' => $totalAmount,
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => 'http://myflipkartphp.com/success.php?provider_session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => 'http://myflipkartphp.com/cancel.php',
    ]);
    echo json_encode(['id' => $checkout_session->id]);
} catch (Exception $e) {

    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
