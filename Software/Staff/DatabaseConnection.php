<?php
$server = "localhost";
$user = "root";
$dbpassword = "";
$dbname = "wms";

$con = mysqli_connect($server, $user, $dbpassword, $dbname);

if (!$con) {
    echo "<script>alert('There is no connection to the database')</script>";
    echo "<script>alert('There is connection to the database')</script>"; 
    exit();
} else {
    // Connection successful, do nothing
}
?>