<?php

    include '../server/config.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Online | PiggyWings</title>
    <link rel="stylesheet" href="../main-css/style.css">
    <?php include '../assets/templates/template.php'; ?>
</head>
<body>
    
    <nav class="navbar navbar-expand-md navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="home.php"><img src="../assets/images/pw.png" width="45" alt=""></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav ms-auto mb-2 text-center mb-lg-0">
                    <li><a href="homepage.php">HOME</a></li>
                    <li><a href="home.php">MENU</a></li>
                    <li class="active"><a href="order-online.php">ORDER ONLINE</a></li>
                    <li><a href="reservation.php">RESERVATION</a></li>
                    <li><a href="contact.php">CONTACT US</a></li>
                    <li><a href="about.php">ABOUT US</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="content-container">
        <h1 class="text-center">Please Select</h1>
        <div class="container d-flex justify-content-center flex-wrap">
            <div class="card">
                <a href="https://www.foodpanda.ph/restaurant/kq1c/piggy-wings-holy-spirit?fbclid=IwAR2wA9gW4GXnqCCyj8EXun2JL9w9-BwLA3Vjp8WjW84t3LOaFXc1zlFGlHo" target="_blank" title="Foodpanda"><img src="../assets/images/foodpandalogo.png" alt=""></a>
            </div>
            <div class="card">
                <a href="https://food.grab.com/ph/en/restaurant/piggy-wings-holy-spirit-delivery/2-C2XZVEWFTYXTRN?fbclid=IwAR0A5INQqLr-0QyHjTVMDQzaCVCZWPmCcnKfq6lghq1FgaJ5VIEtXLArukc" target="_blank" title="Grabfood"><img src="../assets/images/grablogo.png" alt=""></a>
            </div>
        </div>
    </div>

</body>
</html>