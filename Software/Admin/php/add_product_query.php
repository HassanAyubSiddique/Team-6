<?php
// Include database connection
include 'db_connection.php';

// Check if the form is submitted
if(isset($_POST['submit'])) {
    // Retrieve form data
    $productName = $_POST['product_name'];
    $productDescription = $_POST['product_description'];
    $productImage = file_get_contents($_FILES['product_image']['tmp_name']);

    // Prepare the SQL statement with a placeholder for the binary data
    $sql = "INSERT INTO products (name, description, main_image) VALUES (?, ?, ?)";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("sss", $productName, $productDescription, $productImage);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to add_product_query.php with success message
        echo "<script>alert('Product added successfully'); window.location.href = '../add_product.php';</script>";
    } else {
        // Redirect to add_product_query.php with error message
        echo "<script>alert('Error adding product: " . $stmt->error . "'); window.location.href = '../add_product.php';</script>";
    }
    
    // Close the prepared statement
    $stmt->close();

    // Close connection
    $conn->close();
} else {
    // If form is not submitted, redirect to add_product_query.php
    header("Location: ../add_product.php");
    exit(); // Stop further execution
}
?>
