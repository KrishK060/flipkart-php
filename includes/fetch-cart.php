<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/error/error.php';
header("Content-type:application/json");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User is not logged in']);
    exit();
}
$user_id = $_SESSION['user_id'];
$sql = 'select c.*, p.product_name, p.product_image, p.product_price, p.discount from cart as c left join product as p on c.product_id = p.product_id where c.user_id = ?';

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cart = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($cart);
exit();
