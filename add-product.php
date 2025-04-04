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
$product_stock = htmlspecialchars($_POST['pstock']);

$sql = 'INSERT INTO product(product_name, product_image, product_price, product_description, product_category,product_avalaible,discount,product_stock) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
$stmp = $conn->prepare($sql);
$stmp->bind_param('ssisisii', $product_name, $product_image, $product_price, $product_description, $product_category, $product_avability, $product_discount, $product_stock);

if ($stmp->execute()) {
    move_uploaded_file($_FILES['pimg']['tmp_name'], "upload-image/" . $_FILES['pimg']['name']);
    echo json_encode(["success" => true, "message" => "Product added successfully"]);
    header("location:/assests/html/product.html");
} else {
    echo json_encode(["success" => false, "message" => "Failed to add product"]);
}
$stmp->close();
header("Content-Type: application/json");
