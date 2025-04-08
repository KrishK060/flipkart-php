<?php
session_start();
require 'config/connection.php';
require 'validation.php';
require 'error.php';

$response = ["success" => false, "message" => ""];

if (empty($_POST["pname"])) {
    $_SESSION["add_error"] = "Product name is required";
    $response["message"] = $_SESSION["add_error"];
    echo json_encode($response);
    exit;
}
$product_name = htmlspecialchars($_POST["pname"]);
if (!preg_match("/^[a-zA-Z-' ]*$/", $product_name)) {
    $_SESSION["add_error"] = "Only letters and white spaces are allowed";
    $response["message"] = $_SESSION["add_error"];
    echo json_encode($response);
    exit;
}

if (empty($_FILES["pimg"]['name'])) {

    $_SESSION["add_error"] = "Image is required";
    $response["message"] = $_SESSION["add_error"];
    echo json_encode($response);
    exit;
}
$product_image = basename($_FILES["pimg"]['name']);

if (empty($_POST["pprice"])) {
    $_SESSION["add_error"] = "Price is required";
    $response["message"] = $_SESSION["add_error"];
    echo json_encode($response);
    exit;
}
$product_price = htmlspecialchars($_POST["pprice"]);

if (empty($_POST["ptext"])) {
    $_SESSION["add_error"] = "Description is required";
    $response["message"] = $_SESSION["add_error"];
    echo json_encode($response);
    exit;
}
$product_description = htmlspecialchars($_POST["ptext"]);

if (empty($_POST["pcategory"])) {
    $_SESSION["add_error"] = "Category is required";
    $response["message"] = $_SESSION["add_error"];
    echo json_encode($response);
    exit;
}
$product_category = htmlspecialchars($_POST["pcategory"]);

if (empty($_POST["avability"])) {
    $_SESSION["add_error"] = "Please select the availability of the product";
    $response["message"] = $_SESSION["add_error"];
    echo json_encode($response);
    exit;
}
$product_avability = htmlspecialchars($_POST["avability"]);

if (empty($_POST["pdiscount"])) {
    $_SESSION["add_error"] = "Discount is required";
    $response["message"] = $_SESSION["add_error"];
    echo json_encode($response);
    exit;
}
$product_discount = htmlspecialchars($_POST["pdiscount"]);

if (empty($_POST["pstock"])) {
    $_SESSION["add_error"] = "Please enter the stock";
    $response["message"] = $_SESSION["add_error"];
    echo json_encode($response);
    exit;
}
$product_stock = htmlspecialchars($_POST["pstock"]);

$image_ext = pathinfo($_FILES["pimg"]["name"], PATHINFO_EXTENSION);
$product_image = pathinfo($product_image, PATHINFO_FILENAME) . '_' . time() . '_' . uniqid() . '.' . $image_ext;

$sql = 'INSERT INTO product(product_name, product_image, product_price, product_description, product_category, product_avalaible, discount, product_stock) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
$stmp = $conn->prepare($sql);
$stmp->bind_param('ssisisii', $product_name, $product_image, $product_price, $product_description, $product_category, $product_avability, $product_discount, $product_stock);

if ($stmp->execute()) {
    $upload_path = "upload-image/" . $product_image;
    move_uploaded_file($_FILES['pimg']['tmp_name'], $upload_path);
    $_SESSION["add_success"] = "Product added successfully";
    echo json_encode(["success" => true, "message" => "Product added successfully"]);
    exit;
} else {
    $_SESSION["add_error"] = "Failed to add product";
    echo json_encode(["success" => false, "message" => $_SESSION["add_error"]]);
    exit;
}

$stmp->close();
