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
                    <li class="li"><a class="a" href="admin.php">Admin |</a></li>
                    <li class="li"><a class="a" href="index.HTML">Log Out</a></li>
                </ul>
            </nav>
        </div>

        <div class="search-container">
                <input type="text" name="search" placeholder="search...">
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

        // Handle remove item from cart action
        if (isset($_POST['remove_item']) && isset($_POST['prod_code'])) {
            $product_id = $_POST['prod_code'];
            $user_id = $_SESSION['user_id'];

            // Remove item from session cart
            if (isset($_SESSION['cart'][$product_id])) {
                unset($_SESSION['cart'][$product_id]);
            }

            // Remove item from cart table in the database for the current user
            $stmt_remove = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
            $stmt_remove->bind_param("ii", $user_id, $product_id);

            if ($stmt_remove->execute()) {
                echo "Item successfully removed from database.<br>";
            } else {
                echo "Error: " . $stmt_remove->error . "<br>";
            }
            $stmt_remove->close();
        }

        // Fetch and display cart items for the current user
        $total_price = 0;
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $stmt_cart = $conn->prepare("SELECT product_id, pricee, prod_pic, prod_namee,quantitty FROM cart JOIN products  ON product_id = prod_code WHERE user_id = ?");
            $stmt_cart->bind_param("i", $user_id);
            $stmt_cart->execute();
            $result_cart = $stmt_cart->get_result();

            if ($result_cart->num_rows > 0) {
                while ($row_cart = $result_cart->fetch_assoc()) {
                    $product_id = $row_cart['product_id'];
                    if (isset($_SESSION['cart'][$product_id])) {
                        $quantity = $_SESSION['cart'][$product_id];
                        $price = $row_cart['pricee'] * $quantity;
                        $total_price += $price;

                        // Display cart item
                        ?>
                        <div class="card">
                            <div class="content">
                                <div class="front"
                                    style="background-image: url('<?php echo htmlspecialchars($row_cart['prod_pic']); ?>');">
                                </div>
                                <div class="back">
                                    <h2 class="txt">Name: <?php echo htmlspecialchars($row_cart['prod_namee']); ?></h2>

                                    <div class="quantity">
                                        <form action="" method="post" class="quantity-form">
                                            <input type="hidden" name="prod_code" value="<?php echo htmlspecialchars($product_id); ?>">
                                            <label>Quantity: </label>
                                            <input name="quantitty" value="<?php echo $quantity; ?>" min="1">
                                            <input type="hidden" name="update_cart" value="1">
                                        </form>
                                    </div>

                                    <div class="price">
                                        <p class="txt">Price: $<?php echo number_format($price, 2); ?></p>
                                    </div>

                                    <form action="" method="post" class="remove-form">
                                        <input type="hidden" name="prod_code" value="<?php echo htmlspecialchars($product_id); ?>">
                                        <button type="submit" class="remove" name="remove_item">Remove</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
            } else {
                echo "<div class='empty-cart'>Your cart is empty.</div>";
            }

            $stmt_cart->close();
        }

        // Close connection
        $conn->close();
        ?>

        <!-- Display total price at the bottom of the page -->
        <footer>
            <?php if (!empty($_SESSION['cart'])): ?>
                <div class="price">
                    <h2 class="h3">Total Price: $<?php echo number_format($total_price, 2); ?></h2>
                </div>

                <form action="" method="post" class="bd">
                    <button type="submit" class="buy">Buy Now</button>
                </form>
            <?php endif; ?>
        </footer>
    </div>
</body>

</html>
