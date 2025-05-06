<?php

    include '../server/config.php';
    use PHPMailer\PHPMailer\PHPMailer;
    require '../vendor/autoload.php';

    $auth_user = $_SESSION['username'];

    if(!$_SESSION['isLogged']) {
        echo '<script>location.href="index.php?unathorized"</script>';
    }

    if(isset($_GET['remove'])) {
        
        $getID = $_GET['remove'];

        $getReserve = "SELECT * FROM reservation WHERE id = '$getID'";
        $getResult = mysqli_query($conn, $getReserve);
        if($getResult) {
            while($row = mysqli_fetch_assoc($getResult)) {
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
        $newRemaining = $remaining + $no_of_guest;
        $updateRemaining = "UPDATE table_types SET remaining = '$newRemaining' WHERE type = '$tableSelected'";
        $remainResult = mysqli_query($conn, $updateRemaining);


        $delete = "DELETE FROM reservation WHERE id = '$getID'";
        $deleteResult = mysqli_query($conn, $delete);

        $alert = '
            <div class="alert alert-info alert-dismissible fade show notif" role="alert">
                <i class="fa-solid fa-circle-info"></i> Reservation has been marked as done!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        ';

        try {

            $mail = new PHPMailer(true);
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'tablereservation.piggywings@gmail.com';
            $mail->Password = 'vdaqxcijuggduhst';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('tablereservation.piggywings@gmail.com', 'Piggy Wings');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Piggy Wings';

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
                            Hi, ' . $email . ', thank you for your trust in Piggy Wings. Hope you have experienced delicious food from us. Please come back again!
                            <br>
                            <br>
                            <span style="font-size: 20px;">Thank you for your interest to Piggy Wings!</span>
                        </h3>
                    </div>
                </div>
            ';

            $mail->send();
            

        } catch (\Throwable $th) {
            $alert = "<div class='alert alert-danger text-center' role='alert'>$mail->ErrorInfo</div>";
        }

    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation List</title>
    <link rel="stylesheet" href="../main-css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <?php include '../assets/templates/template.php' ?>
</head>
<style>
    body {
        background: none;
    }
</style>
<body>

    <div class="topnav text-light py-3 px-3 d-flex align-items-center justify-content-between">
        <div class="logo d-flex align-items-center">
            <img src="../assets/images/pw.png" alt="" height="50"> <h4 style="margin-top: 8px; margin-left: 8px;">Piggy Wings</h4>
        </div>
        <div class="my-profile">
            <div class="dropdown">
                <button class="btn text-light dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <span><?=$_SESSION['role'] === 'superadmin' ? 'Administrator' : ucwords($_SESSION['role']) ?></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="javascript:void(0)">My Profile</a></li>
                    <li><a onclick="return adminLogout()" class="dropdown-item text-danger" href="javascript::void(0)">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="sidebar shadow">
        <div class="sidebar-head d-flex align-items-center">
            <div class="profile" data-bs-toggle="tooltip" data-bs-placement="right">
                <img src="../assets/images/member_1.png" height="50" alt="">
            </div>
            <div class="profile-info">
                <span><?=$_SESSION['role'] === 'superadmin' ? 'Administrator' : ucwords($_SESSION['role']) ?></span>
            </div>
        </div>
        <hr>
        <div class="sidebar-items">
            <a data-bs-toggle="tooltip" data-bs-placement="right" title="Reservation Table" href="reservation-list.php"><li><i class="fa-solid fa-table-list"></i> <span>Reservation Table</span></li></a>
            <a data-bs-toggle="tooltip" data-bs-placement="right" title="Approved List" href="approved-reservation.php" class="active"><li><i class="fa-solid fa-check"></i></i> <span>Approved List</span></li></a>
            <a data-bs-toggle="tooltip" data-bs-placement="right" title="History" href="history.php"><li><i class="fa-solid fa-clock-rotate-left"></i> <span>History</span></li></a>
            <a style="display: <?=$_SESSION['role'] !== 'superadmin' ? 'none' : ''?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Reservation Table" href="roles.php"><li><i class="fa-solid fa-users"></i> <span>Create New User</span></li></a>
            <a style="display: <?=$_SESSION['role'] !== 'superadmin' ? 'none' : ''?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Date Maintenance" href="dmaintenance.php"><li><i class="fa-solid fa-calendar"></i> <span>Date Maintenance</span></li></a>
            <a style="display: <?=$_SESSION['role'] !== 'manager' ? 'none' : ''?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Date Maintenance" href="dmaintenance.php"><li><i class="fa-solid fa-calendar"></i> <span>Date Maintenance</span></li></a>
            <hr>
            <a style="display: <?=$_SESSION['role'] == 'staff' ? 'none' : ''?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Menu" href="menu.php"><li><i class="fa-solid fa-burger"></i> <span>Menu</span></li></a>
            <a style="display: <?=$_SESSION['role'] == 'staff' ? 'none' : ''?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Promotions" href="promotions.php"><li><i class="fa-solid fa-gift"></i> <span>Promotions</span></li></a>
            <a style="display: <?=$_SESSION['role'] == 'staff' ? 'none' : ''?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Customer Gallery" href="customer-gallery.php"><li><i class="fa-solid fa-images"></i> <span>Customer Gallery</span></li></a>
            <hr style="display: <?=$_SESSION['role'] == 'staff' ? 'none' : ''?>">
        </div>
    </div>

    <div class="containerLoader">
        <div class="content-main">
            <div class="content-head">
                <h1>Approved List</h1>
            </div>
            <hr>
            <div class="content-body">
                <?php if(isset($alert)) { echo $alert; } ?>
                <table class="table" id="myTable" style="width: 100%">
                    <thead>
                        <tr class="text-center">
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Date & Time</th>
                            <th>Table Reserved</th>
                            <th>No. of Guest</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                            $getList = "SELECT * FROM reservation WHERE isPending = 0 AND isVerified = 1 AND isApproved = 1";
                            $listResult = mysqli_query($conn, $getList);

                            if($listResult) {
                                while($row = mysqli_fetch_assoc($listResult)) {

                                    $list_id = $row['id'];
                                    $list_name = $row['name'];
                                    $list_email = $row['email'];
                                    $mobile = $row['mobile'];
                                    $list_date = $row['date'];
                                    $list_time = $row['time'];
                                    $list_table_reserved = $row['table_reserved'];
                                    $list_no_of_guestd = $row['no_of_guest'];

                                    echo '
                                        <tr class="text-center">
                                            <td class="fw-bold">'.$list_id.'</td>
                                            <td>'.$list_name.'</td>
                                            <td>'.$list_email.'</td>
                                            <td>0'.$mobile.'</td>
                                            <td>'.$list_date.' '.$list_time.'</td>
                                            <td>'.$list_table_reserved.'</td>
                                            <td>'.$list_no_of_guestd.'</td>
                                            
                                            <td>
                                                <a onclick="return markAsDone()" href="approved-reservation.php?remove='.$list_id.'" title="Mark As Done" class="btn btn-success btn-sm"><i class="fa-solid fa-check"></i></a>
                                            </td>
                                        </tr>
                                    ';
                                }
                            }
                        
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<div class="text-center">
    <button onclick="window.print();" class="btn btn-primary" id="print-btn">Print</button>
</div>
    <script src="../main-js/script.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                "pageLength": 5,
                "scrollX": true
            });
        });
    </script>
</body>
</html>
