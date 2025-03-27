<?php
require './db/connection.php';
header("Content-Type: application/json");
if($_SERVER['REQUEST_METHOD']=='POST'){
    $product_id = isset($_POST["product_id"]) ? intval($_POST["product_id"]) : 0;
    if($product_id>0){
        $sql = "delete from product where product_id =?";
        $stmp=$conn->prepare($sql);
        $stmp->bind_param('i',$product_id);

        if ($stmp->execute()) {
            $response = ["success" => true, "message" => "product deleted successfully"];
        } else {
            $response = ["success" => false, "message" => "Failed to delete product"];
        }
        $stmp->close();
    }else {
        $response = ["success" => false, "message" => "Invalid input"];
    }
} else {
    $response = ["success" => false, "message" => "Invalid request"];
}
echo json_encode($response);


