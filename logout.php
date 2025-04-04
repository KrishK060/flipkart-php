<?php
session_start();
session_destroy();
header("location:/assests/html/signin.php");
exit();