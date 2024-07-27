<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="pr.css">
    <title>Home page</title>
</head>
<body>
    <div class="parent">
        <div class="d">
            <img class="img1" src="Pics/LOGO UP .png">
        </div>
        
        <div class="navbar">
            <ul class="ul">
                <li class="li"><a class="a" href="HomePage.HTML">Home |</a></li>
                <li class="li"><a class="a" href="products.php">Products |</a></li>
                <li class="li"><a class="a" href="cart.html">Cart |</a></li>
                <li class="li"><a class="a" href="admin.php">Admin |</a></li>
                <li class="li"><a class="a" href="index.HTML">Log Out</a></li>
            </ul>
        </div>
    </div>
    <div class="search-container">
        <input type="text" placeholder="search...">
        <button class="but" type="submit">Search</button>
    </div>
   
    <div class="wrapper">
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

        // SQL query to fetch products
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);

        // Check if there are results
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="card">
                    <div class="content">
                        <div class="front" style="background-image: url('<?php echo $row['picture']; ?>');"></div>
                        <div class="back" style="background-color: #27ba38">
                            <div class="inner" >
                                <h2><?php echo $row['prod_name']; ?>name:</h2>
                                <div class="location"><?php echo $row['quantity']; ?></div>
                                <div class="price">$<?php echo $row['price']; ?></div>
                                <p class="description"><?php echo $row['discription']; ?></p>
                                <button type="checkbox" for="more" class="return">Add to card</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "0 results";
        }

        // Close connection
        $conn->close();
        ?>
    </div>

</body>
</html>
