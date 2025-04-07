<?php
require_once 'vendor/autoload.php';
require_once 'config.php';
require_once 'error.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

\Stripe\Stripe::setApiKey($_ENV['stripeskkey']);

header('Content-Type: application/json');

function createstripesession($totalAmount){
    try {
        $checkout_session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'inr',
                    'product_data' => [
                        'name' => 'Shopping Cart Total',
                    ],
                   'unit_amount' => intval(round($totalAmount * 100)),

                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => 'http://myflipkartphp.com/success.php?provider_session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => 'http://myflipkartphp.com/cancel.php',
        ]);
        return ['sessionUrl' => $checkout_session->url, 'totalAmount' => $totalAmount];
    } catch (Exception $e) {
    
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}
