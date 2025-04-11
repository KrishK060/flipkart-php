<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin-verification.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/error/error.php';

$error = $_SESSION['error'] ?? [];
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product-crud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="admin">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/">flipkart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="category">Category crud</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <span class="text-" id="custome_error"></span>
        <form action="includes/add-product" id="form" data-form="add" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="pname" class="form-label">Product Name:</label>
                <input type="text" name="pname" class="form-control" id="pname">
                <span class='text-danger' id="name_error"><?= $error['name_error'] ?? '' ?></span>

            </div>

            <div class="mb-3">
                <label for="pimg" class="form-label">Product Image:</label>
                <input type="file" name="pimg" class="form-control" id="pimg" accept="image/*">
                <span class='text-danger' id="img_error"><?= $error['image_error'] ?? '' ?></span>

            </div>

            <div class="mb-3">
                <label for="pprice" class="form-label">Product Price:</label>
                <input type="number" name="pprice" class="form-control" id="pprice" aria-describedby="emailHelp">
                <span class='text-danger' id="price_error"><?= $error['price_error'] ?? '' ?></span>

            </div>

            <div class="mb-3">
                <label for="pdiscount" class="form-label">discount:</label>
                <input type="number" name="pdiscount" class="form-control" id="pdiscount" aria-describedby="emailHelp">
                <span class='text-danger' id="discount_error"><?= $error['discount_error'] ?? '' ?></span>

            </div>

            <div class="mb-3">
                <label for="ptext" class="form-label">Description:</label>
                <input type="textarea" name="ptext" class="form-control" id="ptext" aria-describedby="emailHelp">
                <span class='text-danger' id="desc_error"><?= $error['desc_error'] ?? '' ?></span>

            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Product Category:</label>
                <select class="form-select" name="pcategory" id="category" data-type="addcategory">

                </select>
                <span class='text-danger' id="category_error"><?= $error['category_error'] ?? '' ?></span>

            </div>

            <div class="mb-3">
                <label for="avability" class="form-label">Product avability:</label>
                <select class="form-select" name="avability" id="avability" data-type="productavability">
                    <option value="avalaible">avalaible</option>
                    <option value="unavalaible">unavalaible</option>
                </select>
                <span class='text-danger' id="avability_error"><?= $error['avability_error'] ?? '' ?></span>

            </div>

            <div class="mb-3">
                <label for="pstock" class="form-label">stock</label>
                <input type="number" name="pstock" class="form-control" id="pstock" aria-describedby="emailHelp">
                <span class='text-danger' id="stock_error"><?= $error['stock_error'] ?? '' ?></span>
            </div>

            <img src="" alt="">
            <button type="submit" id="btn1" class="btn btn-primary" data-type="adddata">Submit</button>
        </form>
        <div class="mb-3">
            <label for="pinput" class="form-label">Search:</label>
            <input type="input" name="pinput" class="form-control" id="pinput" aria-describedby="emailHelp"
                placeholder="search the product by its Id or name">
        </div>
        <table id="table" class="table">
            <thead>
                <tr>
                    <th scope="col"><i class="fa-solid fa-sort btn" data-type="sort" id="id-sort"></i>ID</th>
                    <th scope="col"><i class="fa-solid fa-sort btn" data-type="namesort" id="name-sort"></i>Name</th>
                    <th scope="col">Image</th>
                    <th scope="col"><i class="fa-solid fa-sort btn" data-type="pricesort" id="price-sort"></i>Price</th>
                    <th scope="col">Discount</th>
                    <th scope="col">Description</th>
                    <th scope="col">category</th>
                    <th scope="col">productavability</th>
                    <th scopr="col">stock</th>
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

    <script src="/assests/js/product.js"></script>
</body>

</html>