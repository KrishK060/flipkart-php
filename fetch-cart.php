<?php
require 'config/connection.php';
header("Content-type:application/json");
$sql = 'select c.*,p.product_name,p.product_image,p.product_price,p.discount from cart as c left join product as p on c.product_id = p.product_id';
$result = $conn->query($sql);
$cart=[];
if($result->num_rows>0){
    foreach($result as $row){
        array_push($cart,$row);
    }
}
echo json_encode($cart);
exit();