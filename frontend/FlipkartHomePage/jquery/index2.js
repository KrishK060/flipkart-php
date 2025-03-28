$(document).ready(function () {
    get_cetagory_data();
    display_data();
});
function get_cetagory_data() {
    $.ajax({
        type: "GET",
        url: "/backend/fetch-product.php",
        dataType: "json",
        success: function (response) {
            // console.log(response)
            $('#category').empty();
            $.each(response, function (key, value) {
                // console.log(key,value);

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
    // event.preventDefault();
    $.ajax({
        type: "GET",
        url: "/backend/fetch-product2.php",
        dataType: "json",
        success: function (response) {
            // console.log(response);
            $.each(response, function (key, value) {
                // console.log(key, value);
                $('#table tbody').append(
                    '<tr>' +
                        '<td class="stud_id">' + value['product_id'] + '</td>' +
                        '<td>' + value['product_name'] + '</td>' +
                        '<td><img src="/frontend/' + value['product_image'] + '" width="100px" alt="img"></td>' +
                        '<td>' + value['product_price'] + '</td>' +
                        '<td>' + value['discount'] + '</td>' +
                        '<td>' + value['product_description'] + '</td>' +
                        '<td>' + value['product_category'] + '</td>' +
                        '<td>' + value['product_avalaible'] + '</td>' +
                        '<td>\
                            <a href="#" class="btn btn-sm btn-primary edit_btn" data-id="' + value['product_id'] + '" data-name="' + value['product_name'] + '" data-image="' + value['product_image'] +'" data-price="' + value['product_price'] + '" data-description="' + value['product_description'] + '" data-category="' + value['product_category'] + '"data-avability="' + value['product_avalaible'] + '"data-discount="' + value['discount'] + '">EDIT</a>\
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
    event.preventDefault();

    var new_product_id = $(this).data('id');
    var current_product_name = $(this).data('name');
    var current_product_image = $(this).data('image');  
    var current_product_price = $(this).data('price');
    var current_product_description = $(this).data('description');
    var current_product_category = $(this).data('category');
    var current_product_avability = $(this).data('avability');
    var current_product_discount = $(this).data('discount');
    console.log(current_product_discount)

    // console.log("Product ID:", new_product_id);
    // console.log("Product Name:", current_product_name);
    // console.log("Product Image:", current_product_image);
    // console.log("Product Price:", current_product_price);
    // console.log("Product Description:", current_product_description);
    console.log("Product Category:", current_product_category);
    console.log(current_product_name)
    console.log(current_product_avability)

    let productInput = document.getElementById('pname');
    productInput.value = current_product_name;

    let product_price_Input = document.getElementById('pprice');
    product_price_Input.value = current_product_price;

    let product_description_Input = document.getElementById('ptext');
    product_description_Input.value = current_product_description;

    let product_category_Input = document.getElementById('category');
    $(product_category_Input).val(current_product_category).change(); 

    let product_avability_Input = document.getElementById('avability');
    $(product_avability_Input).val(current_product_avability).change(); 

    let product_discount_Input = document.getElementById('pdiscount');
    product_discount_Input.value = current_product_discount;
    

    $("#form").off("submit").on("submit", function (e) {
        e.preventDefault();

        let new_product_name = productInput.value.trim();
        let new_product_price = product_price_Input.value.trim();
        let new_product_description = product_description_Input.value.trim();
        let new_product_category = product_category_Input.value.trim();
        let new_product_avability = product_avability_Input.value.trim();
        let new_product_discount = product_discount_Input.value
        let new_product_image = $("#pimg")[0].files[0]; 
        console.log("new : ",new_product_image)
        if (!new_product_name || !new_product_price || !new_product_description || !new_product_category || !new_product_avability || !new_product_discount) {
            alert("Update cancelled or invalid input.");
            return;
        }

        let formData = new FormData();
        formData.append("product_id", new_product_id);
        formData.append("pname", new_product_name);
        formData.append("pprice", new_product_price);
        formData.append("ptext", new_product_description);
        formData.append("category", new_product_category);
        formData.append("avability",new_product_avability);
        formData.append("pdiscount",new_product_discount)

        if (new_product_image) {
            console.log("dfgnhfg");
            formData.append("pimg", new_product_image); 
        }
        console.log(new_product_image)

        $.ajax({
            type: "POST",
            url: "/backend/update-product.php",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                console.log("Server Response:", response);
                alert(response.message);
                $('#table tbody').empty();
                display_data(); 
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
                console.error("Response Text:", xhr.responseText);
                alert("Error updating category: " + error);
            }
        });
    });
}
function deleteproduct(event){
    event.preventDefault();
    let del_product_id = $(this).data('id');
    console.log(del_product_id);
    $.ajax({
        type: "POST",
        url: "/backend/delete-product.php",
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





  
