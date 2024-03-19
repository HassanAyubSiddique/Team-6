<?php

include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Check if user exists
    $sql = "SELECT * FROM customer WHERE email='$email' AND password='$password'";
    $result = mysqli_query($con, $sql);
    $count = mysqli_num_rows($result);

    if ($count == 1) {
        // User exists, redirect to home page and display success message
        session_start();
        $_SESSION["customerloggedin"] = true;
        echo "<script>alert('You are successfully logged in!')</script>";
        exit();
    } else {
        // User does not exist or password is incorrect
        session_start();
        $_SESSION["customerlogin_error"] = true;
        echo "<script>alert('Please type correct details!')</script>";

        exit();
    }

    // Close the database connection
    mysqli_close($con);
}
