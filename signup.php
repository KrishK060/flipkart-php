<?php
require 'config/connection.php';
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $email = htmlspecialchars($_POST["email"]);
    $username = htmlspecialchars($_POST["username"]);
    $hash_password = password_hash($_POST["password"], PASSWORD_BCRYPT);

    $confirm_password = htmlspecialchars($_POST["confirm_password"]);
    $dob = $_POST["dob"];
    $phone_number = htmlspecialchars($_POST["phone_number"]);

    if($hash_password!=$confirm_password){
        echo "password doesn`t match";
    }
    
    $sql = "insert into user(email,username,password,dob,phone) values(?,?,?,?,?)";
    $stmp = $conn->prepare($sql);
    $stmp->bind_param("sssss",$email,$username,$hash_password,$dob,$phone_number);
    
    if($stmp->execute()){
        echo "signup succesfully";
        header("location:/assests/html/login.html");
    }else{
        echo "invalid parameters";
    }
}