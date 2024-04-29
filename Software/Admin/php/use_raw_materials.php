<?php
// Include database connection
include 'db_connection.php';

class RawMaterialUser {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function useRawMaterial($rawMaterialId, $requestedQuantity) {
        // Fetch raw material information
        $sqlRawMaterial = "SELECT * FROM raw_materials WHERE raw_material_id = $rawMaterialId";
        $resultRawMaterial = $this->conn->query($sqlRawMaterial);

        if ($resultRawMaterial->num_rows > 0) {
            $rowRawMaterial = $resultRawMaterial->fetch_assoc();
            $rawMaterialName = $rowRawMaterial['name'];
            $rawMaterialTotalQuantity = $rowRawMaterial['total_quantity'];
            ?>
            <h2>Use Raw Material: <?php echo $rawMaterialName; ?></h2>
            <p>Total Quantity Available: <?php echo $rawMaterialTotalQuantity; ?></p>
            <form action="" method="post">
                <label for="quantity">Select Quantity:</label>
                <input type="number" id="quantity" name="quantity" min="1" max="<?php echo $rawMaterialTotalQuantity; ?>" required>
                <?php if(isset($_POST['use']) && $_POST['quantity'] > $rawMaterialTotalQuantity): ?>
                    <span style="color: red;">Requested quantity exceeds available stock.</span>
                <?php endif; ?>
                <button type="submit" name="use">Use</button>
                <button onclick="window.location.href = '../ViewRawMaterial.php';">Close</button>
            </form>
            <?php
            if(isset($_POST['use']) && $_POST['quantity'] <= $rawMaterialTotalQuantity) {
                $useQuantity = $_POST['quantity'];

                // Fetch batches where the raw material is used and their corresponding quantities
                $sqlBatches = "SELECT * FROM raw_material_batches WHERE raw_material_id = $rawMaterialId AND quantity > 0 ORDER BY bbd ASC";
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
                                    $sqlDeleteBatch = "DELETE FROM raw_material_batches WHERE batch_id = $batchId";
                                    if ($this->conn->query($sqlDeleteBatch) !== TRUE) {
                                        echo "Error deleting batch: " . $this->conn->error;
                                    }
                                } else {
                                    $sqlUpdateBatch = "UPDATE raw_material_batches SET quantity = $newBatchQuantity WHERE batch_id = $batchId";
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
                    // Update total quantity in raw materials table
                    $newRawMaterialQuantity = $rawMaterialTotalQuantity - ($_POST['quantity'] - $useQuantity);
                    $sqlUpdateRawMaterial = "UPDATE raw_materials SET total_quantity = $newRawMaterialQuantity WHERE raw_material_id = $rawMaterialId";
                    if ($this->conn->query($sqlUpdateRawMaterial) !== TRUE) {
                        echo "Error updating raw material total quantity: " . $this->conn->error;
                    }
                } else {
                    echo "<p>No available batches found.</p>";
                }
            }
        } else {
            echo "<p>Raw material not found.</p>";
        }
    }
}

// Check if raw_material_id is provided in the URL
if(isset($_GET['raw_material_id'])) {
    $rawMaterialId = $_GET['raw_material_id'];

    // Initialize RawMaterialUser
    $rawMaterialUser = new RawMaterialUser($conn);

    // Use raw material
    $rawMaterialUser->useRawMaterial($rawMaterialId, $_POST['quantity'] ?? null);
} else {
    echo "<p>No raw material ID provided.</p>";
}

// Close connection
$conn->close();
?>
