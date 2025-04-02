<?PHP
require 'config/connection.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $category_name = htmlspecialchars($_POST["cname"]);
   $sql = 'insert into category(category_name)values(?)';
   $stmp = $conn->prepare($sql);
   $stmp->bind_param('s', $category_name);
   if ($stmp->execute()) {
      echo "category added succesfully";
      header("location:/assests/html/category.html");
      exit();
   } else {
      echo "category doesnt added";
   }
   header("Content-Type: application/json");
}
