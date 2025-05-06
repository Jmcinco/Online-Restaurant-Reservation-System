<?php

    include '../server/config.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
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
                    <li><a href="order-online.php">ORDER ONLINE</a></li>
                    <li><a href="reservation.php">RESERVATION</a></li>
                    <li><a href="contact.php">CONTACT US</a></li>
                    <li class="active"><a href="about.php">ABOUT US</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="about-us d-flex align-items-center flex-wrap bg-light shadow-lg">
        <div class="about-image">
            <img src="../assets/images/about.jpg" alt="">
        </div>
        <div class="about-content">
            <h1 class="text-start fw-bolder">About Us</h1>
            <hr>
            <div class="about-paragraph">
                <p>
                    Started out in May 2021, the first branch was successfully launched at 1977 Commonwealth Avenue Brgy Holy Spirit Q.C. It was a blast that almost everyday up until now, people are still enjoying the quality and service the Piggy Wings has to offer.
                </p>
                <p>
                    The Founder, Mr. Mark Magnate Martin aims to help Filipinos experience a quality and unique experience of dining a Korean Grill Samgyeopsal and Unli Wings combined together for a very reasonable price.
                </p>
                <p>
                    As part of its Anniversary, the second branch which is located at High-Way 2000, San Juan Taytay Rizal is a proof that Piggy Wings will expand and will continue to provide the best quality and service for the Filipino community.
                </p>
                <p>
                    Here at Piggy Wings, every aspect counts. From the quality of Pork, Chicken, and Beef, to the above standard marketing plans, we take everything seriously with enthusiasm and rigor.
                </p>
                <p>
                    We believe that every member of the family deserves crispy, tender, and flavorful Chicken Wings together with Fresh and Juicy Samgyeopsal.
                </p>
            </div>
        </div>
    </div>

    <div class="about-us bg-light shadow-lg mb-5">
        <h1 class="text-center fw-bolder">Our Location</h1> 
        <div style="width: 100%">
            <iframe width="100%" height="600" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=piggywings+(My%20Business%20Name)&amp;t=k&amp;z=15&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
        </div>
    </div>

    <div class="about-us bg-light shadow-lg mb-5">
        <h1 class="text-center fw-bolder">Our Team</h1> 
        <hr>
        <div class="team-card d-flex flex-wrap">

            <!-- CHILD 1 -->
            <div class="card card-team">
                <div class="overlay d-none"> 
                    <small class="fa fa-close"></small>
                    <img src="../assets/images/JMCINCO.png" class="bg-dark"> 
                </div>
                <div class="upperborder">
                </div>
                <it class="fa fa-plus"></it>
                <div class="image">
                    <span><img id="userimage" src="../assets/images/JMCINCO.png"></span>
                </div>
                <div class="text">    
                    <h4>JOHN MICHAEL CINCO</h4>
                    <p class="text-primary">Lead Web Developer</p>
                </div> 
                <div class="bottom">
                    <div class="social">
                        <a href="https://www.facebook.com/john.cinco029/" target="_blank"><i class="fa-brands fa-facebook"></i></a>
                        <a href="https://discordapp.com/users/852899090387304508/" target="_blank"><i class="fab fa-discord"></i></i></a>
                        <a href="https://twitter.com/Itsmejieeeeeeem/" target="_blank"><i class="fa-brands fa-twitter"></i></a>
                        <a href="https://www.google.com" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            
            <!-- CHILD 2 -->
            <div class="card card-team">
                <div class="overlay1 d-none"> 
                    <small class="fa fa-close"></small>
                    <img src="../assets/images/member_1.png" class="bg-dark"> 
                </div>
                <div class="upperborder">
                </div>
                <it class="fa fa-plus"></it>
                <div class="image">
                    <span><img id="userimage1" src="../assets/images/member_3.png"></span>
                </div>
                <div class="text">
                    <h4>ADAM ROQUE</h4>
                    <p class="text-primary">Web Developer</p>
                </div> 
                <div class="bottom">
                    <div class="social">
                        <a href="https://www.facebook.com" target="_blank"><i class="fa-brands fa-facebook"></i></a>
                        <a href="https://www.instagram.com" target="_blank"><i class="fa-brands fa-instagram-square"></i></a>
                        <a href="https://www.twitter.com" target="_blank"><i class="fa-brands fa-twitter"></i></a>
                        <a href="https://www.google.com" target="_blank"><i class="fa-brands fa-google"></i></a>
                    </div>
                </div>
            </div>

            <!-- CHILD 3 -->
            <div class="card card-team">
                <div class="overlay2 d-none"> 
                    <small class="fa fa-close"></small>
                    <img src="../assets/images/member_1.png" class="bg-dark"> 
                </div>
                <div class="upperborder">
                </div>
                <it class="fa fa-plus"></it>
                <div class="image">
                    <span><img id="userimage2" src="../assets/images/member_3.png"></span>
                </div>
                <div class="text">
                    <h4>JANSEN ORTIZ</h4>
                    <p class="text-primary">Web Developer</p>
                </div> 
                <div class="bottom">
                    <div class="social">
                        <a href="https://www.facebook.com" target="_blank"><i class="fa-brands fa-facebook"></i></a>
                        <a href="https://www.instagram.com" target="_blank"><i class="fa-brands fa-instagram-square"></i></a>
                        <a href="https://www.twitter.com" target="_blank"><i class="fa-brands fa-twitter"></i></a>
                        <a href="https://www.google.com" target="_blank"><i class="fa-brands fa-google"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="../main-js/script.js"></script>
</body>
</html>