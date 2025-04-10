
$(document).ready(function () {
    getcartdata();
});

function getcartdata() {
    const cartList = document.getElementById('add-items');

    if (!cartList) {
        console.error("Element #add-items not found in the DOM.");
        return;
    }

    $.ajax({
        type: "GET",
        url: "/includes/fetch-cart.php",
        dataType: "json",
        success: function (response) {
            cartList.innerHTML = '';
            if (response.length === 0) {
                cartList.innerHTML = '<p class="text-center text-muted">No items found</p>';
                return;
            }
            let total_item = response.length
            const row = document.createElement('div');
            row.classList.add('row', 'g-3');

            let totalprice = 0;
            response.forEach(cart => {
                let discountedprice = cart.product_price - (cart.product_price * cart.discount) / 100;
                let price = cart.quantity * discountedprice;
                totalprice += price;

                const col = document.createElement('div');
                col.classList.add('col-md-4', 'd-flex');

                col.innerHTML = `
                    <div class="card w-100 shadow-sm rounded-lg p-3">
                        <img src="/upload-image/${cart.product_image}" class="img-fluid rounded-3" alt="Product Image">
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold">${cart.product_name}</h5>
                             <p class="text-muted mb-2">
                                <span class="fw-bold text-success">$price = ${discountedprice.toFixed(2)}</span>
                            </p>
                            <div class="d-flex justify-content-center align-items-center gap-2 my-2">
                                <button class="btn btn-sm btn-outline-secondary px-2 decrement-item" data-cart-id="${cart.cart_id}">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input id="form1" min="1" name="quantity" value="${cart.quantity}" type="number" class="form-control form-control-sm text-center w-50" readonly />
                                <button class="btn btn-sm btn-outline-primary px-2 increment-item" data-cart-id="${cart.cart_id}">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <p class="text-muted mb-2">
                                <span class="fw-bold text-success">$total price = ${price.toFixed(2)}</span>
                            </p>
                            <button class="btn btn-danger w-100 fw-bold py-2 remove_cart" data-cart-id="${cart.cart_id}">Remove</button>
                        </div>
                    </div>
                `;
                row.appendChild(col);
            });
            cartList.appendChild(row);

            $('#numberofitem').html(total_item)
            $('#totalprice').html(totalprice.toFixed(2));
            $('#totalamount').html(totalprice.toFixed(2))

            $(".remove_cart").click(deletecart);
            $(".decrement-item").click(decrementitem);
            $(".increment-item").click(incrementitem);
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.error("Response Text:", xhr.responseText);
            alert("Error fetching cart data: " + error);
        }
    });
}

function deletecart(event) {
    let del_cart_id = $(this).data('cart-id');
    $.ajax({
        type: "POST",
        url: "/includes/delete-cart.php",
        data: { cart_id: del_cart_id },
        dataType: "json",
        success: function (response) {
            getcartdata();
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
            alert("Error removing item from cart: " + error);
        }
    });
}

function decrementitem(event) {
    let decrement_id = $(this).data('cart-id');

    $.ajax({
        type: "POST",
        url: "/includes/decrement-item.php",
        data: { cart_id: decrement_id },
        dataType: "json",
        success: function (response) {
            console.log(response);

            if (response.success) {
                if (response.cartDetail && response.cartDetail.quantity > 0) {

                    getcartdata();
                } else {
                    getcartdata();
                }
            } else {
                alert("Failed: " + response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
            alert("Error decrementing item in cart: " + error);
        }
    });
}



function incrementitem(event) {
    event.preventDefault();
    let increment_id = $(this).data('cart-id');
    $.ajax({
        type: "POST",
        url: "/includes/increment-item.php",
        data: { cart_id: increment_id },
        dataType: "json",
        success: function (response) {
            if (response.success) {
                getcartdata();
            } else {
                alert(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
            alert("Error incrementing item in cart: " + error);
        }
    });
}

document.getElementById("payment").addEventListener("click", async function (e) {
    console.log("clicked");
    e.preventDefault();

    let totalprice = parseFloat($('#totalprice').text());

    try {
       
        let response = await fetch("/includes/payment/checkout.php", {
            method: "POST",
            datatype: "json",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ totalAmount: totalprice })
        });

        let data = await response.json();

        if (data.url) {
            window.location.href = data.url;
        } else {
            alert(data.error || "Unexpected error");
        }

    } catch (fetchError) {
        console.error("Fetch error:", fetchError);
        alert("Fetch request failed. Check console for details.");
    }
});

