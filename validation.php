<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("location:index.php");
    exit();
}
