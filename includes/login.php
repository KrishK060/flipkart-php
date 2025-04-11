<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/error/validation.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/error/error.php';

if (empty($_POST["username"]) || empty($_POST["password"])) {
    $_SESSION['login_error'] = "Username and password are required";
    header("Location:/signin");
    exit;
}

$username = htmlspecialchars($_POST["username"]);
$password = htmlspecialchars($_POST["password"]);

$sql = "select id, username, password, user_role from user WHERE username=?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    $_SESSION['login_error'] = "Something went wrong. Please try again later.";
    header("Location:/signin");
    exit;
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

    if (password_verify($password, $db_password)) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_role'] = $user['role'];
        header("Location:/index");
        exit;
    } else {
        $_SESSION['login_error'] = "Invalid username or password";
        header("Location:/signin");
        exit;
    }
} else {
    $_SESSION['login_error'] = "Invalid username or password";
    header("Location:/signin");
    exit;
}
