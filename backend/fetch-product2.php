<?php
require './db/connection.php';
header("Content-type:application/json");
$sql = 'select * from product';
$result = $conn->query($sql);
$product=[];
if($result->num_rows>0){
    foreach($result as $row){
        array_push($product,$row);
    }
}
echo json_encode($product);
exit();