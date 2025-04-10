$(document).ready(function () {
    getdata();
});
function getdata() {
    $.ajax({
        type: "GET",
        url: "/includes/fetch-category.php",
        success: function (response) {
            $.each(response, function (key, value) {
                $('#table tbody').append('<tr>' +
                    '<td class="stud_id" id="category_id">' + value['category_id'] + '</td>\
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

    document.getElementById('cname').value = current_category_name;
    document.getElementById('category_id').value = new_category_id;
    $("#form").off("submit").on("submit", function (e) {
        e.preventDefault();

        let new_category_name = document.getElementById('cname').value.trim();
        let category_id = document.getElementById('category_id').value;
        $.ajax({
            type: "POST",
            url: "/includes/update-category.php",
            data: {
                category_id: category_id,
                cname: new_category_name
            },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    alert(response.message);
                    $('#table tbody').empty();
                    getdata();
                    window.location.reload();
                } else {
                    console.log(response);
                    $('#custome_error').text(response['message']);
                }
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
    $.ajax({
        type: "POST",
        url: "/includes/delete-category.php",
        data: { category_id: del_category_id },
        dataType: "json",
        success: function (response) {
            if (response.success) {
                window.location.reload();
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.error("Response Text:", xhr.responseText);
            alert("Error updating category: " + error);
        }
    });
}

