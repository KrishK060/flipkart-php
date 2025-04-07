<?php
require 'config/connection.php';
require 'validation.php';

if(empty($_POST["email"])){
    echo json_encode(["success" => false, "message" => "email is required"]);
}else{
    $email = htmlspecialchars($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["success" => false, "message" => "invalid email formate"]);
      }
}

if(empty($_POST["username"])) {
    echo json_encode(["success" => false, "message" => "username is required"]);
}else{
    $username = htmlspecialchars($_POST["username"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$username)) {
        echo json_encode(["success" => false, "message" => "only letters and white spaces are allowed"]);
      }
      echo $username;
}

$dob = $_POST["dob"] ?? null;
if (!$dob) {
    $response["message"] = "Date of Birth is required";
    echo json_encode($response);
    exit;
}

$hash_password = password_hash(htmlspecialchars($_POST["password"]), PASSWORD_BCRYPT);
$confirm_password = htmlspecialchars($_POST["confirm_password"]);

if(empty($_POST["phone_number"])){
    echo json_encode(["success" => false, "message" => "phone number is required"]);
}else{
    $phone_number = htmlspecialchars($_POST["phone_number"]);
    if(!preg_match("/^[0-9]{1}[0-9]{9}$/",$phone_number)){
        echo json_encode(["success" => false, "message" => "enter correct 10 digit phone number"]);
    }
}

if ($hash_password != $confirm_password) {
    echo json_encode(["success" => false, "message" => "invalid password"]);
}

$sql = "insert into user(email,username,password,dob,phone) values(?,?,?,?,?)";
$stmp = $conn->prepare($sql);
$stmp->bind_param("sssss", $email, $username, $hash_password, $dob, $phone_number);

if ($stmp->execute()) {
    echo "signup succesfully";
    header("location:/assests/html/signin.php");
} else {
    echo "invalid parameters";
}
