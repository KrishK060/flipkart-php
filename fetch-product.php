<?php
require 'config/connection.php';
header("Content-type:application/json");
$sql = "select * from category";
$result = $conn->query($sql);
$category = [];
if ($result->num_rows > 0) {
    foreach ($result as $row) {
        array_push($category, $row);
    }
}
echo json_encode($category);
exit();
