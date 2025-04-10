<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/error/error.php';
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
