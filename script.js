function showEditForm(prod_code) {
    // Show the edit form
    document.getElementById('edit-form').style.display = 'block';

    // Fetch product details and populate the form
    fetch('get_product.php?prod_code=' + prod_code)
        .then(response => response.json())
        .then(data => {
            if (!data.error) {
                document.getElementById('edit-product-id').value = data.prod_code;
                document.getElementById('edit-prod_name').value = data.prod_name;
                document.getElementById('edit-discription').value = data.discription;
                document.getElementById('edit-supplier').value = data.supplier;
                document.getElementById('edit-quantity').value = data.quantity;
                document.getElementById('edit-price').value = data.price;
                // For image, you may need to handle it differently if you want to show the image preview
            } else {
                console.error(data.error);
                alert('Error fetching product details.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error fetching product details.');
        });
}
