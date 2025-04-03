<?php
session_start();
require 'config/connection.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);
    
    $sql = "select id, username, password, user_role from user where username=?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error in SQL query: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($db_user_id, $db_username, $db_password, $role);
        $stmt->fetch();

        $user = [
            "user_id" => $db_user_id,  
            "username" => $db_username,
            "role" => $role
        ];

        $_SESSION['user_id'] = $user['user_id']; 
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_role'] = $user['role'];

        if (password_verify($password, $db_password)) {
            if ($user['role'] === 'admin' || $user['role'] === 'user') {
                header("Location: index.php");  
            } 
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
?>
