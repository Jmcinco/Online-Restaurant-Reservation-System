<?php

    session_start();

    include 'database.php';

    !$conn ? die("Connection error" . mysqli_connect_error()) : '';