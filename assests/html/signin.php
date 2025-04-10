<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & signup</title>
    <link rel="stylesheet" href="/assests/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>
    <div class="loginpage">
        <marquee class="marq">welcome to login page!!</marquee>
        <div class="inputs">
            <a href="#" class="btn" id="signin" style="border: 5px solid black;"><i class="fa-solid fa-user"
                    style="margin: 0 10px;"></i>Login</a>
            <a href="/assests/html/signup.php" class="btn" id="signup" style="border: 5px solid black;"><i
                    class="fa-solid fa-user-plus" style="margin: 0 5px;"></i>Signup</a>
        </div>
        <?php
        session_start();
        if (isset($_SESSION['login_error'])) {
            echo '<div class="error" style="color: red; margin-bottom: 10px;">' . $_SESSION['login_error'] . '</div>';
            unset($_SESSION['login_error']);
        }
        ?>
        <form action="/login.php" method="POST" class="input-form" id="login-form">
            <div>
                <div class="userinputs">
                    <i class="fa-solid fa-user" style="margin: 0 5px;"></i>
                    <input type="text" class="usr" id="usr" placeholder="username" name="username">
                </div>
                <label id="usr-error" class="error" for="usr"></label>
            </div>
            <div>
                <div class="userinputs">
                    <i class="fa-solid fa-lock" style="margin: 0 5px;"></i>
                    <input type="password" class="psw" id="psw" placeholder="password" name="password">
                </div>
                <label id="psw-error" class="error" for="psw"></label>
            </div>

            <a href="#" class="forgot">forgot password?</a>

            <div class="rem">
                <input type="checkbox" class="check" id="check" name="">
                <label for="check">Remember me</label>
            </div>

            <div class="inputs">
                <input type="submit" class="btn1" id="btn1d" value="Login">
            </div>

        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="/assests/js/login.js"></script>

</body>

</html>