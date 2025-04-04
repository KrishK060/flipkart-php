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
print_r($session );

if (!$user_id) {
    die("Error: User ID is missing.");
}


$sql = 'INSERT INTO orders (user_id, total_amount, transaction_timestamp) VALUES (?, ?, NOW())';
$stmt = $conn->prepare($sql);
$stmt->bind_param('id', $user_id, $totalAmount);

if ($stmt->execute()) {
    echo "<p>Order recorded successfully.</p>";
} else {
    die("<p>Error: " . $stmt->error . "</p>");
}

$order_id = $conn->insert_id;
$stmt->close();


$sql = 'SELECT * FROM cart WHERE user_id = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();


$insert_orderlist = 'INSERT INTO orderlist (order_id, product_id, ordered_quantity, product_name, product_price, product_discount) VALUES (?, ?, ?, ?, ?, ?)';
$orderlist_stmt = $conn->prepare($insert_orderlist);

foreach ($products as $product) {
    $product_id = $product['product_id'];
    $ordered_quantity = $product['quantity'];

    $sql = 'SELECT product_name, product_price, discount FROM product WHERE product_id = ?';
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


$sql = "DELETE FROM cart WHERE user_id = ?";
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
$dotenv->load();
$query = 'SELECT o.order_id, o.total_amount, o.user_id, o.status, o.transaction_timestamp,
                 oi.ordered_quantity, oi.product_discount, oi.product_price, oi.product_name
          FROM orders o
          JOIN orderlist oi ON o.order_id = oi.order_id
          WHERE o.order_id = ?';

$stmt_order = $conn->prepare($query);
$stmt_order->bind_param("i", $order_id);
$stmt_order->execute();
$result = $stmt_order->get_result();

// $username = $_SESSION['username'];
// $sql = 'select email from user where $username=?';
// $stmt_email = $conn->prepare($sql);
// $stmt_email->bind_param('s',$username);
// $stmt_email->execute();
// $email_result = $stmt_email->get_result();
$username = $_SESSION['username'];
$sql = 'SELECT email FROM user WHERE username = ?';
$stmt_email = $conn->prepare($sql);
$stmt_email->bind_param('s', $username);
$stmt_email->execute();
$email_result = $stmt_email->get_result();

if ($email_result && $email_result->num_rows > 0) {
    $row = $email_result->fetch_assoc();
    $user_email = $row['email'];
} else {
    die("User email not found.");
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

$transaction_id =  $session->payment_intent;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'specialagent0601@gmail.com';
    $mail->Password = $_ENV["apppassword"];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // $mail->setFrom('specialagent0601@gmail.com', 'Special Agent');
    // $mail->addAddress($user_email);

    // $mail->isHTML(true);
    // $mail->Subject = '🧾 Order Confirmation - Order #' . $order_info['order_id'];
    $mail->setFrom('specialagent0601@gmail.com', 'you account is now under surveillance of special agency');
    $mail->addAddress($user_email);
    $mail->isHTML(true);
    $mail->AltBody = "Your order #$order_id was placed successfully. Amount: ₹$amount. Transaction ID: $transactionId.";
    
    $product_rows = "";
    foreach ($order_items as $item) {
        $product_rows .= "<tr>
            <td>{$item['product_name']}</td>
            <td>{$item['ordered_quantity']}</td>
            <td>₹{$item['product_price']}</td>
        </tr>";
    }

    $username = $user_name;
    $order_id = $order_info['order_id'];
    $txn_id = $order_info['transaction_timestamp'];
    $amount = $order_info['total_amount'];
    $order_date = date("d-m-Y", strtotime($txn_id));
    $transactionId = $paymentid;

    $mail->Body = "
    <html>
    <head>
      <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        .container { background: #fff; padding: 20px; border-radius: 8px; }
        h2 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #007bff; color: white; }
        .footer { margin-top: 30px; font-size: 14px; color: #888; text-align: center; }
      </style>
    </head>
    <body>
      <div class='container'>
        <h2>Hello $username,</h2>
        <p>Thank you for your order! Here are your details:</p>
        <p><strong>Order ID:</strong> $order_id</p>
        <p><strong>Transaction Date:</strong> $order_date</p>
        <p><strong>Amount Paid:</strong> ₹$amount</p>
        <p><strong>TransactionID:</strong>$transactionId</p>
        <table>
          <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
          </tr>
          $product_rows
        </table>

        <div class='footer'>
          <p>Need help? Email us at support@specialagency.com</p>
          <p>&copy; " . date("Y") . " special agency</p>
        </div>
      </div>
    </body>
    </html>";

    $mail->send();
    echo "<p>Email sent successfully.</p>";
} catch (Exception $e) {
    echo "<p>Error sending email: {$mail->ErrorInfo}</p>";
}

echo "<p>Order and products saved successfully.</p>";
