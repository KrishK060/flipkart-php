<?php
require './db/connection.php';
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    

    $product_name = htmlspecialchars($_POST["pname"]);
    $product_image = basename($_FILES["pimg"]['name']); // Ensure a clean filename
    $product_price = htmlspecialchars($_POST["pprice"]);
    $product_description = htmlspecialchars($_POST["ptext"]);
    $product_category = htmlspecialchars($_POST["category"]);

   
    $sql = 'INSERT INTO product(product_name, product_image, product_price, product_description, product_category) 
            VALUES (?, ?, ?, ?, ?)';
    $stmp = $conn->prepare($sql);
    $stmp->bind_param('ssiss', $product_name, $product_image, $product_price, $product_description, $product_category);

    if ($stmp->execute()) {
        move_uploaded_file($_FILES['pimg']['tmp_name'], "/home/krish.kalaria@simform.dom/Desktop/LMS-2/Flipkart-php/flipkart-php/frontend/" . $_FILES['pimg']['name']);

        echo json_encode(["success" => true, "message" => "Product added successfully"]);
        header("location:/frontend/FlipkartHomePage/admin/product.html");
    } else {
        echo json_encode(["success" => false, "message" => "Failed to add product"]);
    }
   $stmp->close();
   header("Content-Type: application/json");
}
?>
