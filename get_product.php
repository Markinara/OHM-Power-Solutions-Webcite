<?php
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

// Check if prod_code is set
if (isset($_GET['prod_code'])) {
    $prod_code = intval($_GET['prod_code']);

    // SQL query to fetch product details
    $sql = "SELECT * FROM products WHERE prod_code = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $prod_code);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo json_encode($row);
        } else {
            echo json_encode(['error' => 'Product not found']);
        }

        $stmt->close();
    } else {
        echo json_encode(['error' => 'Failed to prepare statement']);
    }
} else {
    echo json_encode(['error' => 'No product id provided']);
}

// Close connection
$conn->close();
?>
