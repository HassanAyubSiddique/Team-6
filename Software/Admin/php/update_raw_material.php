<?php
// Include database connection
include 'db_connection.php';

// Check if form is submitted
if(isset($_POST['submit'])){
    // Retrieve form data
    $rawMaterialId = $_POST['raw_material_id'];
    $rawMaterialName = $_POST['name'];
    $rawMaterialDescription = $_POST['description'];

    // Check if an image is uploaded
    if(isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        // Retrieve image data
        $rawMaterialImage = file_get_contents($_FILES['image']['tmp_name']);

        // Prepare image data for insertion
        $rawMaterialImage = $conn->real_escape_string($rawMaterialImage);

        // Update raw material with image
        $sql = "UPDATE raw_materials SET name = '$rawMaterialName', description = '$rawMaterialDescription', image = '$rawMaterialImage' WHERE raw_material_id = $rawMaterialId";
    } else {
        // Update raw material without image
        $sql = "UPDATE raw_materials SET name = '$rawMaterialName', description = '$rawMaterialDescription' WHERE raw_material_id = $rawMaterialId";
    }

    // Execute the SQL query
    if ($conn->query($sql) === TRUE) {
        echo "Raw material updated successfully";
    } else {
        echo "Error updating raw material: " . $conn->error;
    }

    // Close connection
    $conn->close();

    // Redirect back to raw_materials.php
    header("Location: ../raw_materials.php");
    exit();
} else {
    // If form is not submitted, redirect back to raw_materials.php
    header("Location: ../raw_materials.php");
    exit();
}
?>
