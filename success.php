<?php
require 'config/connection.php';
require_once 'vendor/autoload.php';
require_once 'config.php';
require_once 'error.php';
session_start();
echo "<h1>Payment Successful!</h1>";
echo "<p>Thank you for your purchase.</p>";

$sessionId = $_REQUEST['provider_session_id'];
$stripe = new \Stripe\StripeClient(sk_test);

$session = $stripe->checkout->sessions->retrieve($sessionId);
$paymentid = $session->payment_intent;

$totalAmount = $session->amount_total / 100;
$user_id = $_SESSION['user_id'];
if (!$user_id) {
    die("Error: User ID is missing.");
}

$sql = 'insert into orders (user_id, total_amount) values (?, ?)';
$stmt = $conn->prepare($sql);
$stmt->bind_param('id', $user_id, $totalAmount);

if ($stmt->execute()) {
    echo "<p>Order recorded successfully.</p>";
} else {
    die("<p>Error: " . $stmt->error . "</p>");
}

$order_id = $conn->insert_id;
$stmt->close();

$sql = 'select * from cart where user_id=?';

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$insert_orderlist = 'insert into orderlist (order_id, product_id, ordered_quantity, product_name, product_price, product_discount) values (?, ?, ?, ?, ?, ?)';
$orderlist_stmt = $conn->prepare($insert_orderlist);

foreach ($products as $product) {
    $product_id = $product['product_id'];
    $ordered_quantity = $product['quantity'];

    $sql = 'select product_name, product_price, discount from product where product_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $stmt->bind_result($product_name, $product_price, $discount);
    $stmt->fetch();
    $stmt->close();

    $orderlist_stmt->bind_param('iiisii', $order_id, $product_id, $ordered_quantity, $product_name, $product_price, $discount);
    $orderlist_stmt->execute();
}

$orderlist_stmt->close();

$sql = "delete from cart where user_id = ?";
$stmp = $conn->prepare($sql);
$stmp->bind_param('i', $user_id);

if ($stmp->execute()) {
    $response = ["success" => true, "message" => "Cart deleted successfully"];
} else {
    $response = ["success" => false, "message" => "Failed to delete cart"];
}

$stmp->close();

echo "<p>Order and products saved successfully.</p>";
