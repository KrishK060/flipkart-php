<?PHP
session_start();
require 'config/connection.php';
require 'validation.php';

$errors = [];
if (empty($_POST["cname"])) {
   $errors["name_error"] = "please enter Category name";
} else {
   $category_name = htmlspecialchars(trim($_POST["cname"]));

   if (!preg_match("/^[a-zA-Z-' ]*$/", $category_name)) {
      $errors["name_error"] = "Only letters and white spaces are allowed.";
   }
}

if (!empty($errors)) {
   $_SESSION['errors'] = $errors;
   header("Location: /assests/html/category.php");
   exit;
}

$sql = 'insert into category(category_name)values(?)';
$stmp = $conn->prepare($sql);

$stmp->bind_param('s', $category_name);
if ($stmp->execute()) {
   echo "category added succesfully";
   $_SESSION["addcategory_success"] = "Category added successfully";
} else {
   $_SESSION["addcategory_error"] = "Failed to add category";
}
$stmp->close();
$conn->close();
header("Location: /assests/html/category.php");
exit;
