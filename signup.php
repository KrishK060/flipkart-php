<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & signup</title>
    <link rel="stylesheet" href="/assests/css/signup.css">
    <link rel="stylesheet" href="/assests/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>
    <div class="loginpage">
        <div class="inputs">
            <a href="signin" class="btn" id="sign-in"><i class="fa-solid fa-user"
                    style="margin: 0 5px;"></i>Login</a>
            <a href="#" class="btn" id="signup"><i class="fa-solid fa-user-plus" style="margin: 0 5px;"></i>Signup</a>
        </div>
        <form action="/includes/signup.php" class="input-form" method="post" id="signup-form">
            <div>
                <div class="userinputs">
                    <i class="fa-regular fa-envelope icons"></i>
                    <input type="email" class="usr" id="email" placeholder="email" name="email">
                </div>
                <label id="email-error" class="error" for="email"></label>
            </div>
            <div>
                <div class="userinputs">
                    <i class="fa-solid fa-user icons"></i>
                    <input type="text" class="usr" id="usr" placeholder="username" name="username">
                </div>
                <label id="usr-error" class="error" for="usr"></label>
            </div>
            <div>
                <div class="userinputs">
                    <i class="fa-solid fa-lock icons"></i>
                    <input type="password" class="psw" id="psw" placeholder="password" name="password">
                </div>
                <label id="psw-error" class="error" for="psw"></label>
            </div>
            <div>
                <div class="userinputs">
                    <i class="fa-solid fa-lock icons"></i>
                    <input type="password" class="psw" id="cpsw" placeholder="confirm password" name="confirm_password">
                </div>
                <label id="cpsw-error" class="error" for="cpsw"></label>
            </div>
            <div>
                <div class="userinputs">
                    <i class="fa-solid fa-calendar-days icons"></i><input type="date" class="usr" id="birthday"
                        placeholder="DOB" name="dob">
                </div>
                <label id="birthday" class="error" for="birthday"></label>
            </div>
            <div>
                <div class="userinputs">
                    <i class="fa-solid fa-phone icons"></i><input type="number" class="usr" id="phone-number"
                        pattern="[0-9]{10}" placeholder="phone number" name="phone_number">
                </div>
                <label id="phone-number" class="error" for="phone-number"></label>
            </div>
            <div class="rem">
                <input type="checkbox" class="check" id="check" name="">
                <label for="check">Accept terms and conditions</label>
            </div>

            <div class="inputs">
                <input type="submit" class="btn1" id="signin-btn" value="Signup">
            </div>

        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="/assests/js/signup.js"></script>

</body>

</html>