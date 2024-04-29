<?php
// Include database connection
include 'db_connection.php';

/**
 * Class RawMaterialHandler for handling raw material operations.
 */
class RawMaterialHandler {
    private $conn;

    /**
     * Constructor to initialize the RawMaterialHandler with the database connection.
     * @param mysqli $conn The database connection object.
     */
    public function __construct($conn) {
        $this->conn = $conn;
    }

    /**
     * Handles the submission of the raw material form.
     */
    public function handleFormSubmission() {
        if (isset($_POST['submit'])) {
            // Retrieve form data
            $raw_material_name = $_POST['raw_material_name'];
            $raw_material_description = $_POST['raw_material_description'];
            $rawMaterialImage = file_get_contents($_FILES['raw_material_image']['tmp_name']);

            // Add raw material
            if ($this->addRawMaterial($raw_material_name, $raw_material_description, $rawMaterialImage)) {
                // If execution is successful, redirect to AddRawMaterial.php with success message
                echo "<script>alert('Raw material added successfully'); window.location.href = '../AddRawMaterial.php';</script>";
            } else {
                // If execution fails, redirect to AddRawMaterial.php with error message
                echo "<script>alert('Error adding raw material'); window.location.href = '../AddRawMaterial.php';</script>";
            }

            // Close connection
            $this->conn->close();
        } else {
            // If form is not submitted, redirect to AddRawMaterial.php
            header("Location: ../AddRawMaterial.php");
            exit(); // Stop further execution
        }
    }

    /**
     * Adds a new raw material to the database.
     * @param string $name The name of the raw material.
     * @param string $description The description of the raw material.
     * @param string $imageData The image data of the raw material.
     * @return bool True if the addition is successful, false otherwise.
     */
    private function addRawMaterial($name, $description, $imageData) {
        // Prepare the SQL statement with placeholders for the data
        $sql = "INSERT INTO raw_materials (name, description, image) VALUES (?, ?, ?)";

        // Create a prepared statement
        $stmt = $this->conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("sss", $name, $description, $imageData);

        // Execute the statement
        $success = $stmt->execute();

        // Close the prepared statement
        $stmt->close();

        return $success;
    }
}

// Create RawMaterialHandler object
$rawMaterialHandler = new RawMaterialHandler($conn);

// Handle form submission
$rawMaterialHandler->handleFormSubmission();
?>
