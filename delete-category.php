<?php
require 'config/connection.php';
header("Content-Type: application/json");
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $category_id = isset($_POST["category_id"]) ? intval($_POST["category_id"]) : 0; 
    if($category_id>0){
        $sql = "delete from category where category_id =?";
        $stmp=$conn->prepare($sql);
        $stmp->bind_param('i',$category_id);
        if ($stmp->execute()) {
            $response = ["success" => true, "message" => "Category deleted successfully"];
        } else {
            $response = ["success" => false, "message" => "Failed to delete category"];
        }
        $stmp->close();
    } else {
        $response = ["success" => false, "message" => "Invalid input"];
    }
} else {
    $response = ["success" => false, "message" => "Invalid request"];
}
echo json_encode($response);



