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

        // Check if file is an image
        $fileName = $_FILES['image']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['tif', 'tiff', 'bmp', 'jpeg', 'jpg', 'gif', 'png', 'eps', 'raw'];
        if (!in_array($fileExtension, $allowedExtensions)) {
            echo "<script>alert('Only TIFF, BMP, JPEG, GIF, PNG, EPS, and RAW image files are allowed.');</script>";
            exit(); // Stop execution if invalid image format
        }

        // Check file size
        $fileSize = $_FILES['image']['size'];
        $maxSize = 16777215; // Maximum size for MEDIUMBLOB
        if ($fileSize > $maxSize) {
            echo "<script>alert('Image size exceeds maximum allowed size.');</script>";
            exit(); // Stop execution if image size exceeds maximum
        }

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

    // Redirect back to ViewRawMaterial.php
    header("Location: ../ViewRawMaterial.php");
    exit();
} else {
    // If form is not submitted, redirect back to ViewRawMaterial.php
    header("Location: ../ViewRawMaterial.php");
    exit();
}
?>
