<?php
// Include database connection
include 'db_connection.php';

// Check if product_id is set
if(isset($_GET['product_id'])) {
    // Retrieve product_id
    $productId = $_GET['product_id'];

    // Delete product batches related to the product
    $deleteBatchesSql = "DELETE FROM product_batches WHERE product_id = $productId";
    if ($conn->query($deleteBatchesSql) === TRUE) {
        // Now delete the product
        $deleteProductSql = "DELETE FROM products WHERE product_id = $productId";
        if ($conn->query($deleteProductSql) === TRUE) {
            echo "Product and related batches deleted successfully";
        } else {
            echo "Error deleting product: " . $conn->error;
        }
    } else {
        echo "Error deleting product batches: " . $conn->error;
    }

    // Close connection
    $conn->close();
} else {
    echo "Product ID not specified";
}

// Redirect back to products.php
header("Location: ../products.php");
exit();
?>
