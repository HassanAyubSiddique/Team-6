<?php
// Include database connection
include 'db_connection.php';

// Query to fetch admin info with profile picture
$sql = "SELECT first_name, last_name, profile_pic FROM admins LIMIT 1";
$result = $conn->query($sql);

// Fetch and display admin info with profile picture
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<a href='AdProfile.php'>";
    // Check if profile picture exists
    if ($row['profile_pic']) {
        // Display profile picture from BLOB data
        echo '<img src="data:image/jpeg;base64,' . base64_encode($row['profile_pic']) . '" alt="Profile Picture">';
    } else {
        // Display default profile picture
        echo '<img src="default-profile-pic.jpg" alt="Profile Picture">';
    }
    echo "<span id='profile-name'>" . $row["first_name"] . " " . $row["last_name"] . "</span>";
    echo "</a>";
} else {
    echo "Admin not found";
}

// Close connection
$conn->close();
?>
