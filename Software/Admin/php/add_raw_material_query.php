<?php
// Include database connection
include 'db_connection.php';

// Check if form is submitted
if(isset($_POST['submit'])){
    // Get form data
    $raw_material_name = $_POST['raw_material_name'];
    $raw_material_description = $_POST['raw_material_description'];
    
    // Get image data
    $raw_material_image = file_get_contents($_FILES['raw_material_image']['tmp_name']);
    
    // Prepare image data for insertion
    $raw_material_image = $conn->real_escape_string($raw_material_image);
    
    // Insert raw material data into database
    $sql = "INSERT INTO raw_materials (name, description, image) VALUES (?, ?, ?)";
    
    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("sss", $raw_material_name, $raw_material_description, $raw_material_image);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to add_raw_material_query.php with success message
        echo "<script>alert('Raw material added successfully'); window.location.href = '../add_raw_material.php';</script>";
    } else {
        // Redirect to add_raw_material_query.php with error message
        echo "<script>alert('Error adding raw material: " . $stmt->error . "'); window.location.href = '../add_raw_material.php';</script>";
    }
    
    // Close the prepared statement
    $stmt->close();

    // Close connection
    $conn->close();
} else {
    // If form is not submitted, redirect to add_raw_material_query.php
    header("Location: ../add_raw_material.php");
    exit(); // Stop further execution
}
?>
