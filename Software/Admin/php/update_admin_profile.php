<?php
// Include database connection
include 'db_connection.php';

class AdminProfileUpdater {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function updateProfile($firstName, $lastName, $profilePicture) {
        // Check if file is uploaded
        if (!empty($profilePicture)) {
            // If file uploaded, get its contents
            $profilePicData = file_get_contents($profilePicture["tmp_name"]);
        } else {
            // If no file uploaded, keep the existing profile picture
            $sql = "SELECT profile_pic FROM admins LIMIT 1";
            $result = $this->conn->query($sql);
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $profilePicData = $row["profile_pic"];
            }
        }
    
        // Update admin profile information excluding email
        $sql = "UPDATE admins SET profile_pic=?, first_name=?, last_name=? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $profilePicData, $firstName, $lastName);
    
        if ($stmt->execute()) {
            $stmt->close(); // Close statement
            return "Profile updated successfully";
        } else {
            $stmt->close(); // Close statement
            return "Error updating profile: " . $stmt->error;
        }
    }

}

function handleFormSubmission($conn) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $adminProfileUpdater = new AdminProfileUpdater($conn);

        // Get profile information from the form
        $firstName = $_POST["first-name"];
        $lastName = $_POST["last-name"];
        $profilePicture = $_FILES["profile-picture"];

        $message = $adminProfileUpdater->updateProfile($firstName, $lastName, $profilePicture);
        
        // Redirect to AdProfile.php with appropriate message
        redirectToAdminProfile($message);
    }
}

function redirectToAdminProfile($message) {
    echo "<script>alert('" . $message . "'); window.location.href = '../AdProfile.php';</script>";
}

// Handle form submission
handleFormSubmission($conn);

// Close connection
$conn->close();
?>
