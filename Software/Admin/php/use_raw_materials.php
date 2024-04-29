<?php
// Include database connection
include 'db_connection.php';

// Check if raw_material_id is provided in the URL
if(isset($_GET['raw_material_id'])) {
    $raw_material_id = $_GET['raw_material_id'];

    // Fetch raw material information
    $sql_raw_material = "SELECT * FROM raw_materials WHERE raw_material_id = $raw_material_id";
    $result_raw_material = $conn->query($sql_raw_material);

    if ($result_raw_material->num_rows > 0) {
        $row_raw_material = $result_raw_material->fetch_assoc();
        $raw_material_name = $row_raw_material['name'];
        $raw_material_total_quantity = $row_raw_material['total_quantity'];
        ?>
        <h2>Use Raw Material: <?php echo $raw_material_name; ?></h2>
        <p>Total Quantity Available: <?php echo $raw_material_total_quantity; ?></p>
        <form action="" method="post">
            <label for="quantity">Select Quantity:</label>
            <input type="number" id="quantity" name="quantity" min="1" max="<?php echo $raw_material_total_quantity; ?>" required>
            <?php if(isset($_POST['use']) && $_POST['quantity'] > $raw_material_total_quantity): ?>
                <span style="color: red;">Requested quantity exceeds available stock.</span>
            <?php endif; ?>
            <button type="submit" name="use">Use</button>
            <button onclick="window.location.href = '../ViewRawMaterial.php';">Close</button>
        </form>
        <?php
        if(isset($_POST['use']) && $_POST['quantity'] <= $raw_material_total_quantity) {
            $use_quantity = $_POST['quantity'];

            // Fetch batches where the raw material is used and their corresponding quantities
            $sql_batches = "SELECT * FROM raw_material_batches WHERE raw_material_id = $raw_material_id AND quantity > 0 ORDER BY bbd ASC";
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
                                $sql_delete_batch = "DELETE FROM raw_material_batches WHERE batch_id = $batch_id";
                                if ($conn->query($sql_delete_batch) !== TRUE) {
                                    echo "Error deleting batch: " . $conn->error;
                                }
                            } else {
                                $sql_update_batch = "UPDATE raw_material_batches SET quantity = $new_batch_quantity WHERE batch_id = $batch_id";
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
                // Update total quantity in raw materials table
                $new_raw_material_quantity = $raw_material_total_quantity - ($_POST['quantity'] - $use_quantity);
                $sql_update_raw_material = "UPDATE raw_materials SET total_quantity = $new_raw_material_quantity WHERE raw_material_id = $raw_material_id";
                if ($conn->query($sql_update_raw_material) !== TRUE) {
                    echo "Error updating raw material total quantity: " . $conn->error;
                }
            } else {
                echo "<p>No available batches found.</p>";
            }
        }
    } else {
        echo "<p>Raw material not found.</p>";
    }
} else {
    echo "<p>No raw material ID provided.</p>";
}

// Close connection
$conn->close();
?>
