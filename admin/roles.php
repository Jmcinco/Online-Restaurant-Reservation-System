<?php

include '../server/config.php';

if (!$_SESSION['role'] || $_SESSION['role'] !== 'superadmin' && !$_SESSION['isLogged']) {
    echo '<script>location.href="index.php?unathorized"</script>';
} else if ($_SESSION['isLogged'] && $_SESSION['role'] !== 'superadmin') {
    echo '<script>location.href="reservation-list.php"</script>';
}

if (isset($_POST['addrole'])) {

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    $checkIfExisting = "SELECT * FROM admin_account WHERE username = '$username' OR email = '$email'";
    $checkResult = mysqli_query($conn, $checkIfExisting);

    if (mysqli_num_rows($checkResult) > 0) {
        $alert = "<div class='alert alert-danger text-center' role='alert'>Username or Email has already been taken!</div>";
    } else {
        $add = "INSERT INTO admin_account (email, username, password, role) VALUES ('$email', '$username', '$password', '$role')";
        mysqli_query($conn, $add);

        echo '<script>location.href="roles.php?success-add"</script>';
    }

}

if (isset($_GET['success-add'])) {
    $alert = "<div class='alert alert-info text-center' role='alert'>Role successfully added!</div>";
} else if (isset($_GET['success-remove'])) {
    $alert = "<div class='alert alert-info text-center' role='alert'>Role removed successfully!</div>";
}

if (isset($_GET['remove_id'])) {

    $removeID = $_GET['remove_id'];

    $removeQuery = "DELETE FROM admin_account WHERE id = '$removeID'";
    mysqli_query($conn, $removeQuery);

    echo '<script>location.href="roles.php?success-remove"</script>';

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New User</title>
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
            <img src="../assets/images/pw.png" alt="" height="50">
            <h4 style="margin-top: 8px; margin-left: 8px;">Piggy Wings</h4>
        </div>
        <div class="my-profile">
            <div class="dropdown">
                <button class="btn text-light dropdown-toggle" type="button" id="dropdownMenuButton1"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <span>
                        <?= $_SESSION['role'] === 'superadmin' ? 'Administrator' : ucwords($_SESSION['role']) ?>
                    </span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="admin-account-settings.php">My Profile</a></li>
                    <li><a onclick="return adminLogout()" class="dropdown-item text-danger"
                            href="javascript::void(0)">Logout</a></li>
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
                <span>
                    <?= $_SESSION['role'] === 'superadmin' ? 'Administrator' : ucwords($_SESSION['role']) ?>
                </span>
            </div>
        </div>
        <hr>
        <div class="sidebar-items">
            <a data-bs-toggle="tooltip" data-bs-placement="right" title="Reservation Table" href="reservation-list.php">
                <li><i class="fa-solid fa-table-list"></i> <span>Reservation Table</span></li>
            </a>
            <a data-bs-toggle="tooltip" data-bs-placement="right" title="Approved List" href="approved-reservation.php">
                <li><i class="fa-solid fa-check"></i></i> <span>Approved List</span></li>
            </a>
            <a data-bs-toggle="tooltip" data-bs-placement="right" title="History" href="history.php">
                <li><i class="fa-solid fa-clock-rotate-left"></i> <span>History</span></li>
            </a>
            <a style="display: <?= $_SESSION['role'] !== 'superadmin' ? 'none' : '' ?>" data-bs-toggle="tooltip"
                data-bs-placement="right" title="Reservation Table" href="roles.php" class="active">
                <li><i class="fa-solid fa-users"></i> <span>Create New User</span></li>
            </a>
            <a style="display: <?= $_SESSION['role'] !== 'superadmin' ? 'none' : '' ?>" data-bs-toggle="tooltip"
    data-bs-placement="right" title="Date Maintenance" href="dmaintenance.php">
    <li><i class="fa-solid fa-calendar"></i> <span>Date Maintenance</span></li>
</a>
            <hr>
            <a data-bs-toggle="tooltip" data-bs-placement="right" title="Menu" href="menu.php">
                <li><i class="fa-solid fa-burger"></i> <span>Menu</span></li>
            </a>
            <a data-bs-toggle="tooltip" data-bs-placement="right" title="Promotions" href="promotions.php">
                <li><i class="fa-solid fa-gift"></i> <span>Promotions</span></li>
            </a>
            <a data-bs-toggle="tooltip" data-bs-placement="right" title="Customer Gallery" href="customer-gallery.php">
                <li><i class="fa-solid fa-images"></i> <span>Customer Gallery</span></li>
            </a>
            <hr>
        </div>
    </div>

    <div class="containerLoader">
        <div class="content-main">
            <div class="content-head d-flex align-items-center justify-content-between">
                <h1>Create new User</h1>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRole"><i
                        class="fa-solid fa-plus"></i> Add</button>
            </div>


            <!-- ADD ROLE MODAL -->


            <form method="POST">
                <div class="modal fade" id="addRole" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Role</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group mb-3">
                                    <label for="username">Username</label>
                                    <input style="margin: 0;" type="text" name="username" required autocomplete="off"
                                        id="username" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="email">Email</label>
                                    <input style="margin: 0;" type="email" name="email" required autocomplete="off"
                                        id="email" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password">Password</label>
                                    <input style="margin: 0;" type="password" name="password" required
                                        autocomplete="off" id="password" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="role">Role</label>
                                    <select style="margin: 0" name="role" id="role" class="form-select">
                                        <option value="manager">Manager</option>
                                        <option value="staff">Staff</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="addrole" class="btn btn-primary">Add</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>


            <hr>
            <div class="content-body">
                <?php
                if (isset($alert)) {
                    echo $alert;
                }
                ?>
                <table class="table" id="myTable" style="width: 100%">
                    <thead>
                        <tr class="text-center">
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $getData = "SELECT * FROM admin_account WHERE role <> 'superadmin'";
                        $resultData = mysqli_query($conn, $getData);

                        while ($row = mysqli_fetch_assoc($resultData)) {

                            ?>

                            <tr class="text-center">
                                <td>
                                    <?= $row['username'] ?>
                                </td>
                                <td>
                                    <?= $row['email'] ?>
                                </td>
                                <td>
                                    <?= ucwords($row['role']) ?>
                                </td>
                                <td>
                                    <!-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewRole<?= $row['id'] ?>"><i class="fas fa-eye"></i></button> -->
                                    <a onclick="return confirm('Delete this role?') ? true : false"
                                        href="roles.php?remove_id=<?= $row['id'] ?>" class="btn btn-danger"><i
                                            class="fa-solid fa-trash"></i></a>
                                </td>


                                <!-- Modal -->
                                <!-- <div class="modal fade" id="viewRole<?= $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel"><?= $row['username'] ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        ...
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="button" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->


                            </tr>

                        <?php }

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="../main-js/script.js"></script>
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable({
                "pageLength": 5,
                "scrollX": true
            });
            setTimeout(function () {
                $('.notif').fadeIn();
            }, 2400);
            setTimeout(function () {
                $('.notif').fadeOut();
            }, 3000);
        });
    </script>
</body>

</html>