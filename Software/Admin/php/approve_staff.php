<?php
// Include database connection
include 'db_connection.php';

/**
 * Class StaffManager handles operations related to staff members.
 */
class StaffManager {
    private $conn;

    /**
     * Constructor to initialize the StaffManager with the provided database connection.
     * @param mysqli $conn The database connection object.
     */
    public function __construct($conn) {
        $this->conn = $conn;
    }

    /**
     * Approves a staff member by updating their status to "Approved".
     * @param int $staffId The ID of the staff member.
     * @return bool True if the update is successful, false otherwise.
     */
    public function approveStaffMember($staffId) {
        // Update staff status to "Approved"
        $sql = "UPDATE staff SET status = 'Approved' WHERE staff_id = $staffId";
        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Process the approval of a staff member.
 * @param mysqli $conn The database connection object.
 */
function processStaffApproval($conn) {
    // Check if staff ID is provided in the URL
    if (isset($_GET['staff_id'])) {
        $staffId = $_GET['staff_id'];

        // Create StaffManager object
        $staffManager = new StaffManager($conn);

        // Approve staff member
        if ($staffManager->approveStaffMember($staffId)) {
            // Success message
            $message = "Staff member approved successfully!";
            echo "<script>alert('$message');</script>";
        } else {
            // Error message
            $message = "Error approving staff member: " . $conn->error;
            echo "<script>alert('$message');</script>";
        }
    } else {
        // Redirect if staff ID is not set
        header("Location: ../Staff.php");
    }
}

// Process staff approval
processStaffApproval($conn);

// Close connection
$conn->close();

// Redirect to Staff.php
echo "<script>window.location.href = '../Staff.php';</script>";
?>
