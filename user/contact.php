<?php
    
    use PHPMailer\PHPMailer\PHPMailer;
    require '../vendor/autoload.php';
    include '../server/config.php';
    
    if(isset($_POST['contact-us'])) {

        try {

            $name = $_POST['name'];
            $email = $_POST['email'];
            $message = $_POST['message'];

            $mail = new PHPMailer(true);
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'tablereservation.piggywings@gmail.com';
            $mail->Password = 'vdaqxcijuggduhst';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('tablereservation.piggywings@gmail.com', 'Customer Concern');
            $mail->addAddress('tablereservation.piggywings@gmail.com');
            $body = $_POST['message'];

            $mail->isHTML(true);
            $mail->Subject = 'Customer Concern';

            $timestamp = date("F d, Y");
            $mail->Body = '
                <div class="container"
                    style="
                        border: 1px solid #ccc;
                        border-radius: 5px;
                    ">
                    <div class="navbar"
                        style="
                            width: 100%;
                            padding: 20px;
                            text-align: center;
                            background: red;
                        ">
                        <img src="https://i.ibb.co/HHYYCpG/pw.png" height="150" alt="">
                    </div>
                    <div class="content"
                        style="
                            padding: 30px;
                        ">
                        <h1 style="margin: 0 0 30px 0; text-align: center; color: #333; font-size: 40px;">Piggy Wings</h1>
                        <h2 style="color: #000;">Sender\'s Name: ' . $name .'</h2>
                        <h2 style="color: #000;">Sender\'s Email: ' . $email .'</h2>
                        <h2 style="color: #000;">Date sent: ' . $timestamp .'</h2>
                        <h2 style="color: #000;">Message: ' . $message .'</h2>
                    </div>
                </div>
            ';

            $mail->send();
            $alert = 
            '<div class="alert alert-info alert-dismissible fade show notif" role="alert">
                <i class="fa-solid fa-circle-info"></i> Message sent successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';

        } catch (\Throwable $th) {
            $msg = "<div class='alert alert-danger text-center' role='alert'>$mail->ErrorInfo</div>";
        }

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
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
                    <li class="active"><a href="contact.php">CONTACT US</a></li>
                    <li><a href="about.php">ABOUT US</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="contact pt-3 pb-5 shadow-lg bg-light rounded">
        <div class="contact-image">
            <img src="../assets/images/contact.png" width="60%" height="60%" alt="">
        </div>
        <div class="contact-form px-5">
            <form class="form" action="contact.php" method="POST">
                <div class="form-header text-center">
                    <h2>Send us a message</h2>
                    <?php
                        if(isset($alert)) {
                            echo $alert;
                        }
                    ?>
                </div>
                <div class="form-floating mt-4">
                    <input type="text" style="margin: 0;" name="name" required oninvalid="this.setCustomValidity('Name is required!')" oninput="this.setCustomValidity('')" class="form-control" id="floatingInput" autofocus placeholder=" ">
                    <label for="floatingInput">Enter your name</label>
                </div>
                <div class="form-floating mt-4">
                    <input type="email" style="margin: 0;" name="email" required oninvalid="this.setCustomValidity('Please enter valid email!')" oninput="this.setCustomValidity('')" class="form-control" id="floatingInput" autofocus placeholder=" ">
                    <label for="floatingInput">Enter your email</label>
                </div>
                <div class="form-floating mt-4">
                    <textarea class="form-control" name="message" required oninvalid="this.setCustomValidity('Please enter your message!')" oninput="this.setCustomValidity('')" placeholder=" " id="floatingTextarea2" style="height: 100px"></textarea>
                    <label for="floatingTextarea2">Enter your message</label>
                </div>
                <div class="form-group mt-3">
                    <input style="margin-left: 0;" type="submit" name="contact-us" value="Send Message" />
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://apps.elfsight.com/p/platform.js" defer></script>
    <div class="elfsight-app-2d44c3a8-638c-427d-9d9a-8daa4d8e35af"></div>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.notif').fadeIn();
            }, 2400);
            setTimeout(function() {
                $('.notif').fadeOut();
            }, 3000);
        });
    </script>
</body>
</html>