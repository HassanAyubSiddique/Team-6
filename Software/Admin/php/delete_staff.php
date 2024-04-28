<?php
// Include database connection
include 'db_connection.php';

// Check if staff_id is set
if (isset($_GET['staff_id'])) {
    $staff_id = $_GET['staff_id'];
    
    // Delete staff member
    $sql = "DELETE FROM staff WHERE staff_id = $staff_id";

    if ($conn->query($sql) === TRUE) {
        // Success message
        $message = "Staff member deleted successfully!";
        echo "<script>alert('$message');</script>";
    } else {
        // Error message
        $message = "Error deleting staff member: " . $conn->error;
        echo "<script>alert('$message');</script>";
    }
} else {
    // Redirect if staff_id is not set
    header("Location: ../Staff.php");
}

// Close connection
$conn->close();

// Redirect to Staff.php
echo "<script>window.location.href = '../Staff.php';</script>";
?>
