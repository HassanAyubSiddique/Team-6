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

// Function to handle form submission
function handleFormSubmission() {
    global $conn;

    // Check if raw_material_id is set
    if (isset($_GET['raw_material_id'])) {
        // Retrieve raw_material_id
        $rawMaterialId = $_GET['raw_material_id'];

        // Create an instance of RawMaterialUnlister
        $rawMaterialUnlister = new RawMaterialUnlister($conn);

        // Unlist the raw material and get the message
        $message = $rawMaterialUnlister->unlistRawMaterial($rawMaterialId);
    } else {
        $message = "Raw Material ID not specified";
    }

    // Close connection
    $conn->close();

    // Redirect back to ViewRawMaterial.php
    redirectToViewRawMaterial($message);
}

// Function to redirect to ViewRawMaterial.php
function redirectToViewRawMaterial($message) {
    header("Location: ../ViewRawMaterial.php?message=" . urlencode($message));
    exit();
}

// Include database connection
include 'db_connection.php';

// Call the function to handle form submission
handleFormSubmission();
?>
