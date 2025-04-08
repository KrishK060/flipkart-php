$(document).ready(function () {
    $("#login-form").validate({
        rules: {
            username: {
                required: true,

            },
            password: {
                required: true,

            }
        },
        messages: {
            username: {
                required: "Please enter your username",

            },
            password: {
                required: "Please enter your password",

            }
        },
    });
});
