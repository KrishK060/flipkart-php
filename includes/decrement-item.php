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

$sql = "update product set product_stock = product_stock + 1 where product_id = (select product_id from cart where cart_id=?)";
$stmp = $conn->prepare($sql);
$stmp->bind_param('i', $cart_id);
if ($stmp->execute()) {
    $response = ["success" => true, "message" => "Product stock updated successfully"];
} else {
    $response = ["success" => false, "message" => "Failed to update product stock"];
}
$stmp->close();

$sql = "update cart set quantity = quantity - 1 where cart_id=?";
$stmp = $conn->prepare($sql);
$stmp->bind_param('i', $cart_id);
$stmp->execute();
$sql = "select * from cart where cart_id=?";

$stmp2 = $conn->prepare($sql);
$stmp2->bind_param('i', $cart_id);
$stmp2->execute();
$result = $stmp2->get_result();
$row = $result->fetch_assoc();

if ($row) {
    $response = [
        "success" => true,
        "message" => "Cart quantity updated successfully",
        "cartDetail" => $row
    ];
} else {
    $response = ["success" => false, "message" => "Failed to update cart quantity"];
}
$stmp->close();

echo json_encode($response);
