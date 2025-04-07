<?php
require 'config/connection.php';
header("Content-type:application/json");
$sql = 'select * from product';
$result = $conn->query($sql);
$product =$result->fetch_all(MYSQLI_ASSOC);
echo json_encode($product);
exit();
