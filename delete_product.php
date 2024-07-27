<?php
header('Content-Type: text/plain'); // Убедитесь, что возвращаемый тип контента - текст

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

// Получаем код продукта из POST-запроса
if (isset($_POST['prod_code'])) {
    $prod_code = $_POST['prod_code'];

    // Подготавливаем запрос на удаление
    $stmt = $conn->prepare("DELETE FROM products WHERE prod_code = ?");
    $stmt->bind_param("s", $prod_code);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        echo 'Product successfully deleted.';
    } else {
        echo 'Error deleting product.';
    }

    $stmt->close();
} else {
    echo 'Product code is missing.';
}

$conn->close();
?>
