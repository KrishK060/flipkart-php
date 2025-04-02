<?php
require 'config/connection.php';
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_id = isset($_POST["category_id"]) ? intval($_POST["category_id"]) : 0;
    $category_name = isset($_POST["cname"]) ? trim($_POST["cname"]) : '';

    if ($category_id > 0 && !empty($category_name)) {
        $sql = "update category set category_name=? where category_id=?";
        $stmp = $conn->prepare($sql);
        $stmp->bind_param('si', $category_name, $category_id);

        if ($stmp->execute()) {
            $response = ["success" => true, "message" => "Category updated successfully"];
        } else {
            $response = ["success" => false, "message" => "Failed to update category"];
        }
        $stmp->close();
    } else {
        $response = ["success" => false, "message" => "Invalid input"];
    }
} else {
    $response = ["success" => false, "message" => "Invalid request"];
}
echo json_encode($response);
exit;
