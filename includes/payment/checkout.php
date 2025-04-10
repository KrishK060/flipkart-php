<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/error/validation.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/error/error.php';
require('process-payment.php');


header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

$totalAmount = isset($data['totalAmount']) ? floatval($data['totalAmount']) : null;

if (!$totalAmount || $totalAmount <= 0) {
    echo json_encode(["error" => "Invalid totalAmount received"]);
    exit;
}

$response = createstripesession($totalAmount);

if ($response) {
    echo json_encode(["url" => $response['sessionUrl']]);
} else {
    echo json_encode(["error" => "Failed to create Stripe session"]);
}
