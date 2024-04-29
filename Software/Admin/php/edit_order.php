<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order - Warehouse Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="popup">
        <div class="popup-content">
            <span class="close" onclick="closePopup()">&times;</span>
            <h2>Edit Order</h2>
            <form id="edit-order-form" action="./update_order.php" method="post">
                <?php
                // Include database connection
                include 'db_connection.php';

                // Check if order_id is set
                if(isset($_GET['order_id'])) {
                    // Retrieve order_id
                    $order_id = $_GET['order_id'];

                    // Fetch order details from database
                    $sql = "SELECT status FROM orders WHERE order_id = $order_id";
                    $result = $conn->query($sql);

                    // Check if any rows were returned
                    if ($result->num_rows > 0) {
                        // Fetch order details
                        $row = $result->fetch_assoc();
                        $current_status = $row["status"];

                        // Get available status options from database
                        $status_sql = "SHOW COLUMNS FROM orders LIKE 'status'";
                        $status_result = $conn->query($status_sql);
                        if ($status_result->num_rows > 0) {
                            $row = $status_result->fetch_assoc();
                            $options = explode("','", preg_replace("/(enum|set)\('(.+?)'\)/", "\\2", $row['Type']));
                            ?>
                            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                            <label for="status">Current Status:</label>
                            <input type="text" id="status" name="status" value="<?php echo $current_status; ?>" readonly><br><br>
                            <label for="new_status">New Status:</label>
                            <select id="new_status" name="new_status">
                                <?php foreach ($options as $option) { ?>
                                    <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                                <?php } ?>
                            </select><br><br>
                            <button type="submit" name="submit">Save Changes</button>
                            <button type="button" onclick="closePopup()">Cancel</button>
                            <?php
                        } else {
                            echo "No status options found in the database";
                        }
                    } else {
                        echo "No order found with the provided ID";
                    }
                } else {
                    echo "Order ID not specified";
                }

                // Close connection
                $conn->close();
                ?>
            </form>
        </div>
    </div>

    <script>
        function closePopup() {
            window.location.href = "../PurchaseOrder.php";
        }
    </script>
</body>
</html>
