<?php
// Include database connection
include 'db_connection.php';

// Check if product_id is provided in the URL
if(isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Fetch product information
    $sql_product = "SELECT * FROM products WHERE product_id = $product_id";
    $result_product = $conn->query($sql_product);

    if ($result_product->num_rows > 0) {
        $row_product = $result_product->fetch_assoc();
        $product_name = $row_product['name'];
        $product_total_quantity = $row_product['total_quantity'];
        ?>
        <h2>Use Product: <?php echo $product_name; ?></h2>
        <p>Total Quantity Available: <?php echo $product_total_quantity; ?></p>
        <form action="" method="post">
            <label for="quantity">Select Quantity:</label>
            <input type="number" id="quantity" name="quantity" min="1" max="<?php echo $product_total_quantity; ?>" required>
            <?php if(isset($_POST['use']) && $_POST['quantity'] > $product_total_quantity): ?>
                <span style="color: red;">Requested quantity exceeds available stock.</span>
            <?php endif; ?>
            <button type="submit" name="use">Use</button>
            <button onclick="window.location.href = '../ViewProduct.php';">Close</button>
        </form>
        <?php
        if(isset($_POST['use']) && $_POST['quantity'] <= $product_total_quantity) {
            $use_quantity = $_POST['quantity'];

            // Fetch batches where the product is used and their corresponding quantities
            $sql_batches = "SELECT * FROM product_batches WHERE product_id = $product_id AND quantity > 0 ORDER BY bbd ASC";
            $result_batches = $conn->query($sql_batches);

            if ($result_batches->num_rows > 0) {
                ?>
                <h3>Used Batches:</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Batch ID</th>
                            <th>BB Date</th>
                            <th>Quantity Used</th>
                            <th>SKU</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while($row_batch = $result_batches->fetch_assoc()) {
                            $batch_id = $row_batch['batch_id'];
                            $bbd = $row_batch['bbd'];
                            $batch_quantity = $row_batch['quantity'];
                            $sku_code = $row_batch['sku_code'];

                            // Determine the quantity to use from this batch
                            $quantity_to_use = min($use_quantity, $batch_quantity);
                            $use_quantity -= $quantity_to_use;

                            // Update the batch quantity and delete batch if quantity becomes zero
                            $new_batch_quantity = $batch_quantity - $quantity_to_use;
                            if ($new_batch_quantity <= 0) {
                                $sql_delete_batch = "DELETE FROM product_batches WHERE batch_id = $batch_id";
                                if ($conn->query($sql_delete_batch) !== TRUE) {
                                    echo "Error deleting batch: " . $conn->error;
                                }
                            } else {
                                $sql_update_batch = "UPDATE product_batches SET quantity = $new_batch_quantity WHERE batch_id = $batch_id";
                                if ($conn->query($sql_update_batch) !== TRUE) {
                                    echo "Error updating batch quantity: " . $conn->error;
                                }
                            }
                            ?>
                            <tr>
                                <td><?php echo $batch_id; ?></td>
                                <td><?php echo $bbd; ?></td>
                                <td><?php echo $quantity_to_use; ?></td>
                                <td><?php echo $sku_code; ?></td>
                            </tr>
                            <?php

                            if($use_quantity <= 0) {
                                break; // All requested quantity has been allocated
                            }
                        }

                        // If some quantity is still left unused, display a message
                        if($use_quantity > 0) {
                            ?>
                            <tr>
                                <td colspan="3">Requested quantity exceeds available stock.</td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                <?php
                // Update total quantity in products table
                $new_product_quantity = $product_total_quantity - ($_POST['quantity'] - $use_quantity);
                $sql_update_product = "UPDATE products SET total_quantity = $new_product_quantity WHERE product_id = $product_id";
                if ($conn->query($sql_update_product) !== TRUE) {
                    echo "Error updating product total quantity: " . $conn->error;
                }
            } else {
                echo "<p>No available batches found.</p>";
            }
        }
    } else {
        echo "<p>Product not found.</p>";
    }
} else {
    echo "<p>No product ID provided.</p>";
}

// Close connection
$conn->close();
?>
