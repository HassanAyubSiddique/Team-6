<?php
// Include database connection
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];

    // Update order status
    $sql = "UPDATE orders SET status = ? WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_status, $order_id);

    if ($stmt->execute()) {
        // Redirect to PurchaseOrder.php with success message
        echo "<script>alert('Order updated successfully'); window.location.href = '../PurchaseOrder.php';</script>";
    } else {
        // Redirect to PurchaseOrder.php with error message
        echo "<script>alert('Error updating order: " . $stmt->error . "'); window.location.href = '../PurchaseOrder.php';</script>";
    }

    // Close statement
    $stmt->close();
} else {
    // If form is not submitted, redirect back to PurchaseOrder.php
    header("Location: ../PurchaseOrder.php");
    exit();
}

// Close connection
$conn->close();
?>
