<?php
require 'config/connection.php';
require 'validation.php';
require 'error.php';

$product_id = isset($_POST["product_id"]) ? intval($_POST["product_id"]) : 0;
$product_name = isset($_POST["pname"]) ? trim($_POST["pname"]) : "";
$product_img = isset($_FILES["pimg"]['name']) ? trim($_FILES["pimg"]['name']) : "";
$product_price = isset($_POST["pprice"]) ? trim($_POST["pprice"]) : "";
$product_description = isset($_POST["ptext"]) ? trim($_POST["ptext"]) : "";
$product_category = isset($_POST["pcategory"]) ? trim($_POST["pcategory"]) : "";
$product_avability = isset($_POST["avability"]) ? trim($_POST["avability"]) : "";
$product_discount = isset($_POST["pdiscount"]) ? intval($_POST["pdiscount"]) : 0;
$product_stock = isset($_POST["pstock"]) ? intval($_POST["pstock"]) : 0;

if ($product_id > 0 && !empty($product_name)) {
    if (!empty($product_img)) {

        $upload_dir = "/home/krish.kalaria@simform.dom/Desktop/LMS-2/Flipkart-php/flipkart-php/upload-image/";
        $target_file = $upload_dir . basename($product_img);
        move_uploaded_file($_FILES['pimg']['tmp_name'], $target_file);
        $sql = "update product set product_name=?, product_image=?, product_price=?, product_description=?, product_category=?, product_avalaible=?, discount=?, product_stock=? where product_id=?";

        $stmp = $conn->prepare($sql);
        $stmp->bind_param('ssisisiii', $product_name, $product_img, $product_price, $product_description, $product_category, $product_avability, $product_discount, $product_stock, $product_id);
    } else {

        $sql = "update product set product_name=?, product_price=?, product_description=?, product_category=?, product_avalaible=?, discount=? ,product_stock=? where product_id=?";
        $stmp = $conn->prepare($sql);
        $stmp->bind_param('sisisiii', $product_name, $product_price, $product_description, $product_category, $product_avability, $product_discount, $product_stock, $product_id);
    }

    if ($stmp->execute()) {
        $response = ["success" => true, "message" => "Product updated successfully"];
    } else {
        $response = ["success" => false, "message" => "Failed to update product"];
    }

    $stmp->close();
} else {
    $response = ["success" => false, "message" => "Invalid input"];
}


echo json_encode($response);
exit;
