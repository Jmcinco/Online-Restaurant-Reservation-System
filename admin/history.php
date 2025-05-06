<?php

    include '../server/config.php';

    if(!$_SESSION['isLogged']) {
        echo '<script>location.href="index.php?unathorized"</script>';
    }

    if(isset($_GET['month']) && !isset($_GET['status'])) {
        $selectedMonth = $_GET['month'];
        $selectedStatus = "Filter by Status";
        $displayMonth = true;
        $displayStatus = false;
    } else if(!isset($_GET['month']) && isset($_GET['status'])) {
        $selectedStatus = $_GET['status'];
        $selectedMonth = "Filter by Month";
        $displayStatus = true;
        $displayMonth = false;
    } else if(isset($_GET['month']) && isset($_GET['status'])) {
        $selectedMonth = $_GET['month'];
        $selectedStatus = $_GET['status'];
        $displayStatus = true;
        $displayMonth = true;
    } else {
        $displayMonth = false;
        $displayStatus = false;
        $selectedMonth = "Filter by Month";
        $selectedStatus = "Filter by Status";
    }

    if($displayMonth && $displayStatus) {
       
        $whereClause = " WHERE created_at LIKE '%$selectedMonth%' AND result = '$selectedStatus'";
    } else if($displayMonth && !$displayStatus) {
        $whereClause = " WHERE created_at LIKE '%$selectedMonth%'";
    } else if(!$displayMonth && $displayStatus) {
        $whereClause = " WHERE status = '$selectedStatus'";
    } else {
        
        $whereClause = "";
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>
    <link rel="stylesheet" href="../main-css/style.css">
        
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
                    <li><a class="dropdown-item" href="admin-account-settings.php">My Profile</a></li>
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
            <a data-bs-toggle="tooltip" data-bs-placement="right" title="Approved List" href="approved-reservation.php"><li><i class="fa-solid fa-check"></i></i> <span>Approved List</span></li></a>
            <a data-bs-toggle="tooltip" data-bs-placement="right" title="History" href="history.php" class="active"><li><i class="fa-solid fa-clock-rotate-left"></i> <span>History</span></li></a>
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
            <div class="content-head d-flex justify-content-between align-items-center">
                <h1>History</h1>
                <div class="filter-section d-flex align-items-center gap-3">
                    <a class="btn btn-danger" style="border-radius: 50%; display: <?=$displayMonth || $displayStatus ? '' : 'none'?>" href="history.php">X</a>
                    <select name="month" id="month" class="form-select" onchange="location = this.value">
                        <option disabled selected><?=$selectedMonth?></option>
                        <?php

                            $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                            
                            if($displayStatus) {
                                for($i = 0; $i < count($months); $i++) {
                                    echo '<option value="history.php?month='.$months[$i].'&status='.$selectedStatus.'">'.$months[$i].'</option>';
                                }
                            } else {
                                for($i = 0; $i < count($months); $i++) {
                                    echo '<option value="history.php?month='.$months[$i].'">'.$months[$i].'</option>';
                                }
                            }
                        
                        ?>
                    </select>
                    <select name="status" id="status" class="form-select" onchange="location = this.value">
                        <option disabled selected><?=$selectedStatus?></option>

                        <?php
                        
                            if($displayMonth) {
                                ?>
                                
                                <option value="history.php?month=<?=$selectedMonth?>&status=Approved">Approved</option>
                                <option value="history.php?month=<?=$selectedMonth?>&status=Rejected">Rejected</option>
                            <?php } else {
                                ?>
                                <option value="history.php?status=Approved">Approved</option>
                                <option value="history.php?status=Rejected">Rejected</option>
                            <?php }
                        
                        ?>
                    </select>
                    
                <div class="text-center">
                    <a target="_blank" href="reservationprint.php?data=<?=base64_encode($whereClause)?>" style="width: 80px" class="btn btn-primary"><i class="fa-solid fa-print"></i> Print</a>
                </div>
                </div>
            </div>
            <hr>
            <div class="content-body">
                <?php
                    if(isset($alert)) {
                        echo $alert;
                    }
                ?>
                <table class="table" id="myTable" style="width: 100%">
                    <thead>
                        <tr class="text-center">
                            <th>Result</th>
                            <th>Name</th>
                            <th>No. of Guest</th>
                            <th>Created Date</th>
                            <th>Created By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                            $getList = "SELECT * FROM history $whereClause ORDER BY id DESC";
                            $listResult = mysqli_query($conn, $getList);

                            if($listResult) {
                                while($row = mysqli_fetch_assoc($listResult)) {

                                    $list_id = $row['id'];
                                    $list_name = $row['name'];
                                    $list_email = $row['email'];
                                    $list_date = $row['date'];
                                    $list_time = $row['time'];
                                    $mobile = $row['mobile'];
                                    $done_at = $row['done_at'];
                                    $list_table_reserved = $row['table_reserved'];
                                    $list_no_of_guest = $row['no_of_guest'];
                                    $result = $row['result'];
                                    $date_created = $row['created_at'];
                                    $created_by = $row['created_by'];
                                    $reasonRow = $row['reason'] == 'high_volume' ? 'Due to high volume' : 'Due to private events';

                                    echo '
                                        <tr class="text-center">
                                            <td class="'.($result == 'Approved' ? 'text-success' : 'text-danger').'">'.$result.'</td>
                                            <td>'.$list_name.'</td>
                                            <td>'.$list_no_of_guest.'</td>
                                            <td>'.$date_created.'</td>
                                            <td>'.$created_by.'</td>
                                            
                                            <td>
                                                <button data-bs-toggle="modal" data-bs-target="#view'.$list_id.'" title="View" class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></button>
                                            </td>
                                        </tr>

                                        
                                        <div class="modal fade" id="view'.$list_id.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Reservation Info</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">

                                                            <div class="col-12">
                                                                <h6>Result: <span class="fw-normal '.($result == 'Approved' ? 'text-success' : 'text-danger').'">'.$result.'</span></h6>
                                                            </div>

                                                            <div class="col-12" style="display: '.($result == 'Approved' ? 'none' : '').'">
                                                                <h6>Reason: <span class="fw-normal">'.$reasonRow.'</span></h6>
                                                            </div>
                                                            
                                                            <div class="col-12">
                                                                <h6>Name: <span class="fw-normal">'.$list_name.'</span></h6>
                                                            </div>

                                                            <div class="col-12">
                                                                <h6>Email: <span class="fw-normal">'.$list_email.'</span></h6>
                                                            </div>

                                                            <div class="col-12">
                                                                <h6>Mobile Number: <span class="fw-normal">'.$mobile.'</span></h6>
                                                            </div>

                                                            <div class="col-12">
                                                                <h6>Reserved At: <span class="fw-normal">'.$list_date. ' ' . $list_time . '</span></h6>
                                                            </div>

                                                            <div class="col-12">
                                                                <h6>Done At: <span class="fw-normal">'.$done_at.'</span></h6>
                                                            </div>

                                                            <div class="col-12">
                                                                <h6>No. of Guest: <span class="fw-normal">'.$list_no_of_guest.'</span></h6>
                                                            </div>

                                                            <div class="col-12">
                                                                <h6>Table Reserved: <span class="fw-normal">'.$list_table_reserved.'</span></h6>
                                                            </div>
                                                            <div class="col-12">
                                                                <h6>Created Date: <span class="fw-normal">'.$date_created.'</span></h6>
                                                            </div>
                                                            <div class="col-12">
                                                                <h6>Created By: <span class="fw-normal">'.$created_by.'</span></h6>
                                                            </div>

                                                            
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    ';
                                }
                            }
                        
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="../main-js/script.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                "pageLength": 5,
                "scrollX": true,
                "ordering": false,
                "bFilter": false
            });
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