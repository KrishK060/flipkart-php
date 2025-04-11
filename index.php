<?php
require_once $_SERVER['DOCUMENT_ROOT'] .'/verified-user.php';
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
                            <i class="fa-solid fa-circle-user"></i><span class="dn3"> <?= $_SESSION["username"]?></span>
                            <i class="fa-solid fa-circle-user"></i><span class="dn3"> <?= $_SESSION["username"]?></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">My profile</a></li>
                            <li><a class="dropdown-item" href="#">flipkart plus zone</a></li>
                            <li><a class="dropdown-item" href="order" onclick="myFunction()">orders</a></li>
                            <li><a class="dropdown-item" href="#">whishlist</a></li>
                            <li><a class="dropdown-item" href="#">Rewards</a></li>
                            <li><a class="dropdown-item" href="#">Giftcard</a></li>
                        </ul>
                    </div>

                    <div class="cart">
                        <a href="cart">
                            <button class="btn" type="button">
                                <img src="https://static-assets-web.flixcart.com/batman-returns/batman-returns/p/images/header_cart-eed150.svg" alt="Cart">
                            </button>
                            <span class="dn3">Cart</span>
                        </a>
                    </div>

                    <div class="customer">
                        <button class="btn" type="button">
                            <img
                                src="https://static-assets-web.flixcart.com/batman-returns/batman-returns/p/images/Store-9eeae2.svg">
                        </button>
                        <span class="dn3">Customer</span>
                    </div>
                    <a class="btn btn-primary ms-2 admin" href="/assests/html/admin.php" role="button">admin panel</a>
                    <a href="/logout.php" class="btn btn-danger mr-2" onclick="return confirm('Are you sure you want to log out?')">Logout</a>
                    <?php if (isset($_SESSION['username']) && $_SESSION["user_role"] == "admin") {
                        echo '   <a class="btn btn-primary ms-2 admin" href="admin" role="button">admin panel</a>';
                    } ?>
                    <a href="/includes/logout.php" class="btn btn-danger mr-2" onclick="return confirm('Are you sure you want to log out?')">Logout</a>
                </div>
            </nav>
        </div>
    </div>
    <div class="container  bg-light mt-2 p-4">
        <div class="d-flex heading">
            <div class="p1-item d-flex ">
                <a>
                    <img src="https://rukminim2.flixcart.com/flap/64/64/image/29327f40e9c4d26b.png?q=100">
                    <div class="name ">
                        <span>Grocery</span>
                    </div>
                </a>
            </div>
            <div class="p1-item d-flex">
                <a>
                    <img src="https://rukminim2.flixcart.com/flap/64/64/image/22fddf3c7da4c4f4.png?q=100">
                    <div class="name ">
                        <span>Mobile</span>
                    </div>
                </a>
            </div>
            <div class="p1-item d-flex">
                <a>
                    <img src="https://rukminim2.flixcart.com/fk-p-flap/64/64/image/0d75b34f7d8fbcb3.png?q=100">
                    <div class="name ">
                        <span>Fashion</span>
                    </div>
                </a>
            </div>
            <div class="p1-item d-flex">
                <a>
                    <img src="https://rukminim2.flixcart.com/flap/64/64/image/69c6589653afdb9a.png?q=100">
                    <div class="name ">
                        <span>Electronics</span>
                    </div>
                </a>
            </div>
            <div class="p1-item d-flex">
                <a>
                    <img src="https://rukminim2.flixcart.com/flap/64/64/image/ab7e2b022a4587dd.jpg?q=100">
                    <div class="name ">
                        <span>Home&Furniture</span>
                    </div>
                </a>
            </div>
            <div class="p1-item d-flex">
                <a>
                    <img src="https://rukminim2.flixcart.com/fk-p-flap/64/64/image/0139228b2f7eb413.jpg?q=100">
                    <div class="name ">
                        <span>Appliances</span>
                    </div>
                </a>
            </div>
            <div class="p1-item d-flex">
                <a>
                    <img src="https://rukminim2.flixcart.com/flap/64/64/image/71050627a56b4693.png?q=100">
                    <div class="name ">
                        <span>Flight Booking</span>
                    </div>
                </a>
            </div>
            <div class="p1-item d-flex ">
                <a>
                    <img src="https://rukminim2.flixcart.com/flap/64/64/image/dff3f7adcf3a90c6.png?q=100">
                    <div class="name ">
                        <span>toys&more</span>
                    </div>
                </a>
            </div>
            <div class="p1-item d-flex ">
                <a>
                    <img src="https://rukminim2.flixcart.com/fk-p-flap/64/64/image/05d708653beff580.png?q=100">
                    <div class="name ">
                        <span>Two-wheelers</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="container bg-white mt-2 p-0">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3"
                    aria-label="Slide 4"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="1000">
                    <img src="https://rukminim2.flixcart.com/fk-p-flap/1010/170/image/53dcf24ecc20bf27.jpg?q=20"
                        class="d-block w-100" alt="plane">
                </div>
                <div class="carousel-item" data-bs-interval="2000">
                    <img src="https://rukminim2.flixcart.com/fk-p-flap/1010/170/image/7f3cde58a30f6024.jpg?q=20"
                        class="d-block w-100" alt="flight ticket">
                </div>
                <div class="carousel-item" data-bs-interval="3000">
                    <img src="https://rukminim2.flixcart.com/fk-p-flap/1010/170/image/9600dc6f546d1164.jpeg?q=20"
                        class="d-block w-100" alt="Grooming">
                </div>
                <div class="carousel-item">
                    <img src="https://rukminim2.flixcart.com/fk-p-flap/1620/270/image/d9290fb51138d286.png?q=20"
                        class="d-block w-100" alt="Discount flight">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <div class="container bg-light mt-3 p-2">
        <div class="row ms-2">
            <h4>Best of Electronics</h4>
        </div>
        <div class="container bg-light mt-3 p-2">
            <div class="d-flex">
                <div class="row w-100">
                    <div class="d-flex instruments2">
                        <div class="cards-wrapper">
                            <div class="card">
                                <img src="https://encrypted-tbn2.gstatic.com/shopping?q=tbn:ANd9GcSMPZQlIHpqXv-lq1rTZC9SvcIsEM7qSHwP14bkIK6php95gBQKduTj-X5CfxtOfe1PIUtwAscMgaBLy_l-jYXt-PO9UUSovuJ5fyiKO3JmSwPGs-z5vmtXUw&usqp=CAE"
                                    class="card-img-top img-fluid" alt="...">
                                <div class="card-body">
                                    <p class="card-text text-center">Best Wireless Headphone</p>
                                    <strong class="card-text ct">Upto 70% off</strong>
                                </div>
                            </div>
                            <div class="card">
                                <img src="https://encrypted-tbn1.gstatic.com/shopping?q=tbn:ANd9GcTYY-RJLZS4op2B806yVKjC_-CypRhDC0NNps80B0a1UaQQTVHJ0bw00biYFv7zA_b93wFqPg6x39Eg6vPKODBoqnOG8y6XGQP17QqIMZBRGsQiFR3mtf00sg&usqp=CAE"
                                    class="card-img-top img-fluid" alt="...">
                                <div class="card-body ">
                                    <p class="card-text text-center">Printers</p>
                                    <strong class="card-text ct">Upto 80% off</strong>
                                </div>
                            </div>
                            <div class="card">
                                <img src="https://encrypted-tbn0.gstatic.com/shopping?q=tbn:ANd9GcQPmJhne-b2fGt-g6t9qCGNDe78_WmLw_5NgcqkSXTHZ6QM7dl06F9p7KuDuHBcURYmI6S6WBXOwptTfjslSSkwtdKFm08S-0Y0OIBbs8k-yNg_EIofyGtH&usqp=CAE"
                                    class="card-img-top " alt="...">
                                <div class="card-body ">
                                    <p class="card-text text-center">Watches</p>
                                    <strong class="card-text ct">Upto 70% off</strong>
                                </div>
                            </div>
                            <div class="card">
                                <img src="https://encrypted-tbn3.gstatic.com/shopping?q=tbn:ANd9GcSb-ILaW9XaBYD_pH3a0JhH6jRmAkWKQQ-lNxEpeNHyCpg7yCTBSo8JaM2xnVINuQlSBxZrLObNaM39fYEjoIJ6O7YM2zcMeqv7HvwE7osvtOwn2m65N-_QGQ&usqp=CAE"
                                    class="card-img-top img-fluid" alt="...">
                                <div class="card-body ">
                                    <p class="card-text text-center">Monito</p>
                                    <strong class="card-text ct">Upto 70% off</strong>
                                </div>
                            </div>
                            <div class="card">
                                <img src="https://encrypted-tbn3.gstatic.com/shopping?q=tbn:ANd9GcTt-oorsWvG_ABWCWtvhWBet7nIo6e7ANlJ44HlFzB25rqxNSZYCZYtiuGMWpBcxJwW9suYxHfsi59z-Prg40rg3MwijdD9Dw&usqp=CAE"
                                    class="card-img-top img-fluid" alt="...">
                                <div class="card-body ">
                                    <p class="card-text text-center">Camera</p>
                                    <strong class="card-text ct">Upto 70% off</strong>
                                </div>
                            </div>
                            <div class="card">
                                <img src="https://encrypted-tbn2.gstatic.com/shopping?q=tbn:ANd9GcTucIBakKbROvB0EY8q1ilYOOhF9zBJLlYHxxK-gjqAY52jcl_ByztL8riZPmEZZsWLr_meukCxUF0WNZpVhphX5mMCIxYu4WULl1ieOVwDYvKYKEIWjXd7&usqp=CAEE"
                                    class="card-img-top mb-5" alt="...">
                                <div class="card-body ">
                                    <p class="card-text text-center">Projector</p>
                                    <strong class="card-text ct">Upto 40% off</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dn">
                        <div>
                            <img src="https://rukminim1.flixcart.com/fk-p-flap/260/810/image/d5d599c240c9b2ea.jpeg?q=20"
                                alt="" class="img-fluid img-dis">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container bg-light mt-3 p-2">
        <div class="row ms-2">
            <h4>Instruments & more</h4>
        </div>
        <div class="container instruments bg-light">
            <div class="initial-items-list">
                <div class="row">
                    <div class="d-flex">
                        <div class="cards-wrapper">
                            <div class="card">
                                <img src="https://rukminim2.flixcart.com/image/612/612/xif0q/acoustic-guitar/a/l/z/rvl-38c-lgp-bk-revel-original-imah6gtbgdxmurwc.jpeg?q=70"
                                    class="card-img-top" alt="...">
                                <div class="card-body">
                                    <p class="card-title text-center">Guitar</p>
                                    <h4 class="card-text text-center">Grab Now*</h4>
                                </div>
                            </div>
                            <div class="card">
                                <img src="https://rukminim2.flixcart.com/image/612/612/xif0q/violin/t/j/h/retfchcgc-sg-musical-original-imah5agqrmzj64vu.jpeg?q=70"
                                    class="card-img-top" alt="...">
                                <div class="card-body">
                                    <p class="card-title text-center">Classical Violin
                                    <p>
                                    <h4 class="card-text text-center">From $2066</h4>
                                </div>
                            </div>
                            <div class="card mt-1">
                                <img src="https://rukminim2.flixcart.com/image/612/612/xif0q/ukulele-string/m/b/l/10-acoustic-guitar-strings-stainless-steel-with-4-picks-amg-original-imah6fctahbjrrhf.jpeg?q=70"
                                    class="card-img-top" alt="...">
                                <div class="card-body">
                                    <p class="card-title text-center mt-3">Guitar string</p>
                                    <h4 class="card-text text-center">$234<h4>
                                </div>
                            </div>
                            <div class="card mt-1">
                                <img src="https://rukminim2.flixcart.com/image/612/612/keokpe80/flute/q/j/e/c-sharp-l-foxit-original-imafvby6xpqym74h.jpeg?q=70"
                                    class="card-img-top" alt="...">
                                <div class="card-body mt-4">
                                    <p class="card-text text-center mt-4">Flute</p>
                                    <h4 class="card-title text-center">$5436</h4>
                                </div>
                            </div>
                            <div class="card mt-1">
                                <img src="https://rukminim2.flixcart.com/image/612/612/xif0q/musical-keyboard/c/n/o/37-0-45-430a2-joyfun-original-imah8bz6azgzjusn.jpeg?q=70"
                                    class="card-img-top" alt="...">
                                <div class="card-body mt-4">
                                    <p class="card-title text-center mt-4">Piano</p>
                                    <h4 class="card-text text-center">$234<h4>
                                </div>
                            </div>
                            <div class="card mt-1">
                                <img src="https://rukminim2.flixcart.com/image/612/612/k2nmaa80/tabla/a/b/p/professional-akshar-tabla-mart-original-imafhhx3uhsupuah.jpeg?q=70"
                                    class="card-img-top" alt="...">
                                <div class="card-body mt-5">
                                    <p class="card-text text-center">Tabla</p>
                                    <h4 class="card-title text-center">$5436</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container bg-light mt-3 p-2" id="adding">
    </div>
    <div class="container-fluid footer">
        <div class="container">
            <div class="row">
                <div class="col-md-3 quick-links">
                    <h5>Quick Links</h5>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Products</a></li>
                        <li><a href="#">Offers</a></li>
                        <li><a href="#">Cart</a></li>
                        <li><a href="#">Account</a></li>
                    </ul>
                </div>
                <div class="col-md-3 info-links">
                    <h5>Information</h5>
                    <ul>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                    </ul>
                </div>
                <div class="col-md-3 social-icons">
                    <h5>Follow Us</h5>
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
                <div class="col-md-3">
                    <h5>Contact Information</h5>
                    <ul>
                        <li><a href="#">Email: support@flipkart.com</a></li>
                        <li><a href="#">Phone: 1800-123-4567</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="row">
                <div class="col-12 text-center">
                    <p>&copy; 2025 Flipkart. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="/assests/js/flipkart.js"></script>
    <!-- <script src="/frontend/FlipkartHomePage/jquery/index2.js"></script> -->
</body>

</html>