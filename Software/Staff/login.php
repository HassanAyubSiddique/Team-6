<?php
// Include the database connection file
include 'DatabaseConnection.php';

// Check if database connection is successful
if (!$con) {
    // If database connection fails, display error message
    echo "Database connection error: " . mysqli_connect_error();
    exit(); // Stop further execution
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password']; // Make sure to add the name attribute for the password input field in your HTML form

    // Query to check client table
    $client_query = "SELECT * FROM client WHERE email='$email' AND password='$password'";
    $client_result = mysqli_query($con, $client_query);

    if (mysqli_num_rows($client_result) == 1) {
        // Client found
        echo "client";
        exit();
    }

    // Query to check staff table
    $staff_query = "SELECT * FROM staff WHERE email='$email' AND password='$password'";
    $staff_result = mysqli_query($con, $staff_query);

    if (mysqli_num_rows($staff_result) == 1) {
        // Staff found
        echo "staff";
        exit();
    }

    // Query to check admin table
    $admin_query = "SELECT * FROM admin WHERE email='$email' AND password='$password'";
    $admin_result = mysqli_query($con, $admin_query);

    if (mysqli_num_rows($admin_result) == 1) {
        // Admin found
        echo "admin";
        exit();
    }

    // If no matching user found, return an identifier indicating no user found
    echo "notfound";
    exit();
} else {
    // If form is not submitted, display error message
    echo "Form not submitted";
}
?>
