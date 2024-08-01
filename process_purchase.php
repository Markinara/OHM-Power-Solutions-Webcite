<?php
// Start the session
session_start();

// Database configuration
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

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

// Process the purchase
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['products'])) {
    $user_id = $_SESSION['user_id'];
    $products = $_POST['products']; // Array of product IDs and quantities

    // Start a transaction
    $conn->begin_transaction();

    try {
        foreach ($products as $product_id => $quantity) {
            // Validate quantity
            if (empty($quantity) || $quantity <= 0) {
                throw new Exception("Invalid quantity for product ID $product_id.");
            }

            // Check stock availability
            $stmt_stock = $conn->prepare("SELECT quantity FROM products WHERE prod_code = ?");
            $stmt_stock->bind_param("i", $product_id);
            $stmt_stock->execute();
            $stmt_stock->bind_result($stock_quantity);
            $stmt_stock->fetch();
            $stmt_stock->close();

            if ($quantity > $stock_quantity) {
                throw new Exception("Not enough stock for product ID $product_id.");
            }

            // Update stock in database
            $stmt_update = $conn->prepare("UPDATE products SET quantity = quantity - ? WHERE prod_code = ?");
            $stmt_update->bind_param("ii", $quantity, $product_id);
            if (!$stmt_update->execute()) {
                throw new Exception("Error updating stock for product ID $product_id: " . $stmt_update->error);
            }
            $stmt_update->close();

            // Remove item from cart table
            $stmt_remove = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
            $stmt_remove->bind_param("ii", $user_id, $product_id);
            if (!$stmt_remove->execute()) {
                throw new Exception("Error removing item from cart for product ID $product_id: " . $stmt_remove->error);
            }
            $stmt_remove->close();
        }

        // Commit the transaction
        $conn->commit();

        // Clear the cart after purchase
        $_SESSION['cart'] = [];

        // Redirect to a success page or display a success message
        header("Location: products.php");
        exit;
    } catch (Exception $e) {
        // Rollback the transaction if there is an error
        $conn->rollback();
        echo "Transaction failed: " . $e->getMessage();
    }

    // Close connection
    $conn->close();
} else {
    echo "No products found.";
}
?>
