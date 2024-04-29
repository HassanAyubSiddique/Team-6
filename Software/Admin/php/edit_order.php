<?php
// Include database connection
include 'db_connection.php';

class EditOrder {
    private $conn;

    // Constructor to initialize the database connection
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Function to fetch order details from the database
    public function fetchOrderDetails($order_id) {
        if(isset($order_id)) {
            $sql = "SELECT status FROM orders WHERE order_id = $order_id";
            $result = $this->conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $current_status = $row["status"];
                return $current_status;
            } else {
                return "No order found with the provided ID";
            }
        } else {
            return "Order ID not specified";
        }
    }

    // Function to display the order form
    public function displayOrderForm($order_id) {
        $current_status = $this->fetchOrderDetails($order_id);

        if ($current_status !== false) {
            $status_sql = "SHOW COLUMNS FROM orders LIKE 'status'";
            $status_result = $this->conn->query($status_sql);
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
            echo $current_status;
        }
    }
}

// Create an instance of the EditOrder class
$editOrder = new EditOrder($conn);
?>

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
                // Call the displayOrderForm method of the EditOrder instance
                $editOrder->displayOrderForm($_GET['order_id']);
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
