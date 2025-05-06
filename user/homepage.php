<?php
    include '../server/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
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
                    <li class="active"><a href="homepage.php">HOME</a></li>
                    <li><a href="home.php">MENU</a></li>
                    <li><a href="order-online.php">ORDER ONLINE</a></li>
                    <li><a href="reservation.php">RESERVATION</a></li>
                    <li><a href="contact.php">CONTACT US</a></li>
                    <li><a href="about.php">ABOUT US</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="homepage-marquee pt-3" style="margin-top: 100px; background: rgb(255, 162, 0);">
        <marquee>
            <h3>COME AND VISIT US!</h3>
        </marquee>
    </div>

    <div class="promotions mt-4" style="overflow-x: hidden;">
        <div class="row d-flex flex-wrap mt-5 px-5">
            <?php

                $getGallery = "SELECT * FROM promo ORDER BY id DESC";
                $galleryResult = mysqli_query($conn, $getGallery);

                if($galleryResult) {
                    while($row = mysqli_fetch_assoc($galleryResult)) {
                        $id = $row['id'];
                        $image = $row['image'];

                        echo '
                                    
                            <div class="col-lg-4 m-auto mb-4">
                                <div class="card-customer card-promo card-tomer mb-3 shadow">
                                    <div class="customer-profile text-center">
                                        <img src="../admin/uploaded/'.$image.'" style="margin-top: -20px;">
                                    </div>
                                </div>
                            </div>
                                        
                        ';

                    }
                }

            ?>
        </div>
    </div>

    <div class="customer-gallery bg-light mt-5 p-5 shadow-lg"
        <?php
    
            $getGallery = "SELECT * FROM gallery";
            $galleryResult = mysqli_query($conn, $getGallery);
            if(mysqli_num_rows($galleryResult) < 1) {
                ?> style="height: 600px;" <?php
            }

        ?>>
        <h1 class="text-center mb-5" style="font-size: 40px;">Our Customers</h1>

        <div class="row d-flex flex-wrap">
            <?php

                $getGallery = "SELECT * FROM gallery ORDER BY id DESC";
                $galleryResult = mysqli_query($conn, $getGallery);

                if($galleryResult) {
                    while($row = mysqli_fetch_assoc($galleryResult)) {
                        $id = $row['id'];
                        $image = $row['image'];
                        $timestamp = $row['timestamp'];

                        echo '
                                
                            <div class="col-lg-4 mb-5">
                                <div class="card card-customer card-tomer mb-3 pb-2">
                                    <div class="customer-profile text-center">
                                        <img src="../admin/uploaded/'.$image.'" style="margin-top: -20px;">
                                        <h6 class="mt-3">'.ucwords($timestamp).'</h6>
                                    </div>
                                </div>
                            </div>
                                
                        ';

                    }
                }

            ?>
        </div>
    </div>

</body>
</html>