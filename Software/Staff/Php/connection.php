<?php

// Database connection parameters
$server = "localhost";
$user = "root";
$dbpassword = "";
$dbname = "test";

// Establishing database connection
$con = mysqli_connect($server, $user, $dbpassword, $dbname);

// Checking if the connection is successful
if (!$con) {
    echo "<script>alert('There is no connection to the database')</script>";
    echo "<script>alert('There is connection to the database')</script>"; 
    exit();
} else {
    // Connection successful, do nothing
}

?>
