<?php
require 'config/connection.php';
require 'validation.php';
require 'error.php';


if (empty($_POST["pname"])) {
    $response["message"] = "product name is required";
    echo json_encode($response);
    exit;
}
$product_name = htmlspecialchars($_POST["pname"]);
if (!preg_match("/^[a-zA-Z-' ]*$/", $product_name)) {
    $response["message"] = "Only letters and white spaces are allowed";
    echo json_encode($response);
    exit;
}

if (empty($_FILES["pimg"]['name'])) {
    $response["message"] = "image is required";
    echo json_encode($response);
    exit;
}
$product_image = basename($_FILES["pimg"]['name']);

if (empty($_POST["pprice"])) {
    $response["message"] = "price is required";
    echo json_encode($response);
    exit;
}
$product_price = htmlspecialchars($_POST["pprice"]);

if (empty($_POST["ptext"])) {
    $response["message"] = "discription is required";
    echo json_encode($response);
    exit;
}
$product_description = htmlspecialchars($_POST["ptext"]);

if (empty($_POST["pcategory"])) {
    $response["message"] = "category is required";
    echo json_encode($response);
    exit;
}
$product_category = htmlspecialchars($_POST["pcategory"]);

if (empty($_POST["avability"])) {
    $response["message"] = "please select the avability of the product is required";
    echo json_encode($response);
    exit;
}
$product_avability = htmlspecialchars($_POST["avability"]);

if (empty($_POST["pdiscount"])) {
    $response["message"] = "discount is required";
    echo json_encode($response);
    exit;
}
$product_discount = htmlspecialchars($_POST["pdiscount"]);

if (empty($_POST["pstock"])) {
    $response["message"] = "please enter the stock";
    echo json_encode($response);
    exit;
}
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
