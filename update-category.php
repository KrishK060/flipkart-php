<?php
session_start();
require 'config/connection.php';
require 'validation.php';
require 'error.php';

$category_id = isset($_POST["category_id"]) ? intval($_POST["category_id"]) : 0;
if ($category_id <= 0) {
    $_SESSION["editcategory_error"] = "Invalid category ID";
    exit;
}

$category_name = isset($_POST["cname"]) ? trim($_POST["cname"]) : '';
if (empty($category_name)) {
    $_SESSION["editcategory_error"] = "category name is required";
    $response["message"] = $_SESSION["editcategory_error"];
    echo json_encode($response);
    exit;
}
if (!preg_match("/^[a-zA-Z0-9-' ]*$/", $category_name)) {
    $_SESSION["editcategory_error"] = "Only letters and white spaces are allowed";
    $response["message"] = $_SESSION["editcategory_error"];
    echo json_encode($response);
    exit;
}

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

echo json_encode($response);
exit;
