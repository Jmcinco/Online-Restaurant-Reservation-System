<?php

    include '../server/config.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu List</title>
    <link rel="stylesheet" href="../main-css/style.css">
    <?php include '../assets/templates/template.php'; ?>
</head>
<style>
</style>
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
                    <li class="active"><a href="home.php">MENU</a></li>
                    <li><a href="order-online.php">ORDER ONLINE</a></li>
                    <li><a href="reservation.php">RESERVATION</a></li>
                    <li><a href="contact.php">CONTACT US</a></li>
                    <li><a href="about.php">ABOUT US</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="sticky-image"></div>
    <div class="content-banner">
        <div class="menu-cards d-flex justify-content-around flex-wrap">
            <?php

                $selectMenu = "SELECT * FROM food ORDER BY id DESC";
                $menuResult = mysqli_query($conn, $selectMenu);

                if($menuResult) {
                    while($row = mysqli_fetch_assoc($menuResult)) {
                        $menu_id = $row['id'];
                        $menu_pic = $row['menu_pic'];
                        $menu_name = $row['menu_name'];
                        $menu_desc = $row['menu_desc'];

                        echo '
                            
                            <div class="card shadow-lg bg-light m-3" style="width: 350px;" style="border-radius: 10px;">
                                <div class="card-image">
                                    <img style="border-top-left-radius: 10px; border-top-right-radius: 10px;" src="../admin/uploaded/'.$menu_pic.'" width="348px;" height="300px" alt="">
                                </div>
                                <div class="card-desc p-3">
                                    <div class="title d-flex justify-content-between align-items-center">
                                        <h3>'.$menu_name.'</h3>
                                    </div>
                                    <div class="desc">
                                        <p class="text-secondary">'.$menu_desc.'</p>
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