<?php
// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ohm_power_solutions";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST['prod_name'];
    $product_description = $_POST['discription'];
    $product_supplier = $_POST['supplier'];
    $product_quantity = $_POST['quantity'];
    $product_price = $_POST['price'];

    // Загрузка изображения
    $target_dir = "Pics/";
    $target_file = $target_dir . basename($_FILES["picture"]["name"]);
    move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file);

    // Добавление продукта в базу данных
    $sql = "INSERT INTO products (prod_name, discription, picture, supplier, quantity, price) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii", $product_name, $product_description, $target_file, $product_supplier, $product_quantity, $product_price);

    if ($stmt->execute()) {
        echo "New product added successfully";
        header("Location: admin.Html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
