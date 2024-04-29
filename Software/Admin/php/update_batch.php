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
        // Insert batch into product_batches table
        $sql = "INSERT INTO product_batches (product_id, bbd, quantity) VALUES ('$product_id', '$bbd', '$quantity')";
        if ($conn->query($sql) === TRUE) {
            // Get the last inserted batch ID
            $last_batch_id = $conn->insert_id;

            // Generate SKU with batch ID
            $sku_code = "P$product_id-$bbd-B$last_batch_id";

            // Update SKU code in the database
            $sql_update_sku = "UPDATE product_batches SET sku_code = '$sku_code' WHERE batch_id = '$last_batch_id'";
            if ($conn->query($sql_update_sku) === TRUE) {
                // Fetch current total_quantity for the product
                $sql_fetch_total_quantity = "SELECT total_quantity FROM products WHERE product_id = '$product_id'";
                $result_fetch_total_quantity = $conn->query($sql_fetch_total_quantity);

                if ($result_fetch_total_quantity->num_rows > 0) {
                    $row_fetch_total_quantity = $result_fetch_total_quantity->fetch_assoc();
                    $current_total_quantity = $row_fetch_total_quantity['total_quantity'];
                    // Calculate new total_quantity by adding the new quantity
                    $new_total_quantity = $current_total_quantity + $quantity;
                    // Update products table with new total_quantity
                    $sql_update_total_quantity = "UPDATE products SET total_quantity = '$new_total_quantity' WHERE product_id = '$product_id'";
                    if ($conn->query($sql_update_total_quantity) === TRUE) {
                        // Batch added successfully and product table updated
                        echo "<script>alert('Batch added successfully');</script>";
                        // Redirect to products page
                        echo "<script>window.location.href = '../ViewProduct.php';</script>";
                        exit();
                    } else {
                        echo "Error updating product total quantity: " . $conn->error;
                    }
                } else {
                    echo "Error fetching current total quantity for the product";
                }
            } else {
                echo "Error updating SKU code: " . $conn->error;
            }
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
