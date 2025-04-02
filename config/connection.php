<?php
$servername="localhost";
$username="krish";
$password="123";
$database="flipkart_php";
$conn = new mysqli($servername,$username,$password,$database);

if($conn->connect_error){
    die("connection failed" .$conn->connect_error);
}
