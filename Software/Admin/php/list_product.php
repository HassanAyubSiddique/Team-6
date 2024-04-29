<?php
// Include database connection
include 'db_connection.php';

class ProductLister {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function listProduct($productId) {
        // Update product status to "Listed"
        $sql = "UPDATE products SET status = 'Listed' WHERE product_id = $productId";

        if ($this->connection->query($sql) === TRUE) {
            return "Product listed successfully";
        } else {
            return "Error listing product: " . $this->connection->error;
        }
    }
}

// Check if product_id is set
if(isset($_GET['product_id'])) {
    // Retrieve product_id
    $productId = $_GET['product_id'];

    // Create an instance of ProductLister class
    $productLister = new ProductLister($conn);

    // Call listProduct method to list the product
    echo $productLister->listProduct($productId);
} else {
    echo "Product ID not specified";
}

// Close connection
$conn->close();

// Redirect back to ViewProduct.php
header("Location: ../ViewProduct.php");
exit();
?>
