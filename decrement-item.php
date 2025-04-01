<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require 'config/connection.php';
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cart_id = isset($_POST["cart_id"]) ? intval($_POST["cart_id"]) : 0;

    if ($cart_id > 0) {
        $sql = "update product set product_stock = product_stock + 1 where product_id = (select product_id from cart where cart_id=?)";
        $stmp = $conn->prepare($sql);
        $stmp->bind_param('i', $cart_id);
        if ($stmp->execute()) {
            $response = ["success" => true, "message" => "Product stock updated successfully"];
        } else {
            $response = ["success" => false, "message" => "Failed to update product stock"];
        }
        $stmp->close();

    $sql = "select product_id,quantity from cart where cart_id=?";
    $stmp=$conn->prepare($sql);
    $stmp->bind_param('i', $cart_id);
    $stmp->execute();
    $stmp->bind_result($product_id,$quantity);
    $stmp->fetch();
    $stmp->close();

        if ($quantity > 1) {
            $sql = "update cart set quantity = quantity - 1 where cart_id=?";
            $stmp = $conn->prepare($sql);
            $stmp->bind_param('i', $cart_id);
            if ($stmp->execute()) {
                $response = ["success" => true, "message" => "Cart quantity updated successfully"];
            } else {
                $response = ["success" => false, "message" => "Failed to update cart quantity"];
            }
            $stmp->close();
        } else {
            $sql = "delete from cart where cart_id=?";
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
