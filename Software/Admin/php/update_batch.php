<?php
// Include database connection
include 'db_connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $product_id = $_POST['product_id'];
    $bbd = $_POST['bbd'];
    $quantity = $_POST['quantity'];

    // Validate inputs (you can add more validation as needed)
    if (empty($product_id) || empty($bbd) || empty($quantity)) {
        echo "Please fill in all fields";
    } else {
        // Generate SKU
        $sku_code = "SKU-$product_id-$bbd";

        // Insert batch into product_batches table
        $sql = "INSERT INTO product_batches (product_id, bbd, quantity, sku_code) VALUES ('$product_id', '$bbd', '$quantity', '$sku_code')";
        if ($conn->query($sql) === TRUE) {
            // Batch added successfully, redirect to products page
            echo "<script>alert('Batch added successfully');</script>";
            echo "<script>window.location.href = '../products.php';</script>";
            exit();
        } else {
            echo "Error adding batch: " . $conn->error;
        }
    }
} else {
    echo "Invalid request";
}

// Close connection
$conn->close();
?>
