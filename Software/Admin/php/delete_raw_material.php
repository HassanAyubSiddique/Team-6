<?php
// Include database connection
include 'db_connection.php';

// Check if raw_material_id is set
if(isset($_GET['raw_material_id'])) {
    // Retrieve raw_material_id
    $rawMaterialId = $_GET['raw_material_id'];

    // Delete raw material
    $deleteRawMaterialSql = "DELETE FROM raw_materials WHERE raw_material_id = $rawMaterialId";

    if ($conn->query($deleteRawMaterialSql) === TRUE) {
        echo "Raw material deleted successfully";
    } else {
        echo "Error deleting raw material: " . $conn->error;
    }

    // Close connection
    $conn->close();
} else {
    echo "Raw Material ID not specified";
}

// Redirect back to raw_materials.php or any desired page
header("Location: ../raw_materials.php");
exit();
?>
