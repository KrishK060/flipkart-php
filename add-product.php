<?php
session_start();
require 'config/connection.php';
require 'validation.php';
require 'error.php';

$error = [];

if (empty($_POST["pname"])) {
    $error["name_error"] = "Product name is required";
} else {
    $product_name = htmlspecialchars($_POST["pname"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/", $product_name)) {
        $error["name_error"] = "letters and white spaces aren't allowed";
    }
}

if (empty($_FILES["pimg"]['name'])) {
    $error["image_error"] = "Image is required";
} else {
    $product_image = basename($_FILES["pimg"]['name']);
}

if (empty($_POST["pprice"])) {
    $error["price_error"] = "Price is required";
} else {
    $product_price = htmlspecialchars($_POST["pprice"]);
    if ($product_price < 0) {
        $error["price_error"] = "Price cant be negative";
    }
}

if (empty($_POST["pdiscount"])) {
    $error["discount_error"] = "Discount is required";
} else {
    $product_discount = htmlspecialchars($_POST["pdiscount"]);
    if ($product_discount < 0 || $product_discount > 100) {
        $error["price_error"] = "discount cant be negative or greater than 100%";
    }
}

if (empty($_POST["ptext"])) {
    $error["desc_error"] = "Description is required";
} else {
    $product_description = htmlspecialchars($_POST["ptext"]);
}

if (empty($_POST["pcategory"])) {
    $error["category_error"] = "Category is required";
} else {
    $product_category = htmlspecialchars($_POST["pcategory"]);
}

if (empty($_POST["avability"])) {
    $error["avability_error"] = "Please select the availability of the product";
} else {
    $product_avability = htmlspecialchars($_POST["avability"]);
}

if (empty($_POST["pstock"])) {
    $error["stock_error"] = "Please enter the stock";
} else {
    $product_stock = htmlspecialchars($_POST["pstock"]);
    if ($product_stock < 0) {
        $error["stock_error"] = "Stock can't be negative";
    }
}

if (!empty($error)) {
    $_SESSION['error'] = $error;
    header("Location: /assests/html/product.php");
    exit;
}

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
} else {
    $_SESSION["add_error"] = "Failed to add product";
}

$stmp->close();
$conn->close();

header("Location: /assests/html/product.php");
exit;
