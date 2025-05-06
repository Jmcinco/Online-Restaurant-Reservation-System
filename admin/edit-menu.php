<?php

    include '../server/config.php';

    if(!$_SESSION['isLogged'] || $_SESSION['role'] == 'staff') {
        echo '<script>location.href="index.php?unathorized"</script>';
    }

    $getmenuID = $_GET['edititem'];

    $selectMenu = "SELECT * FROM food WHERE id = '$getmenuID'";
    $menuResult = mysqli_query($conn, $selectMenu);

    if($menuResult) {
        while($row = mysqli_fetch_assoc($menuResult)) {
            $menu_id = $row['id'];
            $menu_pic = $row['menu_pic'];
            $menu_name = $row['menu_name'];
            $menu_desc = $row['menu_desc'];
        }
    }

    if(isset($_POST['updateitem'])) {

        $updateName = $_POST['updateName'];
        $updateDesc = $_POST['updateDesc'];
        $updateMenu = "UPDATE food SET menu_name = '$updateName', menu_desc = '$updateDesc' WHERE id = '$getmenuID'";
        $resultMenu = mysqli_query($conn, $updateMenu);

        if($resultMenu) {
            echo '<script>alert("Menu has been updated!"); location.href="menu.php?success"</script>';
        }

    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food List</title>
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
            <a data-bs-toggle="tooltip" data-bs-placement="right" title="History" href="history.php"><li><i class="fa-solid fa-clock-rotate-left"></i> <span>History</span></li></a>
            <a style="display: <?=$_SESSION['role'] !== 'superadmin' ? 'none' : ''?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Reservation Table" href="roles.php"><li><i class="fa-solid fa-users"></i> <span>Create New User</span></li></a>
            <hr>
            <a style="display: <?=$_SESSION['role'] == 'staff' ? 'none' : ''?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Menu" href="menu.php" class="active"><li><i class="fa-solid fa-burger"></i> <span>Menu</span></li></a>
            <a style="display: <?=$_SESSION['role'] == 'staff' ? 'none' : ''?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Promotions" href="promotions.php"><li><i class="fa-solid fa-gift"></i> <span>Promotions</span></li></a>
            <a style="display: <?=$_SESSION['role'] == 'staff' ? 'none' : ''?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Customer Gallery" href="customer-gallery.php"><li><i class="fa-solid fa-images"></i> <span>Customer Gallery</span></li></a>
            <hr>
        </div>
    </div>

    <div class="containerLoader">
        <div class="content-main">
            <div class="content-head d-flex justify-content-between align-items-center">
                <h1>Update Item</h1>
                <a href="menu.php" class="btn btn-secondary">Back</a>
            </div>
            <hr>
            <div class="content-body">
                <div class="card p-4">
                    <div class="image-div text-center">
                        <img class="border border-3" src="../admin/uploaded/<?=$menu_pic?>" height="30%" width="30%" alt="">
                    </div>
                    <hr>
                    <div class="info">
                        <form method="POST">
                            <div class="row">
                                <div class="col-md-6 mt-3">
                                    <label for="menu_name">Menu Name</label>
                                    <input type="text" value="<?=$menu_name?>" name="updateName" id="menu_name" class="form-control" style="margin: 0;">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="menu_desc">Menu Description</label>
                                    <input type="text" value="<?=$menu_desc?>" name="updateDesc" id="menu_desc" class="form-control" style="margin: 0;">
                                </div>
                            </div>
                            <div class="form-group mt-4 text-end">
                                <input onclick="return updateData()" type="submit" name="updateitem" value="Save Changes" class="btn btn-primary" style="margin: 0; width: 150px;">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <script src="../main-js/script.js"></script>
    </script>
</body>
</html>