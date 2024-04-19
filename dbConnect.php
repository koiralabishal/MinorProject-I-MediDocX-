<?php
    $server = "localhost";
    $user = "root";
    $pass = "";
    $database = "password";

    $conn = mysqli_connect($server, $user, $pass, $database);

    if (!$conn){
        echo "Connection Failure";
    }

    // $sql = "SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'";
    // $result = mysqli_query($conn, $sql);