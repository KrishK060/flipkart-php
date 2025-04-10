$(document).ready(function () {
    get_cetagory_data();
    display_data();
});
function get_cetagory_data() {
    $.ajax({
        type: "GET",
        url: "/fetch-category.php",
        dataType: "json",
        success: function (response) {
            $('#category').empty();
            $.each(response, function (key, value) {
                $('#category').append(
                    ` <option value="${value.category_id}" data-val="${key}" >${value.category_name}</option>`
                )
            })
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.error("Response Text:", xhr.responseText);
            alert("Error fetching products: " + error);
        }
    });
}

function display_data() {
    $.ajax({
        type: "GET",
        url: "/fetch-product2.php",
        dataType: "json",
        success: function (response) {
            $.each(response, function (key, value) {
                $('#table tbody').append(
                    '<tr>' +
                    '<td class="stud_id">' + value['product_id'] + '</td>' +
                    '<td>' + value['product_name'] + '</td>' +
                    '<td><img src="/upload-image/' + value['product_image'] + '" width="100px" alt="img"></td>' +
                    '<td>' + value['product_price'] + '</td>' +
                    '<td>' + value['discount'] + '</td>' +
                    '<td>' + value['product_description'] + '</td>' +
                    '<td>' + value['product_category'] + '</td>' +
                    '<td>' + value['product_avalaible'] + '</td>' +
                    '<td>' + value['product_stock'] + '</td>' +
                    '<td>\
                            <a href="#" class="btn btn-sm btn-primary edit_btn" data-id="' + value['product_id'] + '" data-name="' + value['product_name'] + '" data-image="' + value['product_image'] + '" data-price="' + value['product_price'] + '" data-description="' + value['product_description'] + '" data-category="' + value['product_category'] + '"data-avability="' + value['product_avalaible'] + '"data-discount="' + value['discount'] + '"data-stock="' + value['product_stock'] + '">EDIT</a>\
                            <a href="#" class="btn btn-sm btn-danger delete_btn" data-id="' + value['product_id'] + '">DELETE</a>\
                        </td>' +
                    '</tr>'
                );
            })
            $(".edit_btn").click(updatedata);
            $(".delete_btn").click(deleteproduct);
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.error("Response Text:", xhr.responseText);
            alert("Error fetching products: " + error);
        }
    });
}
function updatedata(event) {
    let new_product_id = $(this).data('id');
    let current_product_name = $(this).data('name');
    let current_product_image = $(this).data('image');
    let current_product_price = $(this).data('price');
    let current_product_description = $(this).data('description');
    let current_product_category = $(this).data('category');
    let current_product_avability = $(this).data('avability');
    let current_product_discount = $(this).data('discount');
    let current_product_stock = $(this).data('stock')

    const productInput = document.getElementById('pname');
    productInput.value = current_product_name;

    const product_price_Input = document.getElementById('pprice');
    product_price_Input.value = current_product_price;

    const product_description_Input = document.getElementById('ptext');
    product_description_Input.value = current_product_description;

    const product_category_Input = document.getElementById('category');
    $(product_category_Input).val(current_product_category).change();

    const product_avability_Input = document.getElementById('avability');
    $(product_avability_Input).val(current_product_avability).change();

    const product_discount_Input = document.getElementById('pdiscount');
    product_discount_Input.value = current_product_discount;

    const product_stock_Input = document.getElementById('pstock');
    product_stock_Input.value = current_product_stock;


    $("#form").off("submit").on("submit", function (e) {
        e.preventDefault();
        let new_product_name = productInput.value.trim();
        let new_product_price = product_price_Input.value.trim();
        let new_product_description = product_description_Input.value.trim();
        let new_product_category = product_category_Input.value.trim();
        let new_product_avability = product_avability_Input.value.trim();
        let new_product_discount = product_discount_Input.value
        let new_product_stock = product_stock_Input.value
        let new_product_image = $("#pimg")[0].files[0];

        let formData = new FormData();
        formData.append("product_id", new_product_id);
        formData.append("pname", new_product_name);
        formData.append("pprice", new_product_price);
        formData.append("ptext", new_product_description);
        formData.append("pcategory", new_product_category);
        formData.append("avability", new_product_avability);
        formData.append("pdiscount", new_product_discount)
        formData.append("pstock", new_product_stock);

        if (new_product_image) {
            formData.append("pimg", new_product_image);
        }

        $.ajax({
            type: "POST",
            url: "/update-product.php",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    alert(response.message);
                    $('#table tbody').empty();
                    display_data();
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

function deleteproduct(event) {
    event.preventDefault();
    let del_product_id = $(this).data('id');
    $.ajax({
        type: "POST",
        url: "/delete-product.php",
        data: { product_id: del_product_id },
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
