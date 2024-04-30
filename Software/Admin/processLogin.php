<?php
// Include the database connection file
include 'php/db_connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Display alert to confirm form submission
    echo "<script>alert('Form submitted.');</script>";

    // Query to check admins table
    $admin_query = "SELECT * FROM admins WHERE email='$email' AND password='$password'";
    $admin_result = mysqli_query($conn, $admin_query);
    if (!$admin_result) {
        // Display alert if query fails
        echo "<script>alert('Admin query failed: " . mysqli_error($con) . "');</script>";
    }

    // If admin found, redirect to AdminDashboard.HTML
    if (mysqli_num_rows($admin_result) == 1) {
        // Display alert to confirm admin found
        echo "<script>alert('Admin found.');</script>";
        header("Location: AdminDashboard.HTML");
        exit();
    } else {
        // If no matching admin found, display error message and redirect
        echo "<script>alert('Invalid email or password. Please try again.');</script>";
        echo "<script>window.location.href='login.php';</script>";
        exit();
    }
} else {
    // If form is not submitted, display error message
    echo "<script>alert('Form not submitted.');</script>";
    echo "<script>window.location.href='login.php';</script>";
}
?>
