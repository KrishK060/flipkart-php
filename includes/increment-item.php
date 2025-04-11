<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/error/validation.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/error/error.php';
header("Content-Type: application/json");

if (!isset($_POST["cart_id"])) {
    echo json_encode(["success" => false, "message" => "cart_id is required"]);
    exit();
}
$cart_id = intval($_POST["cart_id"]);


    $sql = "select product_id, quantity from cart where cart_id=?";
    $stmp = $conn->prepare($sql);
    $stmp->bind_param('i', $cart_id);
    $stmp->execute();
    $stmp->bind_result($product_id, $quantity);
    $stmp->fetch();
    $stmp->close();

    if ($product_id) {

        $sql = "select product_stock from product where product_id=?";
        $stmp = $conn->prepare($sql);
        $stmp->bind_param('i', $product_id);
        $stmp->execute();
        $stmp->bind_result($product_stock);
        $stmp->fetch();
        $stmp->close();

        if ($product_stock == 0) {
            echo json_encode(["success" => false, "message" => "Cannot increase quantity beyond available stock!"]);
            exit;
        }
        $sql = "update product set product_stock = product_stock - 1 where product_id=?";
        $stmp = $conn->prepare($sql);
        $stmp->bind_param('i', $product_id);
        if ($stmp->execute()) {
            $response = ["success" => true, "message" => "Product stock updated successfully"];
        } else {
            $response = ["success" => false, "message" => "Failed to update product stock"];
        }
        $stmp->close();
    }else{
        $response = ["success" => false, "message" => "product id not found"];
    }

    if ($quantity >= 0) {
        $sql = "update cart set quantity = quantity + 1 where cart_id=?";
        $stmp = $conn->prepare($sql);
        $stmp->bind_param('i', $cart_id);
        if ($stmp->execute()) {
            $response = ["success" => true, "message" => "Cart quantity updated successfully"];
        } else {
            $response = ["success" => false, "message" => "Failed to update cart quantity"];
        }
        $stmp->close();
    }


echo json_encode($response);
