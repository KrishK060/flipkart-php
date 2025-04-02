$(document).ready(function () {
    getdata();
});
function getdata() {
    $.ajax({
        type: "GET",
        url: "/fetch-category.php",
        success: function (response) {
            $.each(response, function (key, value) {
                $('#table tbody').append('<tr>' +
                    '<td class="stud_id">' + value['category_id'] + '</td>\
                    <td>'+ value['category_name'] + '</td>\
                    <td>\
                         <a href="#" class="btn btn-sm btn-primary edit_btn" data-id="' + value['category_id'] + '" data-name="' + value['category_name'] + '">EDIT</a>\
                        <a href="#" class="btn btn-sm btn-danger delete_btn" data-id="' + value['category_id'] + '">DELETE</a>\
                    </td>\
                </tr>');
            })
            $(".edit_btn").click(updatedata);
            $(".delete_btn").click(deletecategory);
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.error("Response Text:", xhr.responseText);
            alert("Error fetching products: " + error);
        }
    });
}

function updatedata(event) {
    event.preventDefault();

    var new_category_id = $(this).data('id');
    var current_category_name = $(this).data('name');

    console.log("Category ID:", new_category_id);
    console.log("Current Name:", current_category_name);

    let categoryInput = document.getElementById('cname');
    categoryInput.value = current_category_name;

    $("#form").off("submit").on("submit", function (e) {
        e.preventDefault();

        let new_category_name = categoryInput.value.trim();

        if (!new_category_name) {
            alert("Update cancelled or invalid input.");
            return;
        }

        $.ajax({
            type: "POST",
            url: "/update-category.php",
            data: { category_id: new_category_id, cname: new_category_name },
            dataType: "json",
            success: function (response) {
                console.log("Server Response:", response);
                alert(response.message);

                $('#table tbody').empty();
                getdata();
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
                console.error("Response Text:", xhr.responseText);
                alert("Error updating category: " + error);
            }
        });
    });
}

function deletecategory(event) {
    event.preventDefault();
    var del_category_id = $(this).data('id');
    console.log(del_category_id)
    $.ajax({
        type: "POST",
        url: "/delete-category.php",
        data: { category_id: del_category_id },
        dataType: "json",
        success: function (response) {
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.error("Response Text:", xhr.responseText);
            alert("Error updating category: " + error);
        }
    });
}

