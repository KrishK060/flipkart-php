<?php
require 'config/connection.php';
require 'validation.php';
require_once 'error.php';

header('Content-Type: application/json');

$response = ["success" => false, "message" => ""];


if (empty($_POST["email"])) {
    $response["message"] = "Email is required";
    echo json_encode($response);
    exit;
}
$email = htmlspecialchars($_POST["email"]);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response["message"] = "Invalid email format";
    echo json_encode($response);
    exit;
}


if (empty($_POST["username"])) {
    $response["message"] = "Username is required";
    echo json_encode($response);
    exit;
}
$username = htmlspecialchars($_POST["username"]);
if (!preg_match("/^[a-zA-Z-' ]*$/", $username)) {
    $response["message"] = "Only letters and white spaces are allowed";
    echo json_encode($response);
    exit;
}

$check_sql = "select id from user where email = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("s", $email);
$check_stmt->execute();
$check_stmt->store_result();
if ($check_stmt->num_rows > 0) {
    $response["message"] = "email already exists";
    echo json_encode($response);
    exit;
}

$check_sql = "select id from user where username = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("s", $username);
$check_stmt->execute();
$check_stmt->store_result();
if ($check_stmt->num_rows > 0) {
    $response["message"] = "Username already exists";
    echo json_encode($response);
    exit;
}


$dob = $_POST["dob"] ?? null;
if (!$dob) {
    $response["message"] = "Date of Birth is required";
    echo json_encode($response);
    exit;
}


if (empty($_POST["phone_number"])) {
    $response["message"] = "Phone number is required";
    echo json_encode($response);
    exit;
}
$phone_number = htmlspecialchars($_POST["phone_number"]);
if (!preg_match("/^[0-9]{10}$/", $phone_number)) {
    $response["message"] = "Enter a valid 10-digit phone number";
    echo json_encode($response);
    exit;
}


if (empty($_POST["password"]) || empty($_POST["confirm_password"])) {
    $response["message"] = "Password and Confirm Password are required";
    echo json_encode($response);
    exit;
}
$password = htmlspecialchars($_POST["password"]);
$confirm_password = htmlspecialchars($_POST["confirm_password"]);
if ($password !== $confirm_password) {
    $response["message"] = "Passwords do not match";
    echo json_encode($response);
    exit;
}
$hash_password = password_hash($password, PASSWORD_BCRYPT);

$sql = "insert into  user(email, username, password, dob, phone) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $email, $username, $hash_password, $dob, $phone_number);

if ($stmt->execute()) {
    $response["success"] = true;
    $response["message"] = "Signup successful";
} else {
    $response["message"] = "Signup failed, please try again";
}

echo json_encode($response);
$stmt->close();
$conn->close();
