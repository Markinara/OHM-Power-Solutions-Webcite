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

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch form data
    $prod_code = intval($_POST['prod_code']);
    $product_name = $_POST['prod_name'];
    $product_description = $_POST['discription'];
    $product_supplier = $_POST['supplier'];
    $product_quantity = $_POST['quantity'];
    $product_price = $_POST['price'];

    // Handle file upload
    if ($_FILES['picture']['error'] === UPLOAD_ERR_OK) {
        $temp_name = $_FILES['picture']['tmp_name'];
        $file_name = basename($_FILES['picture']['name']);
        $upload_dir = 'Pics/products/';
        $target_file = $upload_dir . $file_name;
        if (move_uploaded_file($temp_name, $target_file)) {
            $product_picture = $target_file;
        } else {
            echo "Error moving uploaded file.";
            exit;
        }
    } else {
        // Handle case when file upload failed or was not provided
        echo "No file uploaded or upload error.";
        exit;
    }

    // Debugging output
    echo "Product Code: $prod_code<br>";
    echo "Product Name: $product_name<br>";
    echo "Product Description: $product_description<br>";
    echo "Product Picture: $product_picture<br>";
    echo "Product Supplier: $product_supplier<br>";
    echo "Product Quantity: $product_quantity<br>";
    echo "Product Price: $product_price<br>";

    // SQL query to update product
    $sql = "UPDATE products SET prod_name = ?, discription = ?, picture = ?, supplier = ?, quantity = ?, price = ? WHERE prod_code = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ssssidi", $product_name, $product_description, $product_picture, $product_supplier, $product_quantity, $product_price, $prod_code);

    if ($stmt->execute()) {
        echo "Product updated successfully! <a href='admin.php'>Go back to admin page</a>";
    } else {
        echo "Error executing query: " . $stmt->error;
    }

    $stmt->close();
}

// Close connection
$conn->close();
?>
