<?php
// Include the database connection file
include 'DatabaseConnection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password']; // Make sure to add the name attribute for the password input field in your HTML form

    // Debugging statements
    echo "Email: " . $email . "<br>";
    echo "Password: " . $password . "<br>";

    // Query to check client table
    $client_query = "SELECT * FROM client WHERE email='$email' AND password='$password'";
    $client_result = mysqli_query($con, $client_query);

    if (mysqli_num_rows($client_result) == 1) {
        // Client found, redirect to clientpage.html
        header("Location: clientpage.html");
        exit();
    } else {
        echo "Client not found<br>";
    }

    // Query to check staff table
    $staff_query = "SELECT * FROM staff WHERE email='$email' AND password='$password'";
    $staff_result = mysqli_query($con, $staff_query);

    if (mysqli_num_rows($staff_result) == 1) {
        // Staff found, redirect to staffpage.html
        header("Location: staffpage.html");
        exit();
    } else {
        echo "Staff not found<br>";
    }

    // Query to check admin table
    $admin_query = "SELECT * FROM admin WHERE email='$email' AND password='$password'";
    $admin_result = mysqli_query($con, $admin_query);

    if (mysqli_num_rows($admin_result) == 1) {
        // Admin found, redirect to adminpage.html
        header("Location: adminpage.html");
        exit();
    } else {
        echo "Admin not found<br>";
    }

    // If no matching user found, redirect back to login page with error message
    header("Location: login.html?error=1");
    exit();
} else {
    // If form is not submitted, display error message
    echo "Form not submitted<br>";
}
?>
