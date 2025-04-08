<?php
require 'config/connection.php';
require 'validation.php';
require 'error.php';

$response = ["success" => false, "message" => ""];

$product_id = isset($_POST["product_id"]) ? intval($_POST["product_id"]) : 0;
if ($product_id <= 0) {
    $response["message"] = "Invalid product ID";
    $_SESSION["update_error"] = "Invalid product ID";
    echo json_encode($response);
    exit;
}

$product_name = isset($_POST["pname"]) ? trim($_POST["pname"]) : "";
if (empty($product_name)) {
    $response["message"] = "Product name is required";
    $_SESSION["update_error"] = "Product name is required";
    echo json_encode($response);
    exit;
}
if (!preg_match("/^[a-zA-Z0-9-' ]*$/", $product_name)) {
    $response["message"] = "Only letters, numbers, and white spaces are allowed for product name";
    $_SESSION["update_error"] = "Only letters, numbers, and white spaces are allowed for product name";
    echo json_encode($response);
    exit;
}


$product_price = isset($_POST["pprice"]) ? trim($_POST["pprice"]) : "";
if (empty($product_price)) {
    $response["message"] = "Price is required";
    $_SESSION["update_error"] = "Price is required";
    echo json_encode($response);
    exit;
}



$product_description = isset($_POST["ptext"]) ? trim($_POST["ptext"]) : "";
if (empty($product_description)) {
    $response["message"] = "Description is required";
    $_SESSION["update_error"] = "description is required";
    echo json_encode($response);
    exit;
}


$product_category = isset($_POST["pcategory"]) ? trim($_POST["pcategory"]) : "";
if (empty($product_category)) {
    $response["message"] = "Category is required";
    $_SESSION["update_error"] = "category is required";
    echo json_encode($response);
    exit;
}

$product_avability = isset($_POST["avability"]) ? trim($_POST["avability"]) : "";
if (empty($product_avability)) {
    $response["message"] = "Availability status is required";
    $_SESSION["update_error"] = "availability status is required";
    echo json_encode($response);
    exit;
}

$product_discount = isset($_POST["pdiscount"]) ? intval($_POST["pdiscount"]) : 0;
if ($product_discount < 0 || $product_discount > 100) {
    $response["message"] = "Discount must be between 0 and 100";
    $_SESSION["update_error"] = "discount must be between 0 and 100 is required";
    echo json_encode($response);
    exit;
}


$product_stock = isset($_POST["pstock"]) ? intval($_POST["pstock"]) : 0;
if ($product_stock < 0) {
    $response["message"] = "Stock cannot be negative";
    $_SESSION["update_error"] = "stock cannot be negative";
    echo json_encode($response);
    exit;
}


$is_image_uploaded = isset($_FILES["pimg"]) && isset($_FILES["pimg"]["name"]) && !empty($_FILES["pimg"]["name"]);
$product_img = "";

if ($is_image_uploaded) {

    $file_name = basename($_FILES["pimg"]["name"]);
    $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $file_size = $_FILES["pimg"]["size"];
    $upload_dir = "upload-image/";
    $target_file = $upload_dir . $file_name;
    $product_img = uniqid() . "_" . $file_name;
    $target_file = $upload_dir . $product_img;


    if (!move_uploaded_file($_FILES["pimg"]["tmp_name"], $target_file)) {
        $response["message"] = "Failed to upload image";
        $_SESSION["update_error"] = "Failed to upload image";
        echo json_encode($response);
        exit;
    }
}


try {
    if ($is_image_uploaded) {
        $sql = "UPDATE product SET product_name=?, product_image=?,product_price=?,product_description=?, product_category=?, product_avalaible=?, discount=?, product_stock=? WHERE product_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssdsssiis', $product_name,  $product_img, $product_price, $product_description,  $product_category, $product_avability, $product_discount, $product_stock, $product_id);
    } else {
        $sql = "UPDATE product SET product_name=?, product_price=?, product_description=?,  product_category=?,  product_avalaible=?,discount=?, product_stock=? WHERE product_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sdsssiis',$product_name,$product_price,$product_description,$product_category,$product_avability,$product_discount,$product_stock,$product_id
        );
    }

    if ($stmt->execute()) {
        $response = ["success" => true, "message" => "Product updated successfully"];
    } else {
        $response = ["success" => false, "message" => "Failed to update product: " . $stmt->error];
    }

    $stmt->close();
} catch (Exception $e) {
    $response = ["success" => false, "message" => "Error: " . $e->getMessage()];
}

echo json_encode($response);
exit;
