<?php

    include '../server/config.php';
    // if(!$_SESSION['otp-verify']) {
    //     header("Location: reservation.php?error");
    //     exit();
    // }

    $getEmail = $_GET['email'];

    if(empty(isset($_GET['email']))) {
        header("Location: reservation.php?error");
        exit();
    }

    $decode = base64_decode($getEmail);

    $getCode = "SELECT * FROM reservation WHERE email = '$decode'";
    $getResult = mysqli_query($conn, $getCode);

    if($getResult) {
        while($row = mysqli_fetch_assoc($getResult)) {
            $getCode = $row['otpCode'];
            $name = $row['name'];
            $tableSelected = $row['table_reserved'];
            $no_of_guest = $row['no_of_guest'];
            $isApproved = $row['isApproved'];
            $email = $row['email'];
            $mobile = $row['mobile'];
            $date = $row['date'];
            $time = $row['time'];
        }
    }
        
    $getTotal = "SELECT * FROM table_types WHERE type = '$tableSelected'";
    $getResult1 = mysqli_query($conn, $getTotal);

    if($getResult1) {
        while($row1 = mysqli_fetch_assoc($getResult1)) {
            $id = $row1['id'];
            $type = $row1['type'];
            $total = $row1['total'];
            $remaining = $row1['remaining'];
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
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
                    <li class="active"><a href="reservation.php">RESERVATION</a></li>
                    <li><a href="contact.php">CONTACT US</a></li>
                    <li><a href="about.php">ABOUT US</a></li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="verification">
        <div class="card verification-card p-3 rounded shadow-lg bg-light">
            <div class="card-title text-center mt-3">
                <h3>OTP Verification</h3>
            </div>
            <hr>
            <div class="alert alert-info text-center" role="alert">
                Please enter 6-digit code for <br><strong><?=base64_decode($getEmail)?></strong>
            </div>
            <div class="card-body">
                <form method="POST" id="form">
                    <div class="form-group">
                        <input onkeydown="return onlyNumberKey(event)" type="text" id="code" style="margin: 0;" class="form-control" placeholder="Enter 6 digit code.." name="code" id="code">
                    </div>
                    <div class="form-group">
                        <input type="submit" name="verify" id="verify" value="Submit" class="btn btn-primary" style="margin: 0; margin-top: 30px;">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../main-js/script.js"></script>
</body>
</html>
<?php

    if(isset($_POST['verify'])) {

        $code = mysqli_real_escape_string($conn, $_POST['code']);

        if($code != $getCode) {

            echo '<script>
            
                $("#form").submit((event) => {
                    var code = document.querySelector("#code");
                    var verify = document.querySelector("#verify");
        
                    if(code.value == "") {
                        event.preventDefault()
                        alert("Please Enter Code!")
                    } else if(code.value != '.$getCode.') {
                        event.preventDefault()
                        alert("Invalid Code!")
                    }
                });
            
            </script>';

        } else {

            $updateStatus = "UPDATE reservation SET isPending = 0, isVerified = 1 WHERE email = '$decode'";
            $updateResult = mysqli_query($conn, $updateStatus);

            $newRemaining = $remaining - $no_of_guest;

            $updateRemaining = "UPDATE table_types SET remaining = '$newRemaining' WHERE type ='$tableSelected'";
            $remainResult = mysqli_query($conn, $updateRemaining);

            echo '<script>alert("Thank you for verifying your reservation. We will check your response as quickly as we can, please check your email from time to time.\nThank you!"); location.href="index.php"</script>';
        }

    }

?>