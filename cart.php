<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="pr.css">
    <title>Cart Page</title>
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
                    <li class="li"><a class="a" href="admin.html">Admin |</a></li>
                    <li class="li"><a class="a" href="index.HTML">Log Out</a></li>
                </ul>
            </nav>
        </div>
        
        <div class="search-container">
            <input type="text" placeholder="search...">
            <button class="but" type="submit">Search</button>
        </div>
    </header>

    <main class="wrapper">
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

        // Initialize cart
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        // Add product to cart
        if (isset($_POST['add_to_cart']) && isset($_POST['prod_code'])) {
            $product_id = $_POST['prod_code'];

            // Check if product is already in the cart
            if (!in_array($product_id, $_SESSION['cart'])) {
                $_SESSION['cart'][] = $product_id;
            }
        }

        // Display cart items
        if (count($_SESSION['cart']) > 0) {
            foreach ($_SESSION['cart'] as $product_id) {
                // Use prepared statements to avoid SQL injection
                $stmt = $conn->prepare("SELECT * FROM products WHERE prod_code = ?");
                $stmt->bind_param("s", $product_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    ?>
                    <div class="card">
                        <div class="content">
                            <div class="front" style="background-image: url('<?php echo htmlspecialchars($row['picture']); ?>');"></div>
                            <div class="back">
                                <h2 class="txt">Name: <?php echo htmlspecialchars($row['prod_name']); ?></h2>
                                <div class="description">
                                    <p class="txt"><?php echo htmlspecialchars($row['discription']); ?></p>
                                </div>
                                <div class="quantity">
                                    <p class="txt">Quantity: <?php echo htmlspecialchars($row['quantity']); ?></p>
                                </div>
                                <div class="price">
                                    <p class="txt">Price: $<?php echo htmlspecialchars($row['price']); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                $stmt->close();
            }
        } else {
            echo "<div class='empty-cart'>Your cart is empty.</div>";
        }

        // Close connection
        $conn->close();
        ?>
    </main>

</body>
</html>
