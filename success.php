<?php

use Dotenv\Dotenv;

require 'config/connection.php';
require_once 'vendor/autoload.php';
require_once 'config.php';
require_once 'error.php';
require '.env';
session_start();

echo "<h1>Payment Successful!</h1>";
echo "<p>Thank you for your purchase.</p>";

$sessionId = $_REQUEST['provider_session_id'];
$stripe = new \Stripe\StripeClient(sk_test);
$session = $stripe->checkout->sessions->retrieve($sessionId);
$paymentid = $session->payment_intent;
$totalAmount = $session->amount_total / 100;
$user_id = $_SESSION['user_id'];


echo '<pre>';
print_r($session);

if (!$user_id) {
    die("Error: User ID is missing.");
}


$sql = 'insert into orders (user_id, total_amount, transaction_timestamp) values (?, ?, NOW())';
$stmt = $conn->prepare($sql);
$stmt->bind_param('id', $user_id, $totalAmount);

if ($stmt->execute()) {
    echo "<p>Order recorded successfully.</p>";
} else {
    die("<p>Error: " . $stmt->error . "</p>");
}

$order_id = $conn->insert_id;
$stmt->close();


$sql = 'select * from cart where user_id = ?';
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


$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$query = 'select o.order_id, o.total_amount, o.user_id, o.status, o.transaction_timestamp,
                 oi.ordered_quantity, oi.product_discount, oi.product_price, oi.product_name
          from orders o
          join orderlist oi ON o.order_id = oi.order_id
          where o.order_id = ?';

$stmt_order = $conn->prepare($query);
$stmt_order->bind_param("i", $order_id);
$stmt_order->execute();
$result = $stmt_order->get_result();

if ($result->num_rows === 0) {
    die("No order found with the given ID.");
}

$order_items = [];
$order_info = null;

while ($row = $result->fetch_assoc()) {
    if (!$order_info) {
        $order_info = $row;
    }
    $order_items[] = $row;
}

$stmt_order->close();


$user_name = $_SESSION['username'];
$sql = 'select email from user where username = ?';
$stmt_email = $conn->prepare($sql);
$stmt_email->bind_param('s', $user_name);
$stmt_email->execute();
$email_result = $stmt_email->get_result();

if ($email_result && $email_result->num_rows > 0) {
    $row = $email_result->fetch_assoc();
    $user_email = $row['email'];
} else {
    die("User email not found.");
}


$order_id = $order_info['order_id'];
$txn_id = $order_info['transaction_timestamp'];
$amount = $order_info['total_amount'];
$order_date = $txn_id ? date("d-m-Y", strtotime($txn_id)) : "N/A";
$transactionId = $session->payment_intent;


$product_rows = "";
foreach ($order_items as $item) {
    $product_rows .= "<tr>
        <td>{$item['product_name']}</td>
        <td>{$item['ordered_quantity']}</td>
        <td>₹{$item['product_price']}</td>
        <td>{$item['product_discount']}</td>
        <td>{$amount}</td>
    </tr>";
}


ob_start();
include 'emailformate.php';
$email_body = ob_get_clean();


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV["sendersemail"];
    $mail->Password = $_ENV["apppassword"];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('specialagent0601@gmail.com', 'you account is now under surveillance of special agency');
    $mail->addAddress($user_email);
    $mail->isHTML(true);
    $mail->AltBody = "Your order #$order_id was placed successfully. Amount: ₹$amount. Transaction ID: $transactionId.";

    $mail->Body = $email_body;
    $mail->send();

    echo "<p>Email sent successfully.</p>";
} catch (Exception $e) {
    echo "<p>Error sending email: {$mail->ErrorInfo}</p>";
}

echo "<p>Order and products saved successfully.</p>";
