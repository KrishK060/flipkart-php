<?php
session_start();
require './db/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);

    $sql = "SELECT username, password, user_role FROM user WHERE username=?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error in SQL query: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($db_username, $db_password, $role);
        $result = $stmt->fetch();
        $user = [
            "username" => $db_username,
            "email" => $email,
            "role" => $role
        ];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_role'] = $user['role'];
        if (password_verify($password, $db_password)) {
           

            if ($user['role'] === 'admin') {
                header("Location: /frontend/loginsignup/signup.html");
            } else {
                header("Location: /frontend/FlipkartHomePage/index.php");
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
