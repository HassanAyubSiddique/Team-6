<?php
// Include database connection
include 'db_connection.php';

class ProductUpdater {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function updateProduct($productId, $productName, $productDescription, $productImage = null) {
        $sql = "";
        if ($productImage !== null) {
            $productImageBlob = $this->conn->real_escape_string(file_get_contents($productImage['tmp_name']));
            $sql = "UPDATE products SET name = '$productName', description = '$productDescription', main_image = '$productImageBlob' WHERE product_id = $productId";
        } else {
            $sql = "UPDATE products SET name = '$productName', description = '$productDescription' WHERE product_id = $productId";
        }

        return $this->conn->query($sql);
    }
}

function handleFormSubmission($conn) {
    // Check if form is submitted
    if (isset($_POST['submit'])) {
        // Retrieve form data
        $productId = $_POST['product_id'];
        $productName = $_POST['name'];
        $productDescription = $_POST['description'];

        // Check if an image is uploaded
        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            // Initialize ProductUpdater
            $productUpdater = new ProductUpdater($conn);

            // Update product with image
            if ($productUpdater->updateProduct($productId, $productName, $productDescription, $_FILES['image'])) {
                echo "Product updated successfully";
            } else {
                echo "Error updating product: " . $conn->error;
            }
        } else {
            // Update product without image
            $sql = "UPDATE products SET name = '$productName', description = '$productDescription' WHERE product_id = $productId";
            if ($conn->query($sql) === TRUE) {
                echo "Product updated successfully";
            } else {
                echo "Error updating product: " . $conn->error;
            }
        }

        // Close connection
        $conn->close();

        // Redirect back to ViewProduct.php
        header("Location: ../ViewProduct.php");
        exit();
    } else {
        // If form is not submitted, redirect back to ViewProduct.php
        header("Location: ../ViewProduct.php");
        exit();
    }
}

// Handle form submission
handleFormSubmission($conn);
?>
