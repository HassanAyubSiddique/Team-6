<?php
// Include database connection
include 'db_connection.php';

// Check if raw_material_id is set
if(isset($_GET['raw_material_id'])) {
    // Retrieve raw_material_id
    $rawMaterialId = $_GET['raw_material_id'];

    // Update raw material status to "Unlisted"
    $sql = "UPDATE raw_materials SET status = 'Unlisted' WHERE raw_material_id = $rawMaterialId";

    if ($conn->query($sql) === TRUE) {
        echo "Raw material unlisted successfully";
    } else {
        echo "Error unlisting raw material: " . $conn->error;
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
