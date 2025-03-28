$(document).ready(function () {

    fetchProductData();
});
function fetchProductData() {
    const productList = document.getElementById('adding');

    if (!productList) {
        console.error("Element #adding not found in the DOM.");
        return;
    }

    $.ajax({
        type: "GET",
        url: "/backend/fetch-product3.php",
        dataType: "json",
        success: function (response) {
            console.log(response)
            
            productList.innerHTML = '';
            let rowsCategory = {};

            if (response.length === 0) {
                productList.innerHTML = '<p>No products found</p>';
                return;
            }

            response.forEach(product => {
                if(product.product_avalaible == "avalaible"){
                    let categoryID = product.category_name;
                let categoryName = ` ${categoryID}`;

                if (!rowsCategory[categoryID]) {
                    const container = document.createElement('div');
                    container.classList.add('container', 'bg-light', 'mt-3', 'p-2');

                    const categoryHeading = document.createElement('h4');
                    categoryHeading.textContent = categoryName;
                    container.appendChild(categoryHeading);

                    const categoryRow = document.createElement('div');
                    categoryRow.classList.add('row', 'g-3');
                    categoryRow.setAttribute('id', `row-${categoryID}`);

                    container.appendChild(categoryRow);
                    productList.appendChild(container);

                    rowsCategory[categoryID] = categoryRow;
                }
                let discount = (product.product_price)-(product.product_price * product.discount)/100;
                console.log(discount);
                const col = document.createElement('div');
                col.classList.add('col-md-4', 'd-flex');

                col.innerHTML = `
                    <div class="card w-100">
                       <img src="/frontend/${product.product_image}" class="card-img-top" alt="${product.product_name}">
                        <div class="card-body">
                            <h5 class="card-title text-center">${product.product_name}</h5>
                            <p class="card-text">
                            <del>${product.product_price}</del> 
                            <ins class="font-weight-bold">
                            $${(product.product_price - (product.product_price * product.discount / 100)).toFixed(2)}
                            (discount of ${product.discount}%)
                            </ins>
                            </p>
                            <p class="card-text">${product.product_description}</p>
                        </div>
                    </div>
                `;
                rowsCategory[categoryID].appendChild(col);
                 }
                 
                    
                
            });

          
           
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.error("Response Text:", xhr.responseText);
            alert("Error fetching products: " + error);
        }
    });
}