<?php
session_start();
require 'config/connection.php';
require 'validation.php';
require_once 'error.php';

header('Content-Type: application/json');

$errors=[];

if (empty($_POST["email"])) {
    $errors["email_error"] = "Email is required";
}
$email = htmlspecialchars($_POST["email"]);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors["email_error"] = "Invalid email format";
}

if (empty($_POST["username"])) {
    $errors["name_error"] = "Username is required";
}
$username = htmlspecialchars($_POST["username"]);
if (!preg_match("/^[a-zA-Z-' ]*$/", $username)) {
    $errors["name_error"] = "Only letters and white spaces are allowed";
}

$check_sql = "select id from user where email = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("s", $email);
$check_stmt->execute();
$check_stmt->store_result();
if ($check_stmt->num_rows > 0) {
    $errors["email_error"] = "email already exists";
}

$check_sql = "select id from user where username = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("s", $username);
$check_stmt->execute();
$check_stmt->store_result();
if ($check_stmt->num_rows > 0) {
    $errors["name_error"]= "Username already exists";
}

$dob = $_POST["dob"] ?? null;
if (!$dob) {
    $errors["dob_error"] = "Date of Birth is required";
}

if (empty($_POST["phone_number"])) {
    $errors["phn_error"] = "Phone number is required";
}
$phone_number = htmlspecialchars($_POST["phone_number"]);
if (!preg_match("/^[0-9]{10}$/", $phone_number)) {
    $errors["phn_error"] = "Enter a valid 10-digit phone number";
}

if (empty($_POST["password"]) || empty($_POST["confirm_password"])) {
    $errors["pswd_error"] = "Password and Confirm Password are required";
}
$password = htmlspecialchars($_POST["password"]);

$confirm_password = htmlspecialchars($_POST["confirm_password"]);
if ($password !== $confirm_password) {
    $errors["confirm_pswd_error"] = "Passwords do not match";
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: /assests/html/signup.php");
    exit;
}

$hash_password = password_hash($password, PASSWORD_BCRYPT);

$sql = "insert into  user(email, username, password, dob, phone) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $email, $username, $hash_password, $dob, $phone_number);

if ($stmt->execute()) {
    $response["success"] = true;
    $response["message"] = "Signup successful";
    header("location:/assests/html/signin.php");
} else {
    $response["message"] = "Signup failed, please try again";
}

echo json_encode($response);
$stmt->close();
$conn->close();
