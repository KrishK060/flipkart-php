<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("location: /assests/html/signin.php");
    exit();
}

if ($_SESSION["user_role"] === "user") {
    echo '<script>
        window.onload = function() {
            const adminElements = document.querySelectorAll(".admin");
            adminElements.forEach(el => el.style.display = "none");
        };
    </script>';
}

?>