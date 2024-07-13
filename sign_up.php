<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $address = htmlspecialchars($_POST['address']);
    $password = htmlspecialchars($_POST['password']);

    $servername = "localhost";
    $database = "ohm_power_solutions";
    $username_db = "root";
    $password_db = "";

    $conn = new mysqli($servername, $username_db, $password_db, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO users (username, email, address, password) VALUES ('$username', '$email', '$address', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "<p>New user registered succsessfully! Welcome!</p>";
    } else {
        echo "<p>Ошибка: " . $sql . "<br>" . $conn->error . "</p>";
    }

    $conn->close();
}
?>
