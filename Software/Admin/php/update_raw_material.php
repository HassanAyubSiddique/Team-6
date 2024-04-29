<?php
// Include database connection
include 'db_connection.php';

class RawMaterialUpdater {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function updateRawMaterial($rawMaterialId, $rawMaterialName, $rawMaterialDescription, $rawMaterialImage = null) {
        $sql = "";
        if ($rawMaterialImage !== null) {
            $rawMaterialImageBlob = $this->conn->real_escape_string(file_get_contents($rawMaterialImage['tmp_name']));
            $sql = "UPDATE raw_materials SET name = '$rawMaterialName', description = '$rawMaterialDescription', image = '$rawMaterialImageBlob' WHERE raw_material_id = $rawMaterialId";
        } else {
            $sql = "UPDATE raw_materials SET name = '$rawMaterialName', description = '$rawMaterialDescription' WHERE raw_material_id = $rawMaterialId";
        }

        return $this->conn->query($sql);
    }
}

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Retrieve form data
    $rawMaterialId = $_POST['raw_material_id'];
    $rawMaterialName = $_POST['name'];
    $rawMaterialDescription = $_POST['description'];

    // Check if an image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        // Initialize RawMaterialUpdater
        $rawMaterialUpdater = new RawMaterialUpdater($conn);

        // Update raw material with image
        if ($rawMaterialUpdater->updateRawMaterial($rawMaterialId, $rawMaterialName, $rawMaterialDescription, $_FILES['image'])) {
            echo "Raw material updated successfully";
        } else {
            echo "Error updating raw material: " . $conn->error;
        }
    } else {
        // Update raw material without image
        $sql = "UPDATE raw_materials SET name = '$rawMaterialName', description = '$rawMaterialDescription' WHERE raw_material_id = $rawMaterialId";
        if ($conn->query($sql) === TRUE) {
            echo "Raw material updated successfully";
        } else {
            echo "Error updating raw material: " . $conn->error;
        }
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
