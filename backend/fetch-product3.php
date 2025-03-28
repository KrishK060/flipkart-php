<?php
require './db/connection.php';
header("Content-type:application/json");
$sql = 'select p.product_id,p.product_name,p.product_image,p.product_price,p.product_description,p.product_category,p.product_avalaible,c.category_name from product as p left join category as c on p.product_category=c.category_id';
$result = $conn->query($sql);
$product=[];
if($result->num_rows>0){
    foreach($result as $row){
        array_push($product,$row);
    }
}
echo json_encode($product);
exit();
