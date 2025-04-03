$(document).ready(function () {
    fetchorder();
});

function fetchorder(){
    const cartList = document.getElementById('orderlist-item');

    if (!cartList) {
        console.error("Element #add-items not found in the DOM.");
        return;
    }

    $.ajax({
        type: "GET",
        url: "/fetch-orderlist.php",
        dataType: "json",
        success: function (response) {
            console.log(response)
            cartList.innerHTML = '';
            if (response.length === 0) {
                cartList.innerHTML = '<p class="text-center text-muted">No items found</p>';
                return;
            }
            let total_item = response.length
            const row = document.createElement('div');
            row.classList.add('row', 'g-3');

            
            response.forEach(orderlist => {
                let discountedprice = orderlist.product_price - (orderlist.product_price * orderlist.product_discount) / 100;
                let price = orderlist.ordered_quantity * discountedprice;
              

                const col = document.createElement('div');
                col.classList.add('col-md-4', 'd-flex');

                col.innerHTML = `
                    <div class="card w-100 shadow-sm rounded-lg p-3">
                     <h5 class="card-title fw-bold">Order ID : ${orderlist.order_id}</h5>
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold">${orderlist.product_name}</h5>
                             <p class="text-muted mb-2">
                                <span class="fw-bold">price = ${discountedprice.toFixed(2)}</span>
                            </p>
                           <p class="text-muted mb-2">
                                <span class="fw-bold">total quantity = ${orderlist.ordered_quantity} </span>
                            </p>
                            <p class="text-muted mb-2">
                                <span class="fw-bold">total price = ${price.toFixed(2)}</span>
                            </p>
                        </div>
                    </div>
                `;
                row.appendChild(col);
            });
            cartList.appendChild(row);
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.error("Response Text:", xhr.responseText);
            alert("Error fetching cart data: " + error);
        }
    });
}
