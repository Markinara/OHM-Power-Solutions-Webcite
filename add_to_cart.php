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

// Handle adding product to cart action
if (isset($_POST['prod_code'])) {
    $prod_code = $_POST['prod_code'];
    $user_id = $_SESSION['user_id']; // Retrieve user ID from session

    // Fetch product details from products table
    $stmt = $conn->prepare("SELECT * FROM products WHERE prod_code = ?");
    $stmt->bind_param("s", $prod_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $prod_name = $row['prod_name'];
        $prod_pic = $row['picture'];
        $price = $row['price'];
        $quantity = $row['quantity']; // Assuming there's a quantity field in your products table

        if ($quantity > 0) {
            // Check if the product already exists in the session cart
            if (isset($_SESSION['cart'][$prod_code])) {
                $_SESSION['cart'][$prod_code] += 1; // Increment quantity if already in cart
            } else {
                $_SESSION['cart'][$prod_code] = 1; // Add new product to session cart with quantity 1
            }

            // Add or update the cart table in the database
            $stmt_check = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
            $stmt_check->bind_param("is", $user_id, $prod_code);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();

            if ($result_check->num_rows > 0) {
                // Product already exists in cart, update quantity
                $stmt_update = $conn->prepare("UPDATE cart SET quantitty = quantitty + 1 WHERE user_id = ? AND product_id = ?");
                $stmt_update->bind_param("is", $user_id, $prod_code);
                $stmt_update->execute();
                $stmt_update->close();
            } else {
                // Product not in cart, insert new entry
                $stmt_insert = $conn->prepare("INSERT INTO cart (user_id, product_id, prod_namee, prod_pic, quantitty, pricee) VALUES (?, ?, ?, ?, 1, ?)");
                $stmt_insert->bind_param("isssd", $user_id, $prod_code, $prod_name, $prod_pic, $price);
                $stmt_insert->execute();
                $stmt_insert->close();
            }

            echo "Product added to cart successfully.";
        } else {
            echo "Product not available or out of stock.";
        }
    } else {
        echo "Product not found.";
    }

    $stmt->close();
}

// Close connection
$conn->close();
?>
