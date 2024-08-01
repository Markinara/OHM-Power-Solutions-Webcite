<?php
session_start();
$is_admin = isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] === true;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="pr.css">
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

    <style>
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }

        header {
            background: #fff;
            color: rgb(39, 186, 56);
            padding: 1rem 0;
            text-align: center;
        }

        header h1 {
            margin: 0;
        }

        .profile {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin: 2rem 0;
        }

        .profile-item {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 1rem;
            padding: 1rem;
            width: 45%;
            text-align: center;
        }

        .profile-item img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin-bottom: 1rem;
        }

        .profile-item h2 {
            margin: 0.5rem 0;
        }

        .profile-item p {
            margin: 0.5rem 0;
        }

        footer {
            background: #333;
            color: #fff;
            text-align: center;
            padding: 1rem;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>

<body>
    <header>
        <h1>About Us</h1>
    </header>

    <div class="container">
        <div class="profile">
            <!-- Your Profile -->
            <div class="profile-item">
                <img src="pics\devs\chzan-bu-ti.jpg" alt="chzan-bu-ti">
                <h2>aleksey chzan-bu-ti</h2>
                <p>Age: 27</p>
                <p>Workplace: Elidor</p>
                <h3>Personal Story</h3>
                <p>Growing up, my family faced significant challenges. We struggled with financial instability and domestic violence, which created a difficult environment. When I was ten years old, my mother, raising three children on her own, was doing everything she could to support us.

Realizing the weight of our situation, I had to start working to help make ends meet. It was a formative experience that shaped my values and aspirations. From that moment on, I made a promise to myself that I would become a worthy provider and protector for my family.

Determined to overcome our struggles and secure a better future, I dedicated myself to working hard and striving for success. My journey has been driven by the commitment to uplift and support my loved ones, and it remains a central part of who I am today.</p>
            </div>

            <!-- Partner's Profile -->
            <div class="profile-item">
                <img src="pics\devs\petrochenko.jpg" alt="Partner's Photo">
                <h2>aleksey petrochenko</h2>
                <p>Age: 26</p>
                <p>Workplace: ohm-power-solutions</p>
                <h3>Personal Story</h3>
                <p>From a young age, I have been driven by a deep desire for self-improvement and excellence. Whether in my personal endeavors or professional pursuits, I strive to do everything to the best of my ability. My commitment extends beyond my own growth; I am dedicated to supporting my family, assisting friends, and protecting those in need.

This dedication to perfection and service has been a guiding principle throughout my life. It motivates me to continuously enhance my skills and contribute positively to the lives of others. My journey is fueled by the belief that true success lies not only in personal achievements but also in making a meaningful difference in the world around me.</p>
            </div>
        </div>
    </div>
</body>

</html>