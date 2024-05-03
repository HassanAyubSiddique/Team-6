<?php
// Include database connection
include 'db_connection.php';
include 'edit_admin_profile.php'; // Include the AdminManagement class file

// Initialize variables
$firstName = "";
$lastName = "";
$email = "";
$phoneNumber = "";
$address = "";
$city = "";
$country = "";
$postcode = "";
$staff_id = 12;
// Create an instance of AdminManagement
$adminManagement = new AdminManagement($conn);

// Retrieve admin profile information from the database
$adminManagement->retrieveAdminProfile($staff_id, $firstName, $lastName, $email, $phoneNumber, $address, $city, $country, $postcode);

// // Retrieve admin data for the table
// $sqlAdmins = "SELECT * FROM admins";
// $resultAdmins = $conn->query($sqlAdmins);

// Close database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dropdown Sidebar - Tivotal</title>

    <!--font awesome-->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
    />

    <!--css file-->
    <link rel="stylesheet" href="AdminDashboard.css" /> 
  </head>
  <body>


  <!-- ======================= menu ================== -->
    <div class="sidebar close">
      <div class="logo">
        <!-- if we want to add logo inside the menu -->
        <span class="logo-name"></span>
      </div>

      <ul class="nav-list">
        <li>
          <div class="icon-link">
            <a href="ViewProduct.php">
              <i class="fas fa-box-open"></i>
              <span class="link-name">Products</span>
            </a>
            <i class="fas fa-caret-down arrow"></i>
          </div>

          <ul class="sub-menu">
            <li><a href="#" class="link-name">Products</a></li>
            <li><a href="ViewProduct.php">View Product</a></li>
           </ul>
        </li>

        <li>
          <a href="PurchaseOrder.php">
            <i class="fas fa-shopping-cart"></i>
            <span class="link-name">Purchase Orders</span>
          </a>

          <ul class="sub-menu blank">
            <li><a href="PurchaseOrder.php" class="link-name">Purchase Orders</a></li>
          </ul>
        </li>

        
        <li>
          <div class="icon-link">
            <a href="StaffViewRawMaterials.html">
              <i class="fas fa-boxes"></i>
              <span class="link-name">Raw Materials</span>
            </a>
            <i class="fas fa-caret-down arrow"></i>
          </div>

          <ul class="sub-menu">
            <li><a href="#" class="link-name">Raw Materials</a></li>
            <li><a href="ViewRawMaterial.php">View Raw Materials</a></li>
            <li><a href="StaffOrderRawMaterial.html">Order Raw Materials</a></li>
          </ul>
        </li> 

        <li>
          <a href="AdProfile.php">
            <i class="fas fa-id-card-alt"></i>
            <span class="link-name">Profile</span>
          </a>

          <ul class="sub-menu blank">
            <li><a href="AdProfile.php" class="link-name">Profile</a></li>
          </ul>
        </li>

        <li>
          <a href="#" onclick="confirmSignout()">
              <i class="fas fa-sign-out-alt"></i>
              <span class="link-name">Signout</span>
          </a>
      
          <ul class="sub-menu blank">
              <li><a href="#" onclick="confirmSignout()">Signout</a></li>
          </ul>
      </li>
      

      
      </ul>
      
    </div>
    
    

    <div class="home-section">
       <!-- ======================= nav ================== -->
      <div class="main">
        
        <div class="topbar">
            <div class="toggle">
                <ion-icon name="menu-outline"></ion-icon>
                <div class="home-content">
                  <i class="fas fa-bars"></i>
                  
              
                </div>
            </div>
            <img src="img/Screenshot 2024-03-16 at 01.30.56.png" alt="" class="lo">

            <div class="search">
              
            </div>

            <div class="user">
                <img src="img/Screenshot 2024-03-15 at 19.56.42.png" alt="">
            </div>
            
       
            
    </div>
 
    

<!-- Update Information -->
<div class="profile-section">
  <h2 class="product-heading">Update Information</h2>
  <form id="updateForm" method="POST" action="edit_admin_profile.php">
    <div class="profile-info">
      <div class="info-item">
        <div class="form-group">
          <label for="newFirstName">First Name:</label>
          <input type="text" id="newFirstName" name="newFirstName" value="<?php echo $firstName; ?>">
        </div>
      </div>
      <div class="info-item">
        <div class="form-group">
          <label for="newLastName">Last Name:</label>
          <input type="text" id="newLastName" name="newLastName" value="<?php echo $lastName; ?>">
        </div>
      </div>
      
      <div class="info-item">
        <div class="form-group">
          <label for="newPhoneNumber">Phone Number:</label>
          <input type="text" id="newPhoneNumber" name="newPhoneNumber" value="<?php echo $phoneNumber; ?>">
        </div>
      </div>
      <div class="info-item">
        <div class="form-group">
          <label for="newAddress">Address:</label>
          <input type="text" id="newAddress" name="newAddress" value="<?php echo $address; ?>">
        </div>
      </div>
      <div class="info-item">
        <div class="form-group">
          <label for="newCity">City:</label>
          <input type="text" id="newCity" name="newCity" value="<?php echo $city; ?>">
        </div>
      </div>
      <div class="info-item">
        <div class="form-group">
          <label for="newCountry">Country:</label>
          <input type="text" id="newCountry" name="newCountry" value="<?php echo $country; ?>">
        </div>
      </div>
      <div class="info-item">
        <div class="form-group">
          <label for="newPostcode">Postcode:</label>
          <input type="text" id="newPostcode" name="newPostcode" value="<?php echo $postcode; ?>">
        </div>
      </div>
      <input type="hidden" name="admin_id" value="<?php echo $staff_id; ?>"> <!-- Assuming admin_id is fixed for the logged-in admin -->
    </div>
    <button type="submit" name="update_profile">Update</button>
  </form>
  
</div>

         <!-- ======================= Change Password section================== -->
<!-- Change Password section -->
<div class="change-password-section">
  <h2 class="product-heading">Change Password</h2>
  <form id="changePasswordForm" method="POST" action="edit_admin_profile.php">
    <div class="profile-info">
      <div class="info-item">
        <div class="form-group">
          <label for="oldPassword">Old Password:</label>
          <input type="password" id="oldPassword" name="oldPassword">
        </div>
      </div>
      <div class="info-item">
        <div class="form-group">
          <label for="newPassword">New Password:</label>
          <input type="password" id="newPassword" name="newPassword">
        </div>
      </div>
      <div class="info-item">
        <div class="form-group">
          <label for="confirmPassword">Confirm Password:</label>
          <input type="password" id="confirmPassword" name="confirmPassword">
        </div>
      </div>
      <input type="hidden" name="admin_id" value="<?php echo $staff_id; ?>"> <!-- Assuming admin_id is fixed for the logged-in admin -->
    </div>
    <button type="submit" name="change_password">Change Password</button>
  </form>
</div>


     

    
    

    <script src="AdminDashboard.js"></script>
  </body>
</html>
