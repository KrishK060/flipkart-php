$(document).ready(function () {
    $("#form").validate({
        rules: {
            cname: {
                required: true,
            }
        },
        messages: {
            cname: {
                required: "Please enter category"
            }
        },
    });
});
