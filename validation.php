<?php
// require 'config/connection.php';
// session_start();
// header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD']!== 'POST') {
    header("location:index.php");
    exit();

}