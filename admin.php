<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="pr.css">
    <title>Admin Page</title>
    <script src="script.js"></script>
</head>
<body>

    <div class="parent">
        <div class="d">
            <img class="img1" src="Pics/LOGO UP .png">
        </div>
        
        <div class="navbar">
            <ul class="ul">
                <li class="li"><a class="a" href="HomePage.HTML">Home |</a></li>
                <li class="li"><a class="a" href="products.php">Products |</a></li>
                <li class="li"><a class="a" href="cart.php">Cart |</a></li>
                <li class="li"><a class="a" href="admin.php">Admin |</a></li>
                <li class="li"><a class="a" href="index.HTML">Log Out</a></li>
            </ul>
        </div>
    </div>
    
    <div class="search-container">
        <input type="text" placeholder="search...">
        <button class="but" type="submit">Search</button>
    </div>

    <h1>All Products</h1>

    <div class="page-container">
        <div class="table-container">
            <table border="1">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Picture Name</th>
                        <th>Supplier</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th class="table-action-cell" style="width: 100px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Database connection
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "ohm_power_solutions";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // SQL query to fetch products
                    $sql = "SELECT * FROM products";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['prod_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['description']); ?></td>
                                <td><?php echo htmlspecialchars(basename($row['picture'])); ?></td>
                                <td><?php echo htmlspecialchars($row['supplier']); ?></td>
                                <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                                <td>$<?php echo htmlspecialchars($row['price']); ?></td>
                                <td class="table-action-cell"><button class="edit-button" onclick="showEditForm(<?php echo $row['prod_code']; ?>)">Edit</button></td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='7'>No products found! Check out your products data.</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>

        <div class="form-container">
            <div class="add-form">
                <h2>Add Product</h2>
                <form action="add_product.php" method="post" enctype="multipart/form-data">
                    <label for="product_name">Product Name:</label>
                    <input type="text" id="product_name" name="prod_name" required><br>

                    <label for="product_description">Product Description:</label>
                    <textarea id="product_description" name="discription" required></textarea><br>

                    <label for="product_image">Product Image:</label>
                    <input type="file" id="product_image" name="picture" required><br>

                    <label for="product_supplier">Product Supplier:</label>
                    <input type="text" id="product_supplier" name="supplier" required><br>

                    <label for="product_quantity">Product Quantity:</label>
                    <input type="number" id="product_quantity" name="quantity" required><br>

                    <label for="price">Price:</label>
                    <input type="number" id="price" name="price" required><br>

                    <input type="submit" value="Add Product">
                </form>
            </div>

            <div class="edit-form" id="edit-form">
                <h2>Edit Product</h2>
                <form id="edit-product-form" method="post" action="update_product.php" enctype="multipart/form-data">
                    <input type="hidden" id="edit-product-id" name="prod_code">
                    <label for="edit-prod_name">Product Name:</label>
                    <input type="text" id="edit-prod_name" name="prod_name" required><br>
                    <label for="edit-discription">Description:</label>
                    <textarea id="edit-discription" name="discription" required></textarea><br>
                    <label for="product_image">Product Image:</label>
                    <input type="file" id="product_image" name="picture" required><br>
                    <label for="edit-supplier">Supplier:</label>
                    <input type="text" id="edit-supplier" name="supplier" required><br>
                    <label for="edit-quantity">Quantity:</label>
                    <input type="number" id="edit-quantity" name="quantity" required><br>
                    <label for="edit-price">Price:</label>
                    <input type="number" step="0.01" id="edit-price" name="price" required><br>
                    <input type="submit" value="Save Changes">
                </form>
            </div>
        </div>
    </div>

</body>
</html>
