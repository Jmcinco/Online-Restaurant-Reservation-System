<?php
    
    include '../server/config.php';
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PiggyWings</title>
    <link rel="stylesheet" href="../main-css/style.css">
    <?php include '../assets/templates/template.php' ?>
</head>
<body>
    
    <div class="header">
        <img src="../assets/images/PIGGY WINGS White and Black Font.png" alt="">
        <div class="options">
        <div class="menu card-option">
                <div class="title">
                    <h4>HOME</h4>
                </div>
                <div class="body">
                    <p>Click to see our Promos here!</p>
                </div>
                <div class="card-btn">
                    <a href="homepage.php"><button>Home</button></a>
                </div>
            </div>
            <div class="menu card-option">
                <div class="title">
                    <h4>MENU</h4>
                </div>
                <div class="body">
                    <p>Click to see list of food menus in our restaurant</p>
                </div>
                <div class="card-btn">
                    <a href="home.php"><button>See Menu</button></a>
                </div>
            </div>
            <br>
            <div class="menu card-option">
                <div class="title">
                    <h4>RESERVATION</h4>
                </div>
                <div class="body">
                    <p>Book your reservation now!</p>
                </div>
                <div class="card-btn">
                    <a href="reservation.php"><button>Reservation</button></a>
                </div>
            </div>
            <div class="menu card-option">
                <div class="title">
                    <h4>CONTACT US</h4>
                </div>
                <div class="body">
                    <p>Message your concern here!</p>
                </div>
                <div class="card-btn">
                    <a href="contact.php"><button>Contact Us</button></a>
                </div>
            </div>
            
            </div>
        </div>
    </div>

</body>
</html>