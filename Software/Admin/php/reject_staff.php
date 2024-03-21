<?php
// Include database connection
include 'db_connection.php';

// Check if staff_id is set
if (isset($_GET['staff_id'])) {
    $staff_id = $_GET['staff_id'];
    
    // Update staff status to Rejected
    $sql = "UPDATE staff SET status = 'Rejected' WHERE staff_id = $staff_id";

    if ($conn->query($sql) === TRUE) {
        // Success message
        $message = "Staff member rejected successfully!";
        echo "<script>alert('$message');</script>";
    } else {
        // Error message
        $message = "Error rejecting staff member: " . $conn->error;
        echo "<script>alert('$message');</script>";
    }
} else {
    // Redirect if staff_id is not set
    header("Location: ../staff.php");
}

// Close connection
$conn->close();

// Redirect to staff.php
echo "<script>window.location.href = '../staff.php';</script>";
?>
