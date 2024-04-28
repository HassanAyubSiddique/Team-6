<?php
// Include database connection
include 'db_connection.php';

function retrieveAdminProfile($conn, $admin_id, &$firstName, &$lastName, &$email, &$phoneNumber, &$address, &$city, &$country, &$postcode) {
  // Prepare and execute SQL query to retrieve admin profile
  $sql = "SELECT * FROM admins WHERE admin_id = $admin_id";
  $result = $conn->query($sql);

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
    echo "Admin profile not found.";
  }
}

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

    // Prepare SQL statement to update admin profile
    $sql = "UPDATE admins SET first_name = '$firstName', last_name = '$lastName', phone_number = '$phoneNumber', address = '$address', city = '$city', country = '$country', postcode = '$postcode' WHERE admin_id = $admin_id";

    // Execute SQL statement
    if ($conn->query($sql) === TRUE) {
      // Redirect to AdProfile.php after updating
      header("Location: ../AdProfile.php");
      exit();
    } else {
      echo "Error updating profile: " . $conn->error;
    }
  } else {
    echo "Form not submitted properly. 'update-profile' not set.";
  }
} 
    // Change Password Section
    if (isset($_POST['change_password'])) { // Check if the password change form is submitted
  
      // Get form data
      $admin_id = $_POST['admin_id'];
      $oldPassword = $_POST['oldPassword'];
      $newPassword = $_POST['newPassword'];
      $confirmPassword = $_POST['confirmPassword'];
  
      // Validate passwords
      if ($newPassword != $confirmPassword) {
        echo "<script>alert('New password and confirm password do not match.');</script>";
        echo "<script>window.location.href = '../AdProfile.php';</script>";
        exit();
      }
  
      // Retrieve old password hash from the database
      $sql = "SELECT password FROM admins WHERE admin_id = $admin_id";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['password'];
        // Verify old password
        if ($oldPassword=== $storedPassword) {
          // Hash the new password
          $hashedPassword = $newPassword ;
          // Update password in the database
          $updateSql = "UPDATE admins SET password = '$hashedPassword' WHERE admin_id = $admin_id";
          if ($conn->query($updateSql) === TRUE) {
            echo "<script>alert('Password updated successfully.');</script>";
            echo "<script>window.location.href = '../AdProfile.php';</script>";
            exit();
          } else {
            echo "<script>alert('Error updating password: " . $conn->error . "');</script>";
            echo "<script>window.location.href = '../AdProfile.php';</script>";
            exit();
          }
        } else {
          echo "<script>alert('Old password is incorrect.');</script>";
          echo "<script>window.location.href = '../AdProfile.php';</script>";
          exit();
        }
      } else {
        echo "<script>alert('Admin profile not found.');</script>";
        echo "<script>window.location.href = '../AdProfile.php';</script>";
        exit();
      }
    }
 
?>
