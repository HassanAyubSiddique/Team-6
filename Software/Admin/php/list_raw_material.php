<?php
// Include database connection
include 'db_connection.php';

class RawMaterialLister {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function listRawMaterial($rawMaterialId) {
        // Update raw material status to "Listed"
        $sql = "UPDATE raw_materials SET status = 'Listed' WHERE raw_material_id = $rawMaterialId";

        if ($this->connection->query($sql) === TRUE) {
            return "Raw material listed successfully";
        } else {
            return "Error listing raw material: " . $this->connection->error;
        }
    }
}

// Check if raw_material_id is set
if(isset($_GET['raw_material_id'])) {
    // Retrieve raw_material_id
    $rawMaterialId = $_GET['raw_material_id'];

    // Create an instance of RawMaterialLister class
    $rawMaterialLister = new RawMaterialLister($conn);

    // Call listRawMaterial method to list the raw material
    echo $rawMaterialLister->listRawMaterial($rawMaterialId);
} else {
    echo "Raw Material ID not specified";
}

// Close connection
$conn->close();

// Redirect back to ViewRawMaterial.php or any desired page
header("Location: ../ViewRawMaterial.php");
exit();
?>
