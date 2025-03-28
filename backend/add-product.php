<?php
require './db/connection.php';
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    

    $product_name = htmlspecialchars($_POST["pname"]);
    $product_image = basename($_FILES["pimg"]['name']); 
    $product_price = htmlspecialchars($_POST["pprice"]);
    $product_description = htmlspecialchars($_POST["ptext"]);
    $product_category = htmlspecialchars($_POST["category"]);
    $product_avability = htmlspecialchars($_POST["avability"]);
    $product_discount = htmlspecialchars($_POST["pdiscount"]);


   
    $sql = 'INSERT INTO product(product_name, product_image, product_price, product_description, product_category,product_avalaible,discount) 
            VALUES (?, ?, ?, ?, ?, ?, ?)';
    $stmp = $conn->prepare($sql);
    $stmp->bind_param('ssisisi', $product_name, $product_image, $product_price, $product_description, $product_category,$product_avability,$product_discount);

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
