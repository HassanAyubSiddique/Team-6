<?php
class ProductUnlister {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function unlistProduct($productId) {
        if (!empty($productId)) {
            // Sanitize input
            $productId = $this->conn->real_escape_string($productId);

            // Update product status to "Unlisted"
            $sql = "UPDATE products SET status = 'Unlisted' WHERE product_id = $productId";

            if ($this->conn->query($sql) === TRUE) {
                return "Product unlisted successfully";
            } else {
                return "Error unlisting product: " . $this->conn->error;
            }
        } else {
            return "Product ID not specified";
        }
    }
}

// Function to handle form submission
function handleFormSubmission() {
    global $conn;

    // Check if product_id is set
    if (isset($_GET['product_id'])) {
        // Retrieve product_id
        $productId = $_GET['product_id'];

        // Create an instance of ProductUnlister
        $productUnlister = new ProductUnlister($conn);

        // Unlist the product and get the message
        $message = $productUnlister->unlistProduct($productId);
    } else {
        $message = "Product ID not specified";
    }

    // Close connection
    $conn->close();

    // Redirect back to ViewProduct.php
    redirectToViewProduct($message);
}

// Function to redirect to ViewProduct.php
function redirectToViewProduct($message) {
    header("Location: ../ViewProduct.php?message=" . urlencode($message));
    exit();
}

// Include database connection
include 'db_connection.php';

// Call the function to handle form submission
handleFormSubmission();
?>
