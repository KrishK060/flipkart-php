$(document).ready(function () {
    $("#signup-form").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            username: {
                required: true,
            },
            password: {
                required: true
            },
            confirm_password: {
                required: true,
                equalTo: "#psw"
            },
            dob: {
                required: true
            },
            phone_number: {
                required: true,
                minlength: 10,
                maxlength: 10
            }
        },
        messages: {
            email: {
                required: "Please enter your email",
                email: "Please enter a valid email address"
            },
            username: {
                required: "Please enter your username"
            },
            password: {
                required: "Please enter your password"
            },
            confirm_password: {
                required: "Please confirm your password",
                equalTo: "Passwords do not match"
            },
            dob: {
                required: "Please select your date of birth"
            },
            phone_number: {
                required: "Please enter your phone number",
                minlength: "Phone number must be exactly 10 digits",
                maxlength: "Phone number must be exactly 10 digits"
            }
        },
    });
});
