<?php
class RawMaterialUnlister {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function unlistRawMaterial($rawMaterialId) {
        if (!empty($rawMaterialId)) {
            // Sanitize input
            $rawMaterialId = $this->conn->real_escape_string($rawMaterialId);

            // Update raw material status to "Unlisted"
            $sql = "UPDATE raw_materials SET status = 'Unlisted' WHERE raw_material_id = $rawMaterialId";

            if ($this->conn->query($sql) === TRUE) {
                return "Raw material unlisted successfully";
            } else {
                return "Error unlisting raw material: " . $this->conn->error;
            }
        } else {
            return "Raw Material ID not specified";
        }
    }
}

function redirectToViewRawMaterial($message) {
    header("Location: ../ViewRawMaterial.php?message=" . urlencode($message));
    exit();
}

// Include database connection
include 'db_connection.php';

// Check if raw_material_id is set
if (isset($_GET['raw_material_id'])) {
    // Retrieve raw_material_id
    $rawMaterialId = $_GET['raw_material_id'];

    $rawMaterialUnlister = new RawMaterialUnlister($conn);
    $message = $rawMaterialUnlister->unlistRawMaterial($rawMaterialId);
} else {
    $message = "Raw Material ID not specified";
}

// Close connection
$conn->close();

// Redirect back to ViewRawMaterial.php
redirectToViewRawMaterial($message);
?>
