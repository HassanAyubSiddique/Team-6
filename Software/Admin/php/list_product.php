<?php
// Include database connection
include 'db_connection.php';

// Check if product_id is set
if(isset($_GET['product_id'])) {
    // Retrieve product_id
    $productId = $_GET['product_id'];

    // Update product status to "Listed"
    $sql = "UPDATE products SET status = 'Listed' WHERE product_id = $productId";

    if ($conn->query($sql) === TRUE) {
        echo "Product listed successfully";
    } else {
        echo "Error listing product: " . $conn->error;
    }

    // Close connection
    $conn->close();
} else {
    echo "Product ID not specified";
}

// Redirect back to ViewProduct.php
header("Location: ../ViewProduct.php");
exit();
?>
