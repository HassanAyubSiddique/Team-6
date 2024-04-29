<?php
// Include database connection
include 'db_connection.php';

class StaffRejectionHandler {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Function to update staff status to Rejected
    public function rejectStaff($staffID)
    {
        // Update staff status to Rejected
        $sql = "UPDATE staff SET status = 'Rejected' WHERE staff_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $staffID);

        if ($stmt->execute()) {
            // Success message
            $message = "Staff member rejected successfully!";
        } else {
            // Error message
            $message = "Error rejecting staff member: " . $this->conn->error;
        }

        // Close statement
        $stmt->close();

        // Close connection
        $this->conn->close();

        return $message;
    }
}

class StaffRejectionController {
    private $rejectionHandler;

    public function __construct(StaffRejectionHandler $rejectionHandler) {
        $this->rejectionHandler = $rejectionHandler;
    }

    // Function to handle staff rejection process
    public function handleRejection()
    {
        // Check if staff_id is set
        if (isset($_GET['staff_id'])) {
            $staff_id = $_GET['staff_id'];
            $message = $this->rejectionHandler->rejectStaff($staff_id);
        } else {
            // Redirect if staff_id is not set
            header("Location: ../Staff.php");
            return;
        }

        // Redirect to Staff.php
        echo "<script>alert('$message'); window.location.href = '../Staff.php';</script>";
    }
}

// Instantiate the rejection handler and controller
$rejectionHandler = new StaffRejectionHandler($conn);
$rejectionController = new StaffRejectionController($rejectionHandler);

// Call the function to handle staff rejection
$rejectionController->handleRejection();
?>
