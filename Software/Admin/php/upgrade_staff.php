<?php
// Include database connection
include 'db_connection.php';

class StaffUpgrader {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function upgradeStaffToAdmin($staffId) {
        // Retrieve staff details based on the staff_id
        $sqlStaff = "SELECT * FROM staff WHERE staff_id = $staffId";
        $resultStaff = $this->conn->query($sqlStaff);

        // Check if staff exists
        if ($resultStaff->num_rows > 0) {
            $rowStaff = $resultStaff->fetch_assoc();

            // Insert staff details into the admins table
            $insertAdminSql = "INSERT INTO admins(first_name, last_name, email, address, profile_pic, password, phone_number, city, country, postcode)
                                VALUES ('" . $rowStaff["first_name"] . "', '" . $rowStaff["last_name"] . "', '" . $rowStaff["email"] . "', '" . $rowStaff["address"] . "', '" . $rowStaff["profile_pic"] . "', '" . $rowStaff["password"] . "', '" . $rowStaff["phone_number"] . "', '" . $rowStaff["city"] . "', '" . $rowStaff["country"] . "', '" . $rowStaff["postcode"] . "')";

            if ($this->conn->query($insertAdminSql) === TRUE) {
                // Successfully added to admins table, now delete from staff table
                $deleteStaffSql = "DELETE FROM staff WHERE staff_id = $staffId";

                if ($this->conn->query($deleteStaffSql) === TRUE) {
                    return true;
                } else {
                    return "Error deleting record from staff table: " . $this->conn->error;
                }
            } else {
                return "Error inserting record into admins table: " . $this->conn->error;
            }
        } else {
            return "Staff not found";
        }
    }
}

// Check if staff_id is provided in the URL
if (isset($_GET['staff_id'])) {
    $staffId = $_GET['staff_id'];

    // Initialize StaffUpgrader
    $staffUpgrader = new StaffUpgrader($conn);

    // Upgrade staff to admin
    $result = $staffUpgrader->upgradeStaffToAdmin($staffId);

    if ($result === true) {
        // Redirect to ../Staff.php after successful upgrade
        header("Location: ../Staff.php?upgrade_success=true");
        exit();
    } else {
        echo $result;
    }
} else {
    echo "Staff ID not provided";
}

// Close connection
$conn->close();
?>
