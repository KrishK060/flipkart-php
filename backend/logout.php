<?php
session_start();
session_destroy();
header("location:/frontend/loginsignup/login.html");
exit();