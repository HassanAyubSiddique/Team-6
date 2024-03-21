<?php
// Include database connection
include 'db_connection.php';

// Check if form is submitted
if(isset($_POST['submit'])){
    // Retrieve form data
    $productId = $_POST['product_id'];
    $productName = $_POST['name'];
    $productDescription = $_POST['description'];

    // Check if an image is uploaded
    if(isset($_FILES['main_image']) && $_FILES['main_image']['size'] > 0) {
        // Retrieve image data
        $productImage = $_FILES['main_image']['tmp_name'];

        // Read the image file content and convert it to binary
        $productImageBinary = file_get_contents($productImage);

        // Prepare image data for insertion
        $productImageBlob = $conn->real_escape_string($productImageBinary);

        // Update product with image
        $sql = "UPDATE products SET name = '$productName', description = '$productDescription', main_image = '$productImageBlob' WHERE product_id = $productId";
    } else {
        // Update product without image
        $sql = "UPDATE products SET name = '$productName', description = '$productDescription' WHERE product_id = $productId";
    }

    // Execute the SQL query
    if ($conn->query($sql) === TRUE) {
        echo "Product updated successfully";
    } else {
        echo "Error updating product: " . $conn->error;
    }

    // Close connection
    $conn->close();

    // Redirect back to products.php
    header("Location: ../products.php");
    exit();
} else {
    // If form is not submitted, redirect back to products.php
    header("Location: ../products.php");
    exit();
}
?>
