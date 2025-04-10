<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/error/validation.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/error/error.php';
session_start();
header('Content-Type: application/json');

if (!isset($_POST['product_id']) || !isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Invalid input."]);
    exit;
}
$product_id = $_POST['product_id'];
$user_id = $_SESSION['user_id'];
$sql = "select * from cart where user_id = ? and product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "Product already in cart"]);
    exit;
}
$sql = "insert into cart (user_id, product_id) values (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $user_id, $product_id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Product added to cart successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to add product to cart"]);
}

$stmt->close();
$conn->close();
