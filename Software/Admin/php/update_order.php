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
        // Redirect to purchase_orders.php with success message
        echo "<script>alert('Order updated successfully'); window.location.href = '../purchase_orders.php';</script>";
    } else {
        // Redirect to purchase_orders.php with error message
        echo "<script>alert('Error updating order: " . $stmt->error . "'); window.location.href = '../purchase_orders.php';</script>";
    }

    // Close statement
    $stmt->close();
} else {
    // If form is not submitted, redirect back to purchase_orders.php
    header("Location: ../purchase_orders.php");
    exit();
}

// Close connection
$conn->close();
?>
