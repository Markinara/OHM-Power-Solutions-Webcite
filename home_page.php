<?php
session_start();
$is_admin = isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] === true;

?>



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
                <li class="li"><a class="a" href="home_page.php">Home |</a></li>
                <li class="li"><a class="a" href="products.php">Products |</a></li>
                <li class="li"><a class="a" href="cart.php">Cart |</a></li>
                <?php if ($is_admin): ?>
                    <li class="li"><a class="a" href="admin.php">Admin |</a></li>
                <?php endif; ?>
                <li class="li"><a class="a" href="index.HTML">Log Out</a></li>
            </ul>
            <div class="search-container">
                <input type="text" placeholder="Enter a details">
                <button class="but" type="submit">Search</button>
            </div>
        </div>
    </div>

    <div class="mid ">
        <h1 class="m">WE  ENGINEER  AND  PRODUCE<br>POWER SOLUTIONS</h1>
        <p class="patiah">Mil & Aerospace Oriented Field - Proven Power Solutions<br>Quality Products for Maximum Accuracy.</p>  
    </div>

    <div class="l">
        <p class="p11">Solutions for your most essential projects</p>
        <div class="icon-text-container">
            <div class="icon-text-item">
                <img class="img2" src="Pics/ICO 3.png">
                <p class="icon-text">Power supply engineering</p>
            </div>
            <div class="icon-text-item">
                <img class="img2" src="Pics/ICO 3-1.png">
                <p class="icon-text">Technical design assistance</p>
            </div>
            <div class="icon-text-item">
                <img class="img2" src="Pics/ICO 3-2.png">
                <p class="icon-text">Field-proven & highly reliable</p>
            </div>
        </div>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Redirect to the personal information page
        header("Location: dev.php");
        exit();
    }
    ?>
    
    <h2 class="au">ABOUT US</h2>
    <div class="about-us">
        <p class="p2">Accomplished missions and satisfied customers are the keys to our success.<br>
            We carefully consider every detail of our customers' specifications:<br><br>
            • Size<br>
            • Precision Output<br>
            • Temperature<br>
            • Vibration<br>
            • Elevation<br>
            • Mechanical Accuracy.<br><br>
            Nothing ignored – everything considered.
        </p>
        <form action="" method="post" class="bd2">
            <button class="button2" type="submit">Learn more</button>
        </form>
    </div>
    
    <footer>
        Created by "Aleksey&Aleksey" LTD. All rights reserved.
    </footer>  
</body>
</html>
