<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="pr.css">
    <title>Products Page</title>
</head>

<body>
    <header>
        <div class="parent">
            <div class="d">
                <img class="img1" src="Pics/LOGO UP .png" alt="Logo">
            </div>

            <nav class="navbar">
                <ul class="ul">
                    <li class="li"><a class="a" href="HomePage.HTML">Home |</a></li>
                    <li class="li"><a class="a" href="products.php">Products |</a></li>
                    <li class="li"><a class="a" href="cart.php">Cart |</a></li>
                    <li class="li"><a class="a" href="admin.php">Admin |</a></li>
                    <li class="li"><a class="a" href="index.HTML">Log Out</a></li>
                </ul>
            </nav>
        </div>

        <div class="search-container">
            <input type="text" name="search" placeholder="Search...">
            <button class="but" type="submit">Search</button>
        </div>
    </header>

    <div class="wrapper">
        <?php
        session_start();

        // Database connection parameters
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "ohm_power_solutions";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Handle search functionality
        
        // Default SQL query to fetch all products
        $result = $conn->query("SELECT * FROM products ORDER BY price DESC");
        

        // Check if there are results
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="card">
                    <div class="content">
                        <div class="front" style="background-image: url('<?php echo htmlspecialchars($row['picture']); ?>');"></div>
                        <div class="back">
                            <h2 class="txt">Name: <?php echo htmlspecialchars($row['prod_name']); ?></h2>
                            <div class="description">
                                <p class="txt"><?php echo htmlspecialchars($row['description']); ?></p>
                            </div>
                            <div class="quantity"><p class="txt">Quantity: <?php echo htmlspecialchars($row['quantity']); ?></p></div>
                            <div class="price"><p class="txt">Price: $<?php echo htmlspecialchars($row['price']); ?></p></div>
                            <button type="button" class="return" onclick="addToCart('<?php echo htmlspecialchars($row['prod_code']); ?>')">Add to Cart</button>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>No products found.</p>";
        }

        // Close connection
        $conn->close();
        ?>
    </div>

    <script>
        function addToCart(prod_code) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'add_to_cart.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    alert(xhr.responseText); // Display response
                    // Optionally update UI (e.g., cart count)
                } else {
                    alert('Error adding to cart. Please try again.');
                }
            };

            // Send product code as data
            xhr.send('prod_code=' + encodeURIComponent(prod_code));
        }
    </script>
</body>

</html>