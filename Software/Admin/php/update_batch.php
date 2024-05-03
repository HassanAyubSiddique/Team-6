<?php
// Include database connection
include 'db_connection.php';

class ProductBatchManager {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Add a new batch of products
    public function addBatch($productId, $bbd, $quantity) {
        // Prepare the SQL statement to insert a new batch
        $sql = "INSERT INTO product_batches (product_id, bbd, quantity) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iss", $productId, $bbd, $quantity);

        // Execute the SQL statement
        if ($stmt->execute()) {
            // Get the ID of the last inserted batch
            $lastBatchId = $stmt->insert_id;
            $stmt->close(); // Close the statement

            // Generate SKU with batch ID
            $skuCode = $this->generateSKU($productId, $bbd, $lastBatchId);

            // Update the SKU code in the database
            $sqlUpdateSKU = "UPDATE product_batches SET sku_code = ? WHERE batch_id = ?";
            $stmtUpdateSKU = $this->conn->prepare($sqlUpdateSKU);
            $stmtUpdateSKU->bind_param("si", $skuCode, $lastBatchId);

            // Execute the update statement for SKU code
            if ($stmtUpdateSKU->execute()) {
                $stmtUpdateSKU->close(); // Close the statement

                // Update the total quantity for the product
                $this->updateTotalQuantity($productId, $quantity);

                // Return success message
                return "Batch added successfully";
            } else {
                return "Error updating SKU code: " . $this->conn->error;
            }
        } else {
            return "Error adding batch: " . $stmt->error;
        }
    }

    // Generate SKU code for the batch
    private function generateSKU($productId, $bbd, $batchId) {
        return "P$productId-$bbd-B$batchId";
    }

    // Update the total quantity of the product
    private function updateTotalQuantity($productId, $quantity) {
        // Prepare SQL statement to fetch the current total quantity for the product
        $sqlFetchTotalQuantity = "SELECT total_quantity FROM products WHERE product_id = ?";
        $stmtFetchTotalQuantity = $this->conn->prepare($sqlFetchTotalQuantity);
        $stmtFetchTotalQuantity->bind_param("i", $productId);
        $stmtFetchTotalQuantity->execute();

        // Get the result of the query
        $resultFetchTotalQuantity = $stmtFetchTotalQuantity->get_result();

        // If there is a result
        if ($resultFetchTotalQuantity->num_rows > 0) {
            // Fetch the row
            $rowFetchTotalQuantity = $resultFetchTotalQuantity->fetch_assoc();
            $currentTotalQuantity = $rowFetchTotalQuantity['total_quantity'];
            $newTotalQuantity = $currentTotalQuantity + $quantity;

            // Prepare SQL statement to update the total quantity for the product
            $sqlUpdateTotalQuantity = "UPDATE products SET total_quantity = ? WHERE product_id = ?";
            $stmtUpdateTotalQuantity = $this->conn->prepare($sqlUpdateTotalQuantity);
            $stmtUpdateTotalQuantity->bind_param("ii", $newTotalQuantity, $productId);
            $stmtUpdateTotalQuantity->execute();
            $stmtUpdateTotalQuantity->close(); // Close the statement
        } else {
            echo "Error fetching current total quantity for the product";
        }

        // Close the statement
        $stmtFetchTotalQuantity->close();
    }
}

// Function to handle form submission
function handleFormSubmission() {
    global $conn;

    // Check if the form is submitted via POST method
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Create an instance of ProductBatchManager
        $productBatchManager = new ProductBatchManager($conn);

        // Validate and sanitize input data
        $productId = $_POST['product_id'];
        $bbd = $_POST['bbd'];
        $quantity = $_POST['quantity'];

        // Add the batch and handle the result
        $message = $productBatchManager->addBatch($productId, $bbd, $quantity);
        echo "<script>alert('$message');</script>";

        // Redirect to the products page
        echo "<script>window.location.href = '../ViewProduct.php';</script>";
    } else {
        // If the request method is not POST, display an error message
        echo "Invalid request";
    }

    // Close the database connection
    $conn->close();
}

// Call the function to handle form submission
handleFormSubmission();
?>
