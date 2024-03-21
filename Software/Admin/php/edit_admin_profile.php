<?php
// Include database connection
include 'db_connection.php';

// Retrieve admin profile information
$sql = "SELECT * FROM admins LIMIT 1";
$result = $conn->query($sql);

// Check if any rows were returned
if ($result->num_rows > 0) {
    // Fetch admin profile details
    $row = $result->fetch_assoc();
    $firstName = $row["first_name"];
    $lastName = $row["last_name"];
    // You can add more fields here if needed

    // Close the previous database query
    $result->close();
} else {
    // Handle the case where no admin profile is found
    echo "No admin profile found";
    exit();
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Warehouse Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">

        <main id="content">
            <h2>Edit Profile</h2>
            <form id="edit-profile-form" action="./php/update_admin_profile.php" method="post" enctype="multipart/form-data">
                <label for="profile-picture">Profile Picture:</label>
                <input type="file" id="profile-picture" name="profile-picture" accept="image/*"><br><br>
                <label for="first-name">First Name:</label>
                <input type="text" id="first-name" name="first-name" value="<?php echo $firstName; ?>"><br><br>
                <label for="last-name">Last Name:</label>
                <input type="text" id="last-name" name="last-name" value="<?php echo $lastName; ?>"><br><br>
                <!-- You can add more fields here if needed -->
                <button type="submit" name="submit">Save Changes</button>
            </form>
        </main>
    </div>
    <script src="script.js"></script>
</body>
</html>
