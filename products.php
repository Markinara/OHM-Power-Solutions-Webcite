<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="pr.css">
    <title>Products Page</title>
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
                <li class="li"><a class="a" href="cart.php">Cart |</a></li>
                <li class="li"><a class="a" href="admin.html">Admin |</a></li>
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
                        <div class="back">
                            <h2 class="txt">Name: <?php echo $row['prod_name']; ?></h2>
                            <div class="description">
                                <p class="txt"><?php echo $row['discription']; ?></p>
                            </div>
                            <div class="quantity"><p class="txt">Quantity: <?php echo $row['quantity']; ?></p></div>
                            <div class="price"><p class="txt">Price: $<?php echo $row['price']; ?></p></div>
                            <form action="cart.php" method="post">
                            <input type="hidden" name="prod_code" value="<?php echo htmlspecialchars($row['prod_code']); ?>">
                             <button type="submit" name="add_to_cart" class="return">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>No products found.</p>";
        }

        // Close connection
        $conn->close();
        ?>
    </div>
    
</body>
</html>
