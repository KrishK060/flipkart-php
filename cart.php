<?php
require_once $_SERVER['DOCUMENT_ROOT'] .'/verified-user.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/error/error.php';


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="/assests/css/flipkart.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="conatiner-fluid bg-white">
        <div class="container">
            <nav class="navbar">
                <div class="parent-head">
                    <a class="navbar-brand" href="#">
                        <img src="https://static-assets-web.flixcart.com/batman-returns/batman-returns/p/images/fkheaderlogo_exploreplus-44005d.svg"
                            title="Flipkart"></a>
                    <div class="input-group mb-2 ">
                        <span class="input-group-text bg-primary-subtle " id="basic-addon1"><i
                                class="fa-solid fa-magnifying-glass"></i></span>
                        <input class="form-control me-2 bg-primary-subtle " type="search"
                            placeholder="Search for Product,Brands and more" aria-label="Search">
                    </div>

                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa-solid fa-circle-user"></i><span class="dn3"><?= $_SESSION["username"] ?? 'Login' ?></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">My profile</a></li>
                            <li><a class="dropdown-item" href="#">flipkart plus zone</a></li>
                            <li><a class="dropdown-item" href="#">orders</a></li>
                            <li><a class="dropdown-item" href="#">whishlist</a></li>
                            <li><a class="dropdown-item" href="#">Rewards</a></li>
                            <li><a class="dropdown-item" href="#">Giftcard</a></li>
                        </ul>
                    </div>

                    <div class="cart">
                        <a href="/">
                            Home Page
                        </a>
                    </div>

                    <div class="customer">
                        <button class="btn" type="button">
                            <img
                                src="https://static-assets-web.flixcart.com/batman-returns/batman-returns/p/images/Store-9eeae2.svg">
                        </button>
                        <span class="dn3">Customer</span>
                    </div>
                    <a class="btn btn-primary ms-2 admin" href="admin" role="button">admin panel</a>
                    <a href="/includes/logout.php" class="btn btn-danger mr-2"
                        onclick="return confirm('Are you sure you want to log out?')">Logout</a>
                </div>
            </nav>
        </div>
    </div>
    <section class="h-100">
        <div class="container h-100 py-5">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-10">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="fw-normal mb-0">Shopping Cart</h3>
                    </div>
                    <div class="items" id="add-items">

                    </div>
                    <div class="card w-100 shadow-sm rounded-lg p-3">
                        <div class="card-body">
                            <p class="text-muted mb-2">
                                Total Price (<span id="numberofitem"></span> items) =
                                <span class="fw-bold text-success" id="totalprice"></span>
                            </p>
                            <p class="text-muted mb-2">
                                Delivery: <span class="text-success">Free delivery</span>
                            </p>
                            <hr class="my-4">
                            <p class="text-muted mb-2">
                                Total amount: <span class="text-success" id="totalamount"></span>
                            </p>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-warning btn-block btn-lg" id="payment">Proceed to Pay</button>

                </div>
            </div>
        </div>
    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assests/js/cart.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
</body>

</html>