<?php
// Include database connection
include 'db_connection.php';

class ProductUser {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function useProduct($productId, $requestedQuantity) {
        // Fetch product information
        $sqlProduct = "SELECT * FROM products WHERE product_id = $productId";
        $resultProduct = $this->conn->query($sqlProduct);

        if ($resultProduct->num_rows > 0) {
            $rowProduct = $resultProduct->fetch_assoc();
            $productName = $rowProduct['name'];
            $productTotalQuantity = $rowProduct['total_quantity'];
            ?>
            <h2>Use Product: <?php echo $productName; ?></h2>
            <p>Total Quantity Available: <?php echo $productTotalQuantity; ?></p>
            <form action="" method="post">
                <label for="quantity">Select Quantity:</label>
                <input type="number" id="quantity" name="quantity" min="1" max="<?php echo $productTotalQuantity; ?>" required>
                <?php if(isset($_POST['use']) && $_POST['quantity'] > $productTotalQuantity): ?>
                    <span style="color: red;">Requested quantity exceeds available stock.</span>
                <?php endif; ?>
                <button type="submit" name="use">Use</button>
                <button onclick="window.location.href = '../ViewProduct.php';">Close</button>
            </form>
            <?php
            if(isset($_POST['use']) && $_POST['quantity'] <= $productTotalQuantity) {
                $useQuantity = $_POST['quantity'];

                // Fetch batches where the product is used and their corresponding quantities
                $sqlBatches = "SELECT * FROM product_batches WHERE product_id = $productId AND quantity > 0 ORDER BY bbd ASC";
                $resultBatches = $this->conn->query($sqlBatches);

                if ($resultBatches->num_rows > 0) {
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
                            while($rowBatch = $resultBatches->fetch_assoc()) {
                                $batchId = $rowBatch['batch_id'];
                                $bbd = $rowBatch['bbd'];
                                $batchQuantity = $rowBatch['quantity'];
                                $skuCode = $rowBatch['sku_code'];

                                // Determine the quantity to use from this batch
                                $quantityToUse = min($useQuantity, $batchQuantity);
                                $useQuantity -= $quantityToUse;

                                // Update the batch quantity and delete batch if quantity becomes zero
                                $newBatchQuantity = $batchQuantity - $quantityToUse;
                                if ($newBatchQuantity <= 0) {
                                    $sqlDeleteBatch = "DELETE FROM product_batches WHERE batch_id = $batchId";
                                    if ($this->conn->query($sqlDeleteBatch) !== TRUE) {
                                        echo "Error deleting batch: " . $this->conn->error;
                                    }
                                } else {
                                    $sqlUpdateBatch = "UPDATE product_batches SET quantity = $newBatchQuantity WHERE batch_id = $batchId";
                                    if ($this->conn->query($sqlUpdateBatch) !== TRUE) {
                                        echo "Error updating batch quantity: " . $this->conn->error;
                                    }
                                }
                                ?>
                                <tr>
                                    <td><?php echo $batchId; ?></td>
                                    <td><?php echo $bbd; ?></td>
                                    <td><?php echo $quantityToUse; ?></td>
                                    <td><?php echo $skuCode; ?></td>
                                </tr>
                                <?php

                                if($useQuantity <= 0) {
                                    break; // All requested quantity has been allocated
                                }
                            }

                            // If some quantity is still left unused, display a message
                            if($useQuantity > 0) {
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
                    $newProductQuantity = $productTotalQuantity - ($_POST['quantity'] - $useQuantity);
                    $sqlUpdateProduct = "UPDATE products SET total_quantity = $newProductQuantity WHERE product_id = $productId";
                    if ($this->conn->query($sqlUpdateProduct) !== TRUE) {
                        echo "Error updating product total quantity: " . $this->conn->error;
                    }
                } else {
                    echo "<p>No available batches found.</p>";
                }
            }
        } else {
            echo "<p>Product not found.</p>";
        }
    }
}

// Check if product_id is provided in the URL
if(isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];

    // Initialize ProductUser
    $productUser = new ProductUser($conn);

    // Use product
    $productUser->useProduct($productId, $_POST['quantity'] ?? null);
} else {
    echo "<p>No product ID provided.</p>";
}

// Close connection
$conn->close();
?>
