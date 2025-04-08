<?PHP
require 'config/connection.php';
require 'validation.php';

if (empty($_POST["cname"])) {
   $response["message"] = "category is required";
   echo json_encode($response);
   exit;
}
$category_name = htmlspecialchars($_POST["cname"]);
if (!preg_match("/^[a-zA-Z-' ]*$/", $category_name)) {
   $response["message"] = "Only letters and white spaces are allowed";
   echo json_encode($response);
   exit;
}
$sql = 'insert into category(category_name)values(?)';
$stmp = $conn->prepare($sql);
$stmp->bind_param('s', $category_name);
if ($stmp->execute()) {
   echo "category added succesfully";
   header("location:/assests/html/category.php");
   exit();
} else {
   echo "category doesnt added";
}
header("Content-Type: application/json");
