<?php

include '../server/config.php';
use PHPMailer\PHPMailer\PHPMailer;

require '../vendor/autoload.php';

if (isset($_GET['error'])) {
    $alert = "<div class='alert alert-danger text-center' role='alert'>Please make a reservation first.</div>";
}

if (isset($_POST['book'])) {

    $fullName = trim(mysqli_real_escape_string($conn, $_POST['name']));
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $date = $_POST['date'];
    $dateFormatted = date("F d, Y", strtotime($date));
    $time = $_POST['time'];
    $reservetable = $_POST['reservetable'];
    $isPending = 1;
    $guest = trim(mysqli_real_escape_string($conn, $_POST['guest']));
    $mobile = $_POST['mobile'];
    $OTP = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

    $preventDualReservation = "SELECT * FROM reservation WHERE email = '$email'";
    $preventResult = mysqli_query($conn, $preventDualReservation);
    if (mysqli_num_rows($preventResult) > 0) {
        $alert = "<div class='alert alert-warning text-center' role='alert'>You already have a reservation.<br>Please check your email.</div>";
    } else {

        $stmt = $conn->prepare("INSERT INTO reservation (name, email, mobile, date, time, table_reserved, no_of_guest, isPending, otpCode)
            VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssisssssi", $fullName, $email, $mobile, $dateFormatted, $time, $reservetable, $guest, $isPending, $OTP);
        $stmt->execute();

        $_SESSION['reservedTable'] = $reservetable;
        $_SESSION['email'] = $email;

        try {

            $name = $_POST['name'];
            $email = $_POST['email'];

            $mail = new PHPMailer(true);
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'youremail@gmail.com';
            $mail->Password = 'yourpassword';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('youremail@gmail.com', 'OTP For Reservation | Piggy Wings');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'OTP For Reservation | Piggy Wings';

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
                            <h3 style="color: #222;">
                                Hi, ' . $email . ', thank you for your reservation here at Piggy Wings!
                                <br>
                                <br>
                                <span style="font-size: 25px;">OTP Code: <span style="color: red">' . $OTP . '</span></span>
                                <br>
                                <span style="font-size: 25px;">Here\'s the link for your verification: <a href="http://localhost/piggywings/user/verification.php?email=' . base64_encode($email) . '" target="_blank">OTP Verification Page</a></span>
                            </h3>
                        </div>
                    </div>
                ';

            $mail->send();
            $alert = "<div class='alert alert-info text-center' role='alert'>An OTP has been sent to your email.<br>Please verify your reservation.</div>";


        } catch (\Throwable $th) {
            $alert = "<div class='alert alert-danger text-center' role='alert'>$mail->ErrorInfo</div>";
        }
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation</title>
    <link rel="stylesheet" href="../main-css/style.css">
    <?php include '../assets/templates/template.php'; ?>
    <!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">


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
                    <li class="active"><a href="reservation.php">RESERVATION</a></li>
                    <li><a href="contact.php">CONTACT US</a></li>
                    <li><a href="about.php">ABOUT US</a></li>
                </ul>
            </div>
        </div>
    </nav>
<br/>
    <section class="banner">
        <div class="card-container">
            <div class="card-img">
            </div>
            <div class="card-content">
                <br><br>
                <h3>Book your Reservation Now!</h3>
                <div class="alert-section">
                    <?php
                    if (isset($alert)) {
                        echo $alert;
                    }
                    ?>
                </div>
                <span style="display:none;"><?php echo base64_encode("tablereservation.piggywings@gmail.com") ?></span>
                <form method="POST" id="__book">
                    <div class="form-row">
                        <input type="text" placeholder="Full Name" name="name" id="name">
                        <input type="text" placeholder="Email" name="email" id="email">
                    </div>
                    <div class="form-row">
                        <?php

                        $sqldate = "select dates from tbldatemaintenance";
                        $querydate = mysqli_query($conn, $sqldate);
                        $drows = array();

                        while ($r = mysqli_fetch_assoc($querydate)) {
                            $drows[] = $r['dates'];
                        }
                        //print json_encode($drows);
                        
                        // $sqldate = "select * from tbldatemaintenance";
                        // $querydate = mysqli_query($conn, $sqldate);
                        // $maxrow = mysqli_num_rows($querydate);
                        // $dates_ar = '';
                        
                        // while($row = mysqli_fetch_assoc($querydate)) {
                        //     $selecteddates = $row['dates'];
                        
                        //     $dates_ar = $dates_ar . '' . $selecteddates . ',';
                        
                        //     // for( $x=1; $x<=$maxrow; $x++) {
                        //     //     $dates_ar[$x] = $selecteddates;
                        //     // }
                        // }   
                        // echo$dates_ar; 
                        //echo$dates_ar;
                        //$dates_ar[] = $sdate->format("m/d/Y"); 
                        //format("Y-m-d") 2023-01-24
                        //datepicker default: format("m/d/Y")
                        


                        //echo json_encode($dates_ar);
                        


                        ?>
                        <input type="text" required placeholder="Date of Reservation" name="date" class="datepicker" >
                        <!-- <input type="date" required placeholder="Date of Reservation" name="date" id="datepick" >
                         -->
                    </div>

                    <div class="form-row">
                        <input type="text" maxlength="11" onkeydown="return onlyNumberKey(event)" name="mobile" id="mobile" placeholder="Mobile Number">
                        <select type="select" name="time" id="time">
                            <option disabled selected>Time</option>
                            <option value="11:00am">11:00am</option>
                            <option value="12:30pm">12:30pm</option>
                            <option value="2:00pm">2:00pm</option>
                            <option value="3:30pm">3:30pm</option>
                            <option value="5:00pm">5:00pm</option>
                            <option value="6:30pm">6:30pm</option>
                            <option value="8:00pm">8:00pm</option>
                            <option value="9:30pm">9:30pm</option>
                        </select>
                    </div>
                    <div class="form-row">
                        <select type="select" name="reservetable" id="table">
                            <option disabled selected>Table option</option>
                            <?php

                            $getTypes = "SELECT * FROM table_types";
                            $typesResult = mysqli_query($conn, $getTypes);
                            while ($row = mysqli_fetch_assoc($typesResult)) {
                                $type_id = $row['id'];
                                $type = $row['type'];
                                $total = $row['total'];
                                $remaining = $row['remaining'];

                                if ($remaining == 0) {
                                    echo '
                                            <option value="' . $type . '" ' . ($remaining <= 0 ? 'disabled' : '') . '>' . $type . ' (' . $remaining . ' seat/s remaining)</option>
                                        ';
                                } else if ($remaining < 0) {
                                    echo '
                                            <option value="' . $type . '" ' . ($remaining <= 0 ? 'disabled' : '') . '>' . $type . ' ( 0 seat/s remaining)</option>
                                        ';
                                } else {
                                    echo '
                                            <option value="' . $type . '" ' . ($remaining <= 0 ? 'disabled' : '') . '>' . $type . ' (' . $remaining . ' seat/s remaining)</option>
                                        ';
                                }

                            }

                            ?>
                        </select>
                    </div>

                    <div class="form-row">
                        <input type="number" min="1" placeholder="How many Guest?" name="guest" id="guest">
                        <input type="submit" id="bookBtn" name="book" value="BOOK TABLE">
                    </div>
                </form>
            </div>
        </div>
    </section>

                                
        <!-- jQuery library -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="../main-js/script.js"></script>
    <script>
        $("#__book").submit((event) => {
            var a = document.querySelector("#time")
            var b = document.querySelector("#table")
            var c = document.querySelector("#name")
            var e = document.querySelector("#guest")
            var f = document.querySelector("#email")
            var g = document.querySelector("#mobile")
            if(a.value == "Time" || b.value == "Table option" || c.value == "" || e.value == "" || f.value == "" || g.value == "") {
                event.preventDefault()
                alert("Fill up all fields!")
            }
        });
        $(document).ready(function() {
            setTimeout(function() {
                $('.notif').fadeIn();
            }, 2400);
            setTimeout(function() {
                $('.notif').fadeOut();
            }, 3000);
        });
  
        //$("#datepick").datetimepicker({disabledDates: disabledDate,
        //minDate:new Date()});

        // var today = new Date();
        // var dd = String(today.getDate()).padStart(2, '0');
        // var mm = String(today.getMonth() + 1).padStart(2, '0');
        // var yyyy = today.getFullYear();
        
        // today = yyyy + '-' + mm + '-' + dd;
       
        // $('#datepick').attr('min',today);

        
    </script>
    <script type="text/javascript">

        // var datesForDisable = ["01-30-2023", "01-31-2023", "01-25-2023"]
        var datesForDisable = <?php echo json_encode($drows) ?>;
        var date = new Date();
        var todaynow = new Date(date.getFullYear(), date.getMonth(), date.getDate());

        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            datesDisabled: datesForDisable,
            startDate: todaynow
        });

    </script>
</body>
</html>