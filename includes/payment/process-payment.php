<?php
require_once '../../vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/error/validation.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/error/error.php';


$dotenv = Dotenv\Dotenv::createImmutable('../../');
$dotenv->load();

\Stripe\Stripe::setApiKey($_ENV['stripeskkey']);

header('Content-Type: application/json');

function createstripesession($totalAmount)
{
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
            'success_url' => 'http://myflipkartphp.com/success?provider_session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => 'http://myflipkartphp.com/cancel',
        ]);
        return ['sessionUrl' => $checkout_session->url, 'totalAmount' => $totalAmount];
    } catch (Exception $e) {

        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}
