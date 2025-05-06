<?php
    include '../server/config.php';

    if (!isset($_SESSION['isLogged']) || !$_SESSION['isLogged'] || !in_array($_SESSION['role'], ['superadmin', 'manager'])) {
        echo '<script>location.href="index.php?unathorized"</script>';
    }

    if (isset($_POST['add_food'])) {
        $menu_name = trim(mysqli_real_escape_string($conn, $_POST['menu_name']));
        $menu_desc = trim(mysqli_real_escape_string($conn, $_POST['menu_desc']));
        $fileName = $_FILES["photo"]["name"];
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 5 * 1024 * 1024; // 5MB

        if (!empty($fileName)) {
            $file_type = $_FILES["photo"]["type"];
            $file_size = $_FILES["photo"]["size"];
            if (!in_array($file_type, $allowed_types) || $file_size > $max_size) {
                $alert = '<div class="alert alert-danger alert-dismissible fade show notif" role="alert">
                            <i class="fa-solid fa-circle-info"></i> Invalid file type or size! Only JPEG, PNG, GIF up to 5MB allowed.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
            } else {
                $randomInt = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
                $imageName = $randomInt . $fileName;
                $tempname = $_FILES["photo"]["tmp_name"];
                $folder = "uploaded/" . $imageName;

                if (!move_uploaded_file($tempname, $folder)) {
                    $alert = '<div class="alert alert-danger alert-dismissible fade show notif" role="alert">
                                <i class="fa-solid fa-circle-info"></i> Failed to upload image!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                }
            }
        } else {
            $imageName = '';
        }

        if (!isset($alert)) {
            $getAllFood = "SELECT * FROM food WHERE menu_name = ?";
            $stmt = $conn->prepare($getAllFood);
            $stmt->bind_param("s", $menu_name);
            $stmt->execute();
            $getFoodResult = $stmt->get_result();

            if (mysqli_num_rows($getFoodResult) > 0) {
                $alert = '<div class="alert alert-danger alert-dismissible fade show notif" role="alert">
                            <i class="fa-solid fa-circle-info"></i> ' . ucwords($menu_name) . ' already exist!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
            } else {
                $stmt = $conn->prepare("INSERT INTO food (menu_name, menu_pic, menu_desc) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $menu_name, $imageName, $menu_desc);
                $stmt->execute();
                $alert = '<div class="alert alert-info alert-dismissible fade show notif" role="alert">
                            <i class="fa-solid fa-circle-info"></i> Menu has been added!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
            }
        }
    }

    if (isset($_GET['removeitem'])) {
        $getid = $_GET['removeitem'];
        $stmt = $conn->prepare("DELETE FROM food WHERE id = ?");
        $stmt->bind_param("i", $getid);
        $stmt->execute();
        $alert = '<div class="alert alert-info alert-dismissible fade show notif" role="alert">
                    <i class="fa-solid fa-circle-info"></i> Menu has been deleted!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
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
                    <span><?= $_SESSION['role'] === 'superadmin' ? 'Administrator' : ucwords($_SESSION['role']) ?></span>
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
                <span><?= $_SESSION['role'] === 'superadmin' ? 'Administrator' : ucwords($_SESSION['role']) ?></span>
            </div>
        </div>
        <hr>
        <div class="sidebar-items">
            <a data-bs-toggle="tooltip" data-bs-placement="right" title="Reservation Table" href="reservation-list.php"><li><i class="fa-solid fa-table-list"></i> <span>Reservation Table</span></li></a>
            <a data-bs-toggle="tooltip" data-bs-placement="right" title="Approved List" href="approved-reservation.php"><li><i class="fa-solid fa-check"></i> <span>Approved List</span></li></a>
            <a data-bs-toggle="tooltip" data-bs-placement="right" title="History" href="history.php"><li><i class="fa-solid fa-clock-rotate-left"></i> <span>History</span></li></a>
            <a style="display: <?= $_SESSION['role'] !== 'superadmin' ? 'none' : '' ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Create New User" href="roles.php"><li><i class="fa-solid fa-users"></i> <span>Create New User</span></li></a>
            <a style="display: <?= $_SESSION['role'] !== 'superadmin' ? 'none' : '' ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Date Maintenance" href="dmaintenance.php"><li><i class="fa-solid fa-calendar"></i> <span>Date Maintenance</span></li></a>
            <hr>
            <a data-bs-toggle="tooltip" data-bs-placement="right" title="Menu" href="menu.php" class="active"><li><i class="fa-solid fa-burger"></i> <span>Menu</span></li></a>
            <a data-bs-toggle="tooltip" data-bs-placement="right" title="Promotions" href="promotions.php"><li><i class="fa-solid fa-gift"></i> <span>Promotions</span></li></a>
            <a data-bs-toggle="tooltip" data-bs-placement="right" title="Customer Gallery" href="customer-gallery.php"><li><i class="fa-solid fa-images"></i> <span>Customer Gallery</span></li></a>
            <hr>
        </div>
    </div>

    <div class="containerLoader">
        <div class="content-main">
            <div class="content-head d-flex justify-content-between align-items-center">
                <h1>Food List</h1>
                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary">Add</a>
            </div>
            <form method="POST" id="addMenu" enctype="multipart/form-data">
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Menu</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group mb-3">
                                    <label for="food_name">Menu Name</label>
                                    <input type="text" required style="margin: 0;" name="menu_name" id="food_name" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="file">Menu Image</label>
                                    <input type="file" style="margin: 0;" name="photo">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="menu_desc">Menu Description</label>
                                    <textarea name="menu_desc" id="menu_desc" rows="4" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button onclick="return addItem()" type="submit" name="add_food" class="btn btn-primary">Add</button>
                            </div>
                        </div>
                    </div>
                </form>
            <hr>
            <div class="content-body">
                <?php if (isset($alert)) { echo $alert; } ?>
                <table class="table" id="myTable" style="width: 100%">
                    <thead>
                        <tr class="text-center">
                            <th>Menu Pic</th>
                            <th>Menu Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $selectMenu = "SELECT * FROM food ORDER BY id DESC";
                            $menuResult = mysqli_query($conn, $selectMenu);

                            if ($menuResult) {
                                while ($row = mysqli_fetch_assoc($menuResult)) {
                                    $menu_id = $row['id'];
                                    $menu_pic = $row['menu_pic'];
                                    $menu_name = $row['menu_name'];
                                    $menu_desc = $row['menu_desc'];

                                    echo '
                                        <tr class="text-center">
                                            <td><img src="uploaded/' . ($menu_pic) . '" height="50" width="50" alt=""></td>
                                            <td>' . $menu_name . '</td>
                                            <td>' . $menu_desc . '</td>
                                            <td>
                                                <a href="edit-menu.php?edititem=' . $menu_id . '" title="Edit" class="btn btn-primary btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a onclick="return removeItem()" href="menu.php?removeitem=' . $menu_id . '" title="Delete" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
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
    
    <script src="../main-js/script.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                "pageLength": 5,
                "scrollX": true
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