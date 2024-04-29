<?php
// Include database connection
include 'db_connection.php';

/**
 * Class RawMaterialManager handles raw material-related database operations.
 */
class RawMaterialManager {
    private $conn;

    /**
     * Constructor to initialize the RawMaterialManager with a database connection.
     * @param mysqli $conn The database connection object.
     */
    public function __construct($conn) {
        $this->conn = $conn;
    }

    /**
     * Deletes a raw material from the database.
     * @param int $raw_material_id The ID of the raw material to delete.
     * @return string|null Error message if deletion fails, null otherwise.
     */
    public function deleteRawMaterial($raw_material_id) {
        // Delete raw material
        $deleteRawMaterialSql = "DELETE FROM raw_materials WHERE raw_material_id = $raw_material_id";

        if ($this->conn->query($deleteRawMaterialSql) === TRUE) {
            return null; // Deletion successful, no error
        } else {
            return "Error deleting raw material: " . $this->conn->error;
        }
    }

    /**
     * Deletes a raw material based on the raw material ID from the URL.
     * Displays error message if raw material ID is not provided.
     */
    public function deleteRawMaterialFromURL() {
        // Check if raw_material_id is set
        if(isset($_GET['raw_material_id'])) {
            // Retrieve raw_material_id
            $raw_material_id = $_GET['raw_material_id'];

            // Delete raw material
            $error_message = $this->deleteRawMaterial($raw_material_id);

            // Check if there was an error
            if ($error_message === null) {
                echo "Raw material deleted successfully";
            } else {
                echo $error_message;
            }
        } else {
            echo "Raw Material ID not specified";
        }
    }
}

// Create RawMaterialManager object
$rawMaterialManager = new RawMaterialManager($conn);

// Delete raw material based on the raw material ID from the URL
$rawMaterialManager->deleteRawMaterialFromURL();

// Close connection
$conn->close();

// Redirect back to ViewRawMaterial.php or any desired page
header("Location: ../ViewRawMaterial.php");
exit();
?>
