<?php
require 'config/connection.php';
header("Content-type:application/json");
$sql = 'select p.product_id,p.product_name,p.product_image,p.product_price,p.product_description,p.product_category,p.product_avalaible,p.discount,c.category_name from product as p left join category as c on p.product_category=c.category_id';
$result = $conn->query($sql);

$product = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($product);
exit();
