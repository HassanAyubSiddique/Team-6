<?php
// Include the database connection file
include 'DatabaseConnection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $rawMaterialProductName = $_POST['rawMaterialProductName'];
    $quantity = $_POST['quantity'];

    // SQL query to insert data into the table
    $sql = "INSERT INTO your_order_table (rawMaterialProductName, quantity) VALUES ('$rawMaterialProductName', '$quantity')";

    // Execute the query
    if (mysqli_query($con, $sql)) {
        echo "<script>alert('Order placed successfully');</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
    }
}

// Close the database connection
mysqli_close($con);
?>
