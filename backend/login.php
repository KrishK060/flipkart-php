<?php
session_start();
require './db/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Username = htmlspecialchars($_POST["username"]);
    echo $Username;
    $password = htmlspecialchars($_POST["password"]);

    $sql = "select username,password from user where username=?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error in SQL query: " . $conn->error);
    }

    $stmt->bind_param("s", $Username);
    $stmt->execute();
    $stmt->store_result();

   
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($username, $hash_password);
        $stmt->fetch();
        $_SESSION['username'] = $username; 

       
        if (password_verify($password, $hash_password)) {
           
            header("Location:/frontend/FlipkartHomePage/index.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found.";
    }

    
    $stmt->close();
    $conn->close();
}

