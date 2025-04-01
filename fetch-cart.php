<?php
session_start(); 
require 'config/connection.php';
header("Content-type:application/json");


if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User is not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];  


$sql = 'select c.*, p.product_name, p.product_image, p.product_price, p.discount from cart as c left join product AS p on c.product_id = p.product_id where c.user_id = ?';

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id); 
$stmt->execute();
$result = $stmt->get_result();

$cart = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($cart, $row);
    }
}


echo json_encode($cart);
exit();
