<?php
// Include database connection
include 'db_connection.php';

// Check if staff_id is provided in the URL
if (isset($_GET['staff_id'])) {
    $staff_id = $_GET['staff_id'];

    // Retrieve staff details based on the staff_id
    $sql_staff = "SELECT * FROM staff WHERE staff_id = $staff_id";
    $result_staff = $conn->query($sql_staff);

    // Check if staff exists
    if ($result_staff->num_rows > 0) {
        $row_staff = $result_staff->fetch_assoc();
        
        // Insert staff details into the admins table
        $insert_admin_sql = "INSERT INTO admins(first_name, last_name, email, address, profile_pic, password, phone_number, city, country, postcode)
                             VALUES ('" . $row_staff["first_name"] . "', '" . $row_staff["last_name"] . "', '" . $row_staff["email"] . "', '" . $row_staff["address"] . "', '" . $row_staff["profile_pic"] . "', '" . $row_staff["password"] . "', '" . $row_staff["phone_number"] . "', '" . $row_staff["city"] . "', '" . $row_staff["country"] . "', '" . $row_staff["postcode"] . "')";

        if ($conn->query($insert_admin_sql) === TRUE) {
            // Successfully added to adminstable, now delete from staff table
            $delete_staff_sql = "DELETE FROM staff WHERE staff_id = $staff_id";

            if ($conn->query($delete_staff_sql) === TRUE) {
                // Redirect to ../Staff.php after successful upgrade
                header("Location: ../Staff.php?upgrade_success=true");
                exit();
            } else {
                echo "Error deleting record from staff table: " . $conn->error;
            }
        } else {
            echo "Error inserting record into adminstable: " . $conn->error;
        }
    } else {
        echo "Staff not found";
    }
} else {
    echo "Staff ID not provided";
}

// Close connection
$conn->close();
?>
