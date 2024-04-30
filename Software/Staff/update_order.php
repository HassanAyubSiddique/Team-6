<?php
// Include database connection
include 'db_connection.php';

class OrderUpdater {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function updateOrder($orderId, $newStatus) {
        // Update order status
        $sql = "UPDATE orders SET status = ? WHERE order_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $newStatus, $orderId);

        if ($stmt->execute()) {
            $stmt->close(); // Close statement
            return "Order updated successfully";
        } else {
            $stmt->close(); // Close statement
            return "Error updating order: " . $stmt->error;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $orderUpdater = new OrderUpdater($conn);

    // Retrieve form data
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['new_status'];

    // Update order
    $message = $orderUpdater->updateOrder($orderId, $newStatus);

    // Redirect to PurchaseOrder.php with appropriate message
    echo "<script>alert('$message'); window.location.href = 'PurchaseOrder.php';</script>";
} else {
    // If form is not submitted, redirect back to PurchaseOrder.php
    header("Location: PurchaseOrder.php");
    exit();
}

// Close connection
$conn->close();
?>
