<?php
// Include database connection
include 'db_connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $raw_material_id = $_POST['raw_material_id'];
    $bbd = $_POST['bbd'];
    $quantity = $_POST['quantity'];

    // Validate inputs (you can add more validation as needed)
    if (empty($raw_material_id) || empty($bbd) || empty($quantity)) {
        echo "Please fill in all fields";
    } else {
        // Insert batch into raw_material_batches table
        $sql = "INSERT INTO raw_material_batches (raw_material_id, bbd, quantity) VALUES ('$raw_material_id', '$bbd', '$quantity')";
        if ($conn->query($sql) === TRUE) {
            // Get the last inserted batch ID
            $last_batch_id = $conn->insert_id;

            // Generate SKU with batch ID
            $sku_code = "RM$raw_material_id-$bbd-B$last_batch_id";

            // Update SKU code in the database
            $sql_update_sku = "UPDATE raw_material_batches SET sku_code = '$sku_code' WHERE batch_id = '$last_batch_id'";
            if ($conn->query($sql_update_sku) === TRUE) {
                // Fetch current total_quantity for the raw material
                $sql_fetch_total_quantity = "SELECT total_quantity FROM raw_materials WHERE raw_material_id = '$raw_material_id'";
                $result_fetch_total_quantity = $conn->query($sql_fetch_total_quantity);

                if ($result_fetch_total_quantity->num_rows > 0) {
                    $row_fetch_total_quantity = $result_fetch_total_quantity->fetch_assoc();
                    $current_total_quantity = $row_fetch_total_quantity['total_quantity'];
                    // Calculate new total_quantity by adding the new quantity
                    $new_total_quantity = $current_total_quantity + $quantity;
                    // Update raw_materials table with new total_quantity
                    $sql_update_total_quantity = "UPDATE raw_materials SET total_quantity = '$new_total_quantity' WHERE raw_material_id = '$raw_material_id'";
                    if ($conn->query($sql_update_total_quantity) === TRUE) {
                        // Batch added successfully and raw_materials table updated
                        echo "<script>alert('Batch added successfully');</script>";
                        // Redirect to raw materials page
                        echo "<script>window.location.href = '../ViewRawMaterial.php';</script>";
                        exit();
                    } else {
                        echo "Error updating raw material total quantity: " . $conn->error;
                    }
                } else {
                    echo "Error fetching current total quantity for the raw material";
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
