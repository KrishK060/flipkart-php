<?php
require '../../error.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin-verification.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/error/error.php';
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>category-crud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="admin">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="product">Product crud</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/">flipkart</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <span class="text-danger" id="custome_error"></span>
        <form action="includes/add-category.php" id="form" data-form="add" method="POST">
            <div>
                <div class="mb-3">
                    <label for="cname" class="form-label">Category Name:</label>
                    <input type="text" name="cname" class="form-control" id="cname">
                    <span class='text-danger' id="name_error"><?= $errors['name_error'] ?? '' ?></span>
                </div>
            </div>

            <button type="submit" id="btn1" class="btn btn-primary" data-type="adddata">Add Category</button>
        </form>
        <div class="mb-3">
            <label for="cinput" class="form-label">Search:</label>
            <input type="input" name="cinput" class="form-control" id="cinput" aria-describedby="emailHelp"
                placeholder="search the product by its Id or name">
        </div>
        <table id="table" class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">category-Name</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
    <script src="/assests/js/category.js"></script>
</body>

</html>