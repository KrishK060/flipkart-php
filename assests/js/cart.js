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
        url: "/fetch-cart.php",
        dataType: "json",
        success: function (response) {
            console.log(response);

            cartList.innerHTML = '';

            if (response.length === 0) {
                cartList.innerHTML = '<p class="text-center text-muted">No items found</p>';
                return;
            }

           
            const row = document.createElement('div');
            row.classList.add('row', 'g-3'); 

            response.forEach(cart => {
                let discount = cart.product_price - (cart.product_price * cart.discount) / 100;

                const col = document.createElement('div');
                col.classList.add('col-md-4', 'd-flex');

                col.innerHTML = `
                    <div class="card w-100 shadow-sm rounded-lg p-3">
                        <img src="/upload-image/${cart.product_image}" class="img-fluid rounded-3" alt="Product Image">
                        
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold">${cart.product_name}</h5>
                            
                            <div class="d-flex justify-content-center align-items-center gap-2 my-2">
                                <button class="btn btn-sm btn-outline-secondary px-2"><i class="fas fa-minus"></i></button>
                                <input id="form1" min="1" name="quantity" value="2" type="number" 
                                    class="form-control form-control-sm text-center w-50" />
                                <button class="btn btn-sm btn-outline-primary px-2"><i class="fas fa-plus"></i></button>
                            </div>

                            <p class="text-muted mb-2"> 
                                <span class="fw-bold text-success">$${discount.toFixed(2)}</span>
                            </p>

                            <button class="btn btn-danger w-100 fw-bold py-2 remove_cart" data-cart-id="${cart.cart_id}">Remove</button>
                        </div>
                    </div>
                `;

                row.appendChild(col); 
            });

            cartList.appendChild(row);
            $(".remove_cart").click(deletecart);
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.error("Response Text:", xhr.responseText);
            alert("Error fetching cart data: " + error);
        }
    });
}
function deletecart(event){
    event.preventDefault();
    let del_cart_id = $(this).data('cart-id');
    console.log(del_cart_id);
    $.ajax({
        type: "POST",
        url: "/delete-cart.php",
        data: { cart_id: del_cart_id },
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