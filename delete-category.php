<?php
require 'config/connection.php';
require 'validation.php';
header("Content-Type: application/json");
if (!isset($_POST["category_id"])) {
    echo json_encode(["success" => false, "message" => "category_id is required"]);
    exit();
}
$category_id = intval($_POST["category_id"]);

$sql = "delete from category where category_id =?";
$stmp = $conn->prepare($sql);
$stmp->bind_param('i', $category_id);
if ($stmp->execute()) {
    $response = ["success" => true, "message" => "Category deleted successfully"];
} else {
    $response = ["success" => false, "message" => "Failed to delete category"];
}

echo json_encode($response);
