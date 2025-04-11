<?php
require 'config/connection.php';
require 'validation.php';
header("Content-Type: application/json");

if (!isset($_POST["product_id"])) {
    echo json_encode(["success" => false, "message" => "product_id is required"]);
    exit();
}
$product_id = intval($_POST["product_id"]);

$sql = "delete from product where product_id =?";
$stmp = $conn->prepare($sql);
$stmp->bind_param('i', $product_id);

if ($stmp->execute()) {
    $response = ["success" => true, "message" => "product deleted successfully"];
} else {
    $response = ["success" => false, "message" => "Failed to delete product"];
}
$stmp->close();


echo json_encode($response);
