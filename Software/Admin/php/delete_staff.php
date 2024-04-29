<?php
// Include database connection
include 'db_connection.php';

/**
 * Class StaffManager handles staff-related database operations.
 */
class StaffManager {
    private $conn;

    /**
     * Constructor to initialize the StaffManager with a database connection.
     * @param mysqli $conn The database connection object.
     */
    public function __construct($conn) {
        $this->conn = $conn;
    }

    /**
     * Deletes a staff member from the database.
     * @param int $staff_id The ID of the staff member to delete.
     * @return string|null Error message if deletion fails, null otherwise.
     */
    public function deleteStaff($staff_id) {
        // Delete staff member
        $sql = "DELETE FROM staff WHERE staff_id = $staff_id";

        if ($this->conn->query($sql) === TRUE) {
            return null; // Deletion successful, no error
        } else {
            return "Error deleting staff member: " . $this->conn->error;
        }
    }

    /**
     * Deletes a staff member based on the staff ID from the URL.
     * Displays error message if staff ID is not provided.
     */
    public function deleteStaffFromURL() {
        // Check if staff_id is set
        if (isset($_GET['staff_id'])) {
            $staff_id = $_GET['staff_id'];

            // Delete staff member
            $error_message = $this->deleteStaff($staff_id);

            // Check if there was an error
            if ($error_message === null) {
                $message = "Staff member deleted successfully!";
                echo "<script>alert('$message');</script>";
            } else {
                echo "<script>alert('$error_message');</script>";
            }
        } else {
            // Redirect if staff_id is not set
            header("Location: ../Staff.php");
        }

        // Close connection
        $this->conn->close();

        // Redirect to Staff.php
        echo "<script>window.location.href = '../Staff.php';</script>";
    }
}

// Create StaffManager object
$staffManager = new StaffManager($conn);

// Delete staff member based on the staff ID from the URL
$staffManager->deleteStaffFromURL();
?>
