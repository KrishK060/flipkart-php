$(document).ready(function () {
    fetchorder();
});

function fetchorder() {
    const cartList = document.getElementById('orderlist-item');
    if (!cartList) {
        console.error("Element #orderlist-item not found in the DOM.");
        return;
    }

    $.ajax({
        type: "GET",
        url: "/includes/fetch-orderlist.php",
        dataType: "json",
        success: function (response) {
            if (response.length === 0) {
                cartList.innerHTML = '<p class="text-center text-muted">No items found</p>';
                return;
            }

            const table = document.createElement('table');
            table.className = "table table-bordered table-striped";

            table.innerHTML = `
                <thead class="table-dark">
                    <tr>
                        <th>Order ID</th>
                        <th>Product Name</th>
                        <th>Price (after discount)</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody></tbody>
            `;

            const tbody = table.querySelector('tbody');
            response.forEach(orderlist => {
                let discountedprice = orderlist.product_price - (orderlist.product_price * orderlist.product_discount) / 100;
                let price = orderlist.ordered_quantity * discountedprice;

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${orderlist.order_id}</td>
                    <td>${orderlist.product_name}</td>
                    <td>${discountedprice.toFixed(2)}</td>
                    <td>${orderlist.ordered_quantity}</td>
                    <td>${price.toFixed(2)}</td>
                `;
                tbody.appendChild(row);
            });
            cartList.appendChild(table);
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.error("Response Text:", xhr.responseText);
            alert("Error fetching cart data: " + error);
        }
    });
}
