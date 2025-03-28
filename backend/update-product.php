<?php
require './db/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = isset($_POST["product_id"]) ? intval($_POST["product_id"]) : 0;
    $product_name = isset($_POST["pname"]) ? trim($_POST["pname"]) : "";
    $product_img = isset($_FILES["pimg"]['name']) ? trim($_FILES["pimg"]['name']) : "";
    $product_price = isset($_POST["pprice"]) ? trim($_POST["pprice"]) : "";
    $product_description = isset($_POST["ptext"]) ? trim($_POST["ptext"]) : "";
    $product_category = isset($_POST["category"]) ? trim($_POST["category"]) : "";


    if ($product_id > 0 && !empty($product_name)) {
        $sql = "UPDATE product SET product_name=?,product_image=?,product_price=?, product_description=?, product_category=? WHERE product_id=?";
        $stmp = $conn->prepare($sql);
        $stmp->bind_param('ssisii', $product_name, $product_img, $product_price, $product_description, $product_category,$product_id );

        if ($stmp->execute()) {
            move_uploaded_file($_FILES['pimg']['tmp_name'], "/home/krish.kalaria@simform.dom/Desktop/LMS-2/Flipkart-php/flipkart-php/frontend/" . $_FILES['pimg']['name']);
            $response = ["success" => true, "message" => "Product updated successfully"];
        } else {
            $response = ["success" => false, "message" => "Failed to update product"];
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
