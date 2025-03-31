<?php
require 'config/connection.php';
header("Content-Type: application/json");
if($_SERVER['REQUEST_METHOD']=='POST'){
    $cart_id = isset($_POST["cart_id"]) ? intval($_POST["cart_id"]) : 0;
    if($cart_id>0){
        $sql = "delete from cart where cart_id =?";
        $stmp=$conn->prepare($sql);
        $stmp->bind_param('i',$cart_id);

        if ($stmp->execute()) {
            $response = ["success" => true, "message" => "cart deleted successfully"];
        } else {
            $response = ["success" => false, "message" => "Failed to delete cart"];
        }
        $stmp->close();
    }else {
        $response = ["success" => false, "message" => "Invalid input"];
    }
} else {
    $response = ["success" => false, "message" => "Invalid request"];
}
echo json_encode($response);