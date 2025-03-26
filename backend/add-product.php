<?php
require './db/connection.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = htmlspecialchars($_POST["pname"]);
    $product_image = htmlspecialchars(($_POST["pimg"]));
    $product_price = htmlspecialchars(($_POST["pprice"]));
    $product_description = htmlspecialchars(($_POST["ptext"]));
    $product_category = htmlspecialchars(($_POST["category"]));
    
    echo $_POST['category'];    

    $sql = 'insert into product(product_name,product_image,product_price,product_description,product_category)values(?,?,?,?,?)';
    $stmp = $conn->prepare($sql);
    $stmp->bind_param('ssiss', $product_name, $product_image, $product_price, $product_description, $product_category);

    if ($stmp->execute()) {
        $response = ["success" => true, "message" => "product added successfully"];
        // header("location:/frontend/FlipkartHomePage/admin/product.html");
    } else {
        $response = ["success" => false, "message" => "Failed to add product"];
    }
    $stmp->close();
    // header("Content-Type: application/json");
    echo json_encode($response);
}
