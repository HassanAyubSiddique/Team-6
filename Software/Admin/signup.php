<?php
// Include the database connection file
include 'php/db_connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $postcode = $_POST['postcode'];
    $country = $_POST['country'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Determine which table to insert data based on the selected role
    switch ($role) {
        case 'client':
            $table = 'clients';
            break;
        case 'staff':
            $table = 'staff';
            break;
        default:
            // Handle error for invalid role (you can redirect back to the form with an error message)
            header("Location: signup.html?error=invalid_role");
            exit();
    }

    // Prepare the SQL statement to insert data into the appropriate table
    $query = "INSERT INTO $table (first_name, last_name, email, phone_number, address, city, postcode, country, password) 
              VALUES ('$firstName', '$lastName', '$email', '$phoneNumber', '$address', '$city', '$postcode', '$country', '$hashedPassword')";

    // Execute the query
    if (mysqli_query($con, $query)) {
        // Data inserted successfully, redirect to a success page or login page
        header("Location: signup_success.html");
        exit();
    } else {
        // Error in insertion, handle error (you can redirect back to the form with an error message)
        header("Location: signup.html?error=insertion_failed");
        exit();
    }
} else {
    // If form is not submitted, display error message or redirect to the form page
    header("Location: signup.html?error=form_not_submitted");
    exit();
}
?>
