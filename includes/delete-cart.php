<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/error/validation.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/error/error.php';
header("Content-Type: application/json");

if (!isset($_POST["cart_id"])) {
    echo json_encode(["success" => false, "message" => "cart_id is required"]);
    exit();
}

$cart_id = intval($_POST["cart_id"]);

$sql = "delete from cart where cart_id = ?";
$stmp = $conn->prepare($sql);
$stmp->bind_param('i', $cart_id);

if ($stmp->execute()) {
    $response = ["success" => true, "message" => "Cart deleted successfully"];
} else {
    $response = ["success" => false, "message" => "Failed to delete cart"];
}

$stmp->close();

echo json_encode($response);
