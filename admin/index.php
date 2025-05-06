<?php
    
    include '../server/config.php';

    $_SESSION['isLogged'] = null;

    if(isset($_POST['admin-login'])) {

        $_SESSION['isLogged'] = false;

        $username = trim(mysqli_real_escape_string($conn, $_POST['username']));
        $password = trim(mysqli_real_escape_string($conn, $_POST['password']));
        
        $login = "SELECT * FROM admin_account WHERE username = '$username' AND password = '$password'";
        $loginResult = mysqli_query($conn, $login);

        if(mysqli_num_rows($loginResult) == 1) {

            while($row = mysqli_fetch_assoc($loginResult)) {

                $_SESSION['role'] = $row['role'];
                $_SESSION['username'] = $row['username'];

            }

            $_SESSION['isLogged'] = true;

            header("Location: reservation-list.php?welcome");
            exit();

        } else {
            $alert = '<div class="alert alert-danger text-center alert-dismissible fade show notif" role="alert">
                <i class="fa-solid fa-circle-info"></i> Invalid Username or Password
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        ';
        }

    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../main-css/style.css">
    <?php include '../assets/templates/template.php'; ?>

</head>
<body>
    
    <div class="card p-3 m-auto card-login mt-5">
        <div class="card-image text-center">
            <img src="../assets/images/pw.png" width="100" height="100" alt="">
            <h1 class="text-center mt-3">Admin Login</h1>
        </div>
        <?php if(isset($alert)) { echo $alert; } ?>
        <div class="card-body">
            <form method="POST">
                <div class="form-group mb-3">
                    <label for="username">Username</label>
                    <input type="text" autocomplete="off" name="username" style="margin: 0;" id="username" class="form-control">
                </div>
                <div class="form-group mb-4">
                    <label for="password">Password</label>
                    <input type="password" autocomplete="off" name="password" style="margin: 0;" id="password" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <button type="submit" name="admin-login" class="btn btn-primary w-100"><i class="fa-solid fa-right-to-bracket"></i> Sign In</button>
                </div>
            </form>
        </div>
    </div>

    <script src="../main-js/script.js"></script>
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