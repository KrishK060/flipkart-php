<?php
require './db/connection.php';
$sql = "update category set category_name=? where category_id=?";
if($_SERVER['REQUEST_METHOD']=='POST'){
$stmp = $conn->prepare($sql);
$stmp->bind_param('s',$category_name);
if($stmp->execute()){
    echo "updated succesfully";
}else{
    echo "not updated";
}
}