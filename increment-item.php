<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require 'config/connection.php';
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cart_id = isset($_POST["cart_id"]) ? intval($_POST["cart_id"]) : 0;

    if ($cart_id > 0) {
        
        
        $sql = "SELECT product_id, quantity FROM cart WHERE cart_id=?";
        $stmp = $conn->prepare($sql);
        $stmp->bind_param('i', $cart_id);
        $stmp->execute();
        $stmp->bind_result($product_id, $quantity);
        $stmp->fetch();
        $stmp->close();

        if ($product_id) {
            
            $sql = "SELECT product_stock FROM product WHERE product_id=?";
            $stmp = $conn->prepare($sql);
            $stmp->bind_param('i', $product_id);
            $stmp->execute();
            $stmp->bind_result($product_stock);
            $stmp->fetch();
            $stmp->close();

            
            if ($quantity >= $product_stock) {
                echo json_encode(["success" => false, "message" => "Cannot increase quantity beyond available stock!"]);
                exit;
            }

           
            $sql = "UPDATE product SET product_stock = product_stock - 1 WHERE product_id=?";
            $stmp = $conn->prepare($sql);
            $stmp->bind_param('i', $product_id);
            if ($stmp->execute()) {
                $response = ["success" => true, "message" => "Product stock updated successfully"];
            } else {
                $response = ["success" => false, "message" => "Failed to update product stock"];
            }
            $stmp->close();
        }

        if ($quantity >= 0) {
           
            $sql = "UPDATE cart SET quantity = quantity + 1 WHERE cart_id=?";
            $stmp = $conn->prepare($sql);
            $stmp->bind_param('i', $cart_id);
            if ($stmp->execute()) {
                $response = ["success" => true, "message" => "Cart quantity updated successfully"];
            } else {
                $response = ["success" => false, "message" => "Failed to update cart quantity"];
            }
            $stmp->close();
        } else {
            
            $sql = "DELETE FROM cart WHERE cart_id=?";
            $stmp = $conn->prepare($sql);
            $stmp->bind_param('i', $cart_id);
            if ($stmp->execute()) {
                $response = ["success" => true, "message" => "Cart removed successfully"];
            } else {
                $response = ["success" => false, "message" => "Failed to remove cart"];
            }
            $stmp->close();
        }
    } else {
        $response = ["success" => false, "message" => "Invalid cart ID"];
    }
}

echo json_encode($response);
