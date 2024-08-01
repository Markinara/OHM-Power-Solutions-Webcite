function showEditForm(prod_code) {
    // Fetch product details using AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "get_product.php?prod_code=" + prod_code, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var product = JSON.parse(xhr.responseText);
            if (product.error) {
                alert(product.error);
            } else {
                // Fill the form with product details
                document.getElementById("edit-product-id").value = product.prod_code;
                document.getElementById("edit-prod_name").value = product.prod_name;
                document.getElementById("edit-description").value = product.description;
                // Image handling can be complex, setting required attribute for now
                document.getElementById("edit-supplier").value = product.supplier;
                document.getElementById("edit-quantity").value = product.quantity;
                document.getElementById("edit-price").value = product.price;

                // Show the form
                document.getElementById("edit-form").style.display = "block";
            }
        } else {
            alert("Error fetching product details.");
        }
    };
    xhr.send();
}

function deleteItem(prod_code) {
    // Подтверждение удаления
    if (confirm('Are you sure you want to delete this product?')) {
        // Создание объекта FormData и добавление prod_code
        let formData = new FormData();
        formData.append('prod_code', prod_code);

        // Отправка запроса на удаление
        fetch('delete_product.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text()) // Чтение ответа как текст
        .then(result => {
            console.log('Server response:', result); // Добавьте эту строку для отладки
            if (result.includes('successfully')) {
                alert(result); // Показываем сообщение о успешном удалении
                location.reload(); // Обновляем страницу после успешного удаления
            } else {
                alert('An error occurred while deleting the product: ' + result); // Показ сообщения об ошибке
            }
        })
        .catch(error => {
            console.error('Error while deleting the product:', error);
            alert('An error occurred while deleting the product.'); // Показ сообщения об ошибке
        });
    }
}

