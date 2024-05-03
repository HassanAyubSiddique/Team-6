<?php
include 'db_connection.php';

class RawMaterialBatchManager {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function addBatch($rawMaterialId, $bbd, $quantity) {
        // Insert batch into raw_material_batches table
        $sql = "INSERT INTO raw_material_batches (raw_material_id, bbd, quantity) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iss", $rawMaterialId, $bbd, $quantity);

        if ($stmt->execute()) {
            // Get the last inserted batch ID
            $lastBatchId = $stmt->insert_id;
            $stmt->close(); // Close statement

            // Generate SKU with batch ID
            $skuCode = $this->generateSKU($rawMaterialId, $bbd, $lastBatchId);

            // Update SKU code in the database
            $sqlUpdateSKU = "UPDATE raw_material_batches SET sku_code = ? WHERE batch_id = ?";
            $stmtUpdateSKU = $this->conn->prepare($sqlUpdateSKU);
            $stmtUpdateSKU->bind_param("si", $skuCode, $lastBatchId);

            if ($stmtUpdateSKU->execute()) {
                $stmtUpdateSKU->close(); // Close statement

                // Update total quantity for the raw material
                $this->updateTotalQuantity($rawMaterialId, $quantity);

                // Batch added successfully
                return "Batch added successfully";
            } else {
                return "Error updating SKU code: " . $this->conn->error;
            }
        } else {
            return "Error adding batch: " . $stmt->error;
        }
    }

    private function generateSKU($rawMaterialId, $bbd, $batchId) {
        return "RM$rawMaterialId-$bbd-B$batchId";
    }

    private function updateTotalQuantity($rawMaterialId, $quantity) {
        // Fetch current total_quantity for the raw material
        $sqlFetchTotalQuantity = "SELECT total_quantity FROM raw_materials WHERE raw_material_id = ?";
        $stmtFetchTotalQuantity = $this->conn->prepare($sqlFetchTotalQuantity);
        $stmtFetchTotalQuantity->bind_param("i", $rawMaterialId);
        $stmtFetchTotalQuantity->execute();
        $resultFetchTotalQuantity = $stmtFetchTotalQuantity->get_result();

        if ($resultFetchTotalQuantity->num_rows > 0) {
            $rowFetchTotalQuantity = $resultFetchTotalQuantity->fetch_assoc();
            $currentTotalQuantity = $rowFetchTotalQuantity['total_quantity'];
            $newTotalQuantity = $currentTotalQuantity + $quantity;

            // Update raw_materials table with new total_quantity
            $sqlUpdateTotalQuantity = "UPDATE raw_materials SET total_quantity = ? WHERE raw_material_id = ?";
            $stmtUpdateTotalQuantity = $this->conn->prepare($sqlUpdateTotalQuantity);
            $stmtUpdateTotalQuantity->bind_param("ii", $newTotalQuantity, $rawMaterialId);
            $stmtUpdateTotalQuantity->execute();
            $stmtUpdateTotalQuantity->close(); // Close statement
        } else {
            echo "Error fetching current total quantity for the raw material";
        }

        $stmtFetchTotalQuantity->close(); // Close statement
    }
}

function handleFormSubmission($conn) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $rawMaterialBatchManager = new RawMaterialBatchManager($conn);

        // Validate and sanitize inputs
        $rawMaterialId = $_POST['raw_material_id'];
        $bbd = $_POST['bbd'];
        $quantity = $_POST['quantity'];

        // Add batch and handle result
        $message = $rawMaterialBatchManager->addBatch($rawMaterialId, $bbd, $quantity);
        echo "<script>alert('$message');</script>";

        // Redirect to raw materials page
        echo "<script>window.location.href = '../ViewRawMaterial.php';</script>";
    } else {
        echo "Invalid request";
    }
}

// Handle form submission
handleFormSubmission($conn);

// Close connection
$conn->close();
?>
