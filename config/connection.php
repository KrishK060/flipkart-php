<?php
use Dotenv\Dotenv;
require_once 'vendor/autoload.php';
$dotenv = Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();
$servername = $_ENV["servername"];
$username = $_ENV["username"];
$password = $_ENV["password"];
$database = $_ENV["databasename"];
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("connection failed" . $conn->connect_error);
}
