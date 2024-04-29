<?php
// Include database connection
include 'db_connection.php';

/**
 * Class ProductManager handles product-related database operations.
 */
class ProductManager {
    private $conn;

    /**
     * Constructor to initialize the ProductManager with a database connection.
     * @param mysqli $conn The database connection object.
     */
    public function __construct($conn) {
        $this->conn = $conn;
    }

    /**
     * Deletes a product and its related batches from the database.
     * @param int $product_id The ID of the product to delete.
     * @return string|null Error message if deletion fails, null otherwise.
     */
    public function deleteProductAndBatches($product_id) {
        // Delete product batches related to the product
        $deleteBatchesSql = "DELETE FROM product_batches WHERE product_id = $product_id";
        if ($this->conn->query($deleteBatchesSql) === TRUE) {
            // Now delete the product
            $deleteProductSql = "DELETE FROM products WHERE product_id = $product_id";
            if ($this->conn->query($deleteProductSql) === TRUE) {
                return null; // Deletion successful, no error
            } else {
                return "Error deleting product: " . $this->conn->error;
            }
        } else {
            return "Error deleting product batches: " . $this->conn->error;
        }
    }

    /**
     * Deletes a product and its related batches based on the product ID from the URL.
     * Displays error message if product ID is not provided.
     */
    public function deleteProductAndBatchesFromURL() {
        // Check if product_id is set
        if(isset($_GET['product_id'])) {
            // Retrieve product_id
            $product_id = $_GET['product_id'];

            // Delete product and related batches
            $error_message = $this->deleteProductAndBatches($product_id);

            // Check if there was an error
            if ($error_message === null) {
                echo "Product and related batches deleted successfully";
            } else {
                echo $error_message;
            }
        } else {
            echo "Product ID not specified";
        }
    }
}

// Create ProductManager object
$productManager = new ProductManager($conn);

// Delete product and related batches based on the product ID from the URL
$productManager->deleteProductAndBatchesFromURL();

// Close connection
$conn->close();

// Redirect back to ViewProduct.php
header("Location: ../ViewProduct.php");
exit();
?>
