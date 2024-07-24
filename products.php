<?php
// Example database connection parameters
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

// SQL query to fetch products from database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
$conn->close();
?>
