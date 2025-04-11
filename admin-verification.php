<?php
session_start();
if (!isset($_SESSION["username"]) || $_SESSION["user_role"] !== "admin") {
    header("location: signin.php");
    exit();
}