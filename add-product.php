<?php
require 'config/connection.php';
require 'validation.php';
require 'error.php';

$product_name = htmlspecialchars($_POST["pname"]);
$product_image = basename($_FILES["pimg"]['name']);
$product_price = htmlspecialchars($_POST["pprice"]);
$product_description = htmlspecialchars($_POST["ptext"]);
$product_category = htmlspecialchars($_POST["pcategory"]);
$product_avability = htmlspecialchars($_POST["avability"]);
$product_discount = htmlspecialchars($_POST["pdiscount"]);
$product_stock = htmlspecialchars($_POST["pstock"]);

$image_ext = pathinfo($_FILES["pimg"]["name"], PATHINFO_EXTENSION);
$product_image = $product_image . '_' . time() . '_' . uniqid() . '.' . $image_ext;

$sql = 'INSERT INTO product(product_name, product_image, product_price, product_description, product_category, product_avalaible, discount, product_stock) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
$stmp = $conn->prepare($sql);
$stmp->bind_param('ssisisii', $product_name, $product_image, $product_price, $product_description, $product_category, $product_avability, $product_discount, $product_stock);

if ($stmp->execute()) {
    $upload_path = "upload-image/" . $product_image;
    move_uploaded_file($_FILES['pimg']['tmp_name'], $upload_path);

    echo json_encode(["success" => true, "message" => "Product added successfully"]);
    header("location:/assests/html/product.php");
} else {
    echo json_encode(["success" => false, "message" => "Failed to add product"]);
}

$stmp->close();
header("Content-Type: application/json");
