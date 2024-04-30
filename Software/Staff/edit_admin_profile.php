<?php
// Include database connection
include 'db_connection.php';

class AdminManagement {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Retrieve admin profile from the database
    public function retrieveAdminProfile($staff_id, &$firstName, &$lastName, &$email, &$phoneNumber, &$address, &$city, &$country, &$postcode) {
        // Prepare and execute SQL query to retrieve admin profile
        $sql = "SELECT * FROM staff WHERE staff_id = $staff_id";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $firstName = $row['first_name'];
            $lastName = $row['last_name'];
            $email = $row['email'];
            $phoneNumber = $row['phone_number'];
            $address = $row['address'];
            $city = $row['city'];
            $country = $row['country'];
            $postcode = $row['postcode'];
        } else {
            echo "Staff profile not found.";
        }
    }

    // Update admin profile in the database
    public function updateAdminProfile($staff_id, $firstName, $lastName, $phoneNumber, $address, $city, $country, $postcode) {
        // Prepare SQL statement to update admin profile
        $sql = "UPDATE Staff SET first_name = '$firstName', last_name = '$lastName', phone_number = '$phoneNumber', address = '$address', city = '$city', country = '$country', postcode = '$postcode' WHERE staff_id = $staff_id";

        // Execute SQL statement
        if ($this->conn->query($sql) === TRUE) {
            // Redirect to AdProfile.php after updating
            header("Location: AdProfile.php");
            exit();
        } else {
            echo "Error updating profile: " . $this->conn->error;
        }
    }

    // Change admin password
    public function changePassword($staff_id, $oldPassword, $newPassword, $confirmPassword) {
        // Validate passwords
        if ($newPassword != $confirmPassword) {
            echo "<script>alert('New password and confirm password do not match.');</script>";
            echo "<script>window.location.href = 'AdProfile.php';</script>";
            exit();
        }

        // Retrieve old password hash from the database
        $sql = "SELECT password FROM staff WHERE staff_id = $staff_id";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $storedPassword = $row['password'];
            // Verify old password
            if ($oldPassword === $storedPassword) {
                // Hash the new password
                $hashedPassword = $newPassword;
                // Update password in the database
                $updateSql = "UPDATE staff SET password = '$hashedPassword' WHERE staff_id = $staff_id";
                if ($this->conn->query($updateSql) === TRUE) {
                    echo "<script>alert('Password updated successfully.');</script>";
                    echo "<script>window.location.href = 'AdProfile.php';</script>";
                    exit();
                } else {
                    echo "<script>alert('Error updating password: " . $this->conn->error . "');</script>";
                    echo "<script>window.location.href = 'AdProfile.php';</script>";
                    exit();
                }
            } else {
                echo "<script>alert('Old password is incorrect.');</script>";
                echo "<script>window.location.href = 'AdProfile.php';</script>";
                exit();
            }
        } else {
            echo "<script>alert('Staff profile not found.');</script>";
            echo "<script>window.location.href = 'AdProfile.php';</script>";
            exit();
        }
    }

    // Function to handle form submissions
    public function handleFormSubmission() {
        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['update_profile'])) { // Adjust button name if needed
                // Get form data
                $admin_id = $_POST['admin_id'];
                $firstName = $_POST['newFirstName'];
                $lastName = $_POST['newLastName'];
                $phoneNumber = $_POST['newPhoneNumber'];
                $address = $_POST['newAddress'];
                $city = $_POST['newCity'];
                $country = $_POST['newCountry'];
                $postcode = $_POST['newPostcode'];

                // Update admin profile
                $this->updateAdminProfile($admin_id, $firstName, $lastName, $phoneNumber, $address, $city, $country, $postcode);
            } else {
                echo "Form not submitted properly. 'update-profile' not set.";
            }

            // Change Password Section
            if (isset($_POST['change_password'])) { // Check if the password change form is submitted
                // Get form data
                $admin_id = $_POST['admin_id'];
                $oldPassword = $_POST['oldPassword'];
                $newPassword = $_POST['newPassword'];
                $confirmPassword = $_POST['confirmPassword'];

                // Change admin password
                $this->changePassword($admin_id, $oldPassword, $newPassword, $confirmPassword);
            }
        }
    }
}

// Create an instance of AdminManagement
$adminManagement = new AdminManagement($conn);

// Handle form submissions
$adminManagement->handleFormSubmission();
?>
