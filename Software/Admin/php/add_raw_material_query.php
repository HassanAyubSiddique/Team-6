<?php
// Include database connection
include 'db_connection.php';

// Check if form is submitted
if(isset($_POST['submit'])){
    // Get form data
    $raw_material_name = $_POST['raw_material_name'];
    $raw_material_description = $_POST['raw_material_description'];
    
    // Check if an image is uploaded
    if(isset($_FILES['raw_material_image']) && $_FILES['raw_material_image']['size'] > 0) {
        // Retrieve image data
        $rawMaterialImage = file_get_contents($_FILES['raw_material_image']['tmp_name']);

        // Prepare the SQL statement with a placeholder for the binary data
        $sql = "INSERT INTO raw_materials (name, description, image) VALUES (?, ?, ?)";

        // Create a prepared statement
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("sss", $raw_material_name, $raw_material_description, $rawMaterialImage);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to add_raw_material_query.php with success message
            echo "<script>alert('Raw material added successfully'); window.location.href = '../AddRawMaterial.php';</script>";
        } else {
            // Redirect to add_raw_material_query.php with error message
            echo "<script>alert('Error adding raw material: " . $stmt->error . "'); window.location.href = '../AddRawMaterial.php';</script>";
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        // If image is not uploaded, show error message and redirect
        echo "<script>alert('Please upload an image.'); window.location.href = '../AddRawMaterial.php';</script>";
    }

    // Close connection
    $conn->close();
} else {
    // If form is not submitted, redirect to add_raw_material_query.php
    header("Location: ../AddRawMaterial.php");
    exit(); // Stop further execution
}
?>
