<?php
require 'config/connection.php';
header("Content-type:application/json");
$sql = "select * from category";
$result = $conn->query($sql);
$category = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($category);
exit();
