<?php

// Include the connection file
include 'db_connection.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password using bcrypt
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $role = $_POST['role']; // New field to capture selected role
    $address = $_POST['address'];
    $city = $_POST['city'];
    $postcode = $_POST['postcode'];
    $country = $_POST['country'];
    $phonenumber = $_POST['phonenumber'];

    // Define default status
    $status = "Pending";

    // Check the selected role and insert into the appropriate table
    if ($role == "client") {
        $insertquery = "INSERT INTO clients (first_name, last_name, phone_number, email, password, address, city, postcode, country, status) 
                        VALUES ('$name', '$surname', '$phonenumber', '$email', '$hashed_password', '$address', '$city', '$postcode', '$country', '$status')";
    } elseif ($role == "staff") {
        $insertquery = "INSERT INTO staff (first_name, last_name, phone_number, email, password, address, city, postcode, country, status) 
                        VALUES ('$name', '$surname', '$phonenumber', '$email', '$hashed_password', '$address', '$city', '$postcode', '$country', '$status')";
    } else {
        // Invalid role selected
        echo "<script>alert('Invalid role selected')</script>";
        echo "<script>window.location.href='../login.php'</script>";
        exit();
    }

    $query = mysqli_query($conn, $insertquery);

    if ($query) {
        // New user added successfully
        echo "<script>alert('New user has been added! Please wait until your account is approved.')</script>";
        echo "<script>window.location.href='../login.php'</script>";
        exit();
    } else {
        // Error occurred, display error message
        echo "<script>alert('Please try again later')</script>";
        echo "<script>window.location.href='../login.php'</script>";
        exit();
    }
} else {
    // If the submit button is not set, display error message and redirect to index.php
    echo "<script>alert('Please try again later')</script>";
    echo "<script>window.location.href='../login.php'</script>";
    exit();
}

?>