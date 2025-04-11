<?php
session_start();
require 'config/connection.php';
header("Content-type:application/json");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User is not logged in']);
    exit();
}
$user_id = $_SESSION['user_id'];
$sql = 'select ol.*,o.transaction_timestamp  from orderlist as ol left join orders as o on o.order_id = ol.order_id where o.user_id = ?';

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

$orderlist = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($orderlist);
exit();
