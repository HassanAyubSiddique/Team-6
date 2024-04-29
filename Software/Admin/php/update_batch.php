<?php
// Include database connection
include 'db_connection.php';

class ProductBatchManager {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function addBatch($productId, $bbd, $quantity) {
        // Insert batch into product_batches table
        $sql = "INSERT INTO product_batches (product_id, bbd, quantity) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iss", $productId, $bbd, $quantity);

        if ($stmt->execute()) {
            // Get the last inserted batch ID
            $lastBatchId = $stmt->insert_id;
            $stmt->close(); // Close statement

            // Generate SKU with batch ID
            $skuCode = $this->generateSKU($productId, $bbd, $lastBatchId);

            // Update SKU code in the database
            $sqlUpdateSKU = "UPDATE product_batches SET sku_code = ? WHERE batch_id = ?";
            $stmtUpdateSKU = $this->conn->prepare($sqlUpdateSKU);
            $stmtUpdateSKU->bind_param("si", $skuCode, $lastBatchId);

            if ($stmtUpdateSKU->execute()) {
                $stmtUpdateSKU->close(); // Close statement

                // Update total quantity for the product
                $this->updateTotalQuantity($productId, $quantity);

                // Batch added successfully
                return "Batch added successfully";
            } else {
                return "Error updating SKU code: " . $this->conn->error;
            }
        } else {
            return "Error adding batch: " . $stmt->error;
        }
    }

    private function generateSKU($productId, $bbd, $batchId) {
        return "P$productId-$bbd-B$batchId";
    }

    private function updateTotalQuantity($productId, $quantity) {
        // Fetch current total_quantity for the product
        $sqlFetchTotalQuantity = "SELECT total_quantity FROM products WHERE product_id = ?";
        $stmtFetchTotalQuantity = $this->conn->prepare($sqlFetchTotalQuantity);
        $stmtFetchTotalQuantity->bind_param("i", $productId);
        $stmtFetchTotalQuantity->execute();
        $resultFetchTotalQuantity = $stmtFetchTotalQuantity->get_result();

        if ($resultFetchTotalQuantity->num_rows > 0) {
            $rowFetchTotalQuantity = $resultFetchTotalQuantity->fetch_assoc();
            $currentTotalQuantity = $rowFetchTotalQuantity['total_quantity'];
            $newTotalQuantity = $currentTotalQuantity + $quantity;

            // Update products table with new total_quantity
            $sqlUpdateTotalQuantity = "UPDATE products SET total_quantity = ? WHERE product_id = ?";
            $stmtUpdateTotalQuantity = $this->conn->prepare($sqlUpdateTotalQuantity);
            $stmtUpdateTotalQuantity->bind_param("ii", $newTotalQuantity, $productId);
            $stmtUpdateTotalQuantity->execute();
            $stmtUpdateTotalQuantity->close(); // Close statement
        } else {
            echo "Error fetching current total quantity for the product";
        }

        $stmtFetchTotalQuantity->close(); // Close statement
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productBatchManager = new ProductBatchManager($conn);

    // Validate and sanitize inputs
    $productId = $_POST['product_id'];
    $bbd = $_POST['bbd'];
    $quantity = $_POST['quantity'];

    // Add batch and handle result
    $message = $productBatchManager->addBatch($productId, $bbd, $quantity);
    echo "<script>alert('$message');</script>";

    // Redirect to products page
    echo "<script>window.location.href = '../ViewProduct.php';</script>";
} else {
    echo "Invalid request";
}

// Close connection
$conn->close();
?>
