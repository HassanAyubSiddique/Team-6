<?php
// Include database connection
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if file is uploaded
    if (isset($_FILES["profile-picture"]) && $_FILES["profile-picture"]["error"] == 0) {
        $profile_pic = file_get_contents($_FILES["profile-picture"]["tmp_name"]);
    } else {
        // If no file uploaded, keep the existing profile picture
        $sql = "SELECT profile_pic FROM admins LIMIT 1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $profile_pic = $row["profile_pic"];
        }
    }

    // Get other profile information from the form
    $first_name = $_POST["first-name"];
    $last_name = $_POST["last-name"];
    
    // Update admin profile information excluding email
    $sql = "UPDATE admins SET profile_pic=?, first_name=?, last_name=? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $profile_pic, $first_name, $last_name);

    if ($stmt->execute()) {
        // Redirect to profile.php with success message
        echo "<script>alert('Profile updated successfully'); window.location.href = '../profile.php';</script>";
    } else {
        // Redirect to profile.php with error message
        echo "<script>alert('Error updating profile: " . $stmt->error . "'); window.location.href = 'profile.php';</script>";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
