
<?php
require_once 'cart.php';

if(!isset($_SESSION['uname'])){

    
header('Location: register-page.php');

}else{
  $uname = $_SESSION['uname'];
}

$sql = "SELECT * FROM users WHERE uname='$uname'";

		
		$result = mysqli_query($db, $sql);
		$row = mysqli_fetch_assoc($result);

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
    <link rel="stylesheet" href="VendorCss/style.css">    <!-- link css -->
    <!--css file-->
    <!-- <link rel="stylesheet" href="AdminDashboard.css" /> -->
 
  </head>
  <body>
 <!-- this is for the nav bar of the page -->
 <section id="header">
  <a href="landingpages.php"> <img src="img/Screenshot 2024-03-16 at 01.50.29.png" class="logo" al t=""></a>
  <div>

        <!-- Search bar -->
      <ul id="navbar">
          <li>
              <div class="search-container">
                  <input type="text" placeholder="Search..." class="search-bar">
                  <i class="fas fa-search search-icon"></i>
              </div>
          </li>

       

               <!-- Navigation links -->
          <li><a class="active" href="landingpages.php">Home</a></li>
          <li><a href="shop.php">Shop</a></li>
          <li><a href="about.php">About</a></li>
          <li><a href="contact.php">Contact</a></li>
          <li><a href="cart-page.php"><i class="fa-solid fa-cart-shopping"></i> 
                            <?php if(empty($count)){ ?>
                            <span> 0  </span>
                            <?php }else{ ?>
                            <span> <?= $count ?>  </span>
                            <?php } ?>
                     </a>
                </li>
      
       
              <!-- User profile image -->
          <img src="img/user1.png"  class="user-pro" onclick="toggleMenu()">    

            <!-- Sub-menu for user profile -->
          <div class="sub-menu-wrap" id="subMenu">
              <div class="sub-menu">

                    <!-- User profile details -->
                  <div class="user-info">
                      <img src="img/user1.png" >
                      <h3>Mohammed</h3>
                  </div>
                  <hr>
                      <!-- Sub-menu links -->      <!-- add the  links  here -->
                  <a href="AdProfile.php" class="sub-menu-link">
                      <i class="fas fa-user"></i>
                      <p>Profile</p>
                      <span>></span>
                  </a>
                     <!-- Sub-menu links -->      <!-- add the  links  here -->       <!-- just add the register page link here -->  
                  <a href="logout.php" class="sub-menu-link">
                      <i class="fas fa-sign-out-alt"></i>
                      <p>Logout</p>
                      <span>></span>
                  </a>
              </div>
          </div>

      </ul>
  </div>
</section>

    <!-- Profile section -->
<div class="profile-section">
  <h2 class="product-heading">Profile Information</h2>
    <!-- Admin Image
    <img src="img/Screenshot 2024-03-15 at 19.56.42.png" alt="" class="admin-profile-image"> -->
  <div class="profile-info">
    
    <div class="info-item">
      <span class="info-label">First Name:</span>
      <span class="info-value"><?= $row['fname'] ?></span>
    </div>
    <div class="info-item">
      <span class="info-label">User Name:</span>
      <span class="info-value"><?= $row['uname'] ?></span>
    </div>
    <div class="info-item">
      <span class="info-label">Email:</span>
      <span class="info-value"><?= $row['email'] ?></span>
    </div>
    <div class="info-item">
      <span class="info-label">Phone Number:</span>
      <span class="info-value"><?= $row['phone'] ?></span>
    </div>
    <div class="info-item">
      <span class="info-label">Address:</span>
      <span class="info-value"><?= $row['address'] ?></span>
    </div>
    <div class="info-item">
      <span class="info-label">City:</span>
      <span class="info-value"><?= $row['city'] ?></span>
    </div>
    <div class="info-item">
      <span class="info-label">Country:</span>
      <span class="info-value"><?= $row['country'] ?></span>
    </div>
    <div class="info-item">
      <span class="info-label">Postcode:</span>
      <span class="info-value"><?= $row['postcode'] ?></span>
    </div>
  </div>
</div>


    

                  <!-- ======================= Update information ================== -->

                  <div class="profile-section">
                    <h2 class="product-heading">Update Information</h2>
                    <form id="updateForm" method="POST" action="update-script.php">
                      <div class="profile-info">
                        <div class="info-item">
                          <div class="form-group">
                            <label for="newFirstName">First Name:</label>
                            <input required type="text" min="2" max="30" id="newFirstName" name="fname">
                          </div>
                        </div>
                        <div class="info-item">
                          <div class="form-group">
                            <label for="newLastName">User Name:</label>
                            <input required type="text" min="2" max="30" id="newLastName" name="uname">
                          </div>
                        </div>
                        <div class="info-item">
                          <div class="form-group">
                            <label for="newPhoneNumber">Phone Number:</label>
                            <input required type="text" id="newPhoneNumber" name="phone">
                          </div>
                        </div>
                        <div class="info-item">
                          <div class="form-group">
                            <label for="newAddress">Address:</label>
                            <input required type="text" min="2" max="100"  id="newAddress" name="address">
                          </div>
                        </div>
                        <div class="info-item">
                          <div class="form-group">
                            <label for="newCity">City:</label>
                            <input required type="text" min="2" max="50"  id="newCity" name="city">
                          </div>
                        </div>
                        <div class="info-item">
                          <div class="form-group">
                            <label for="newCountry">Country:</label>
                            <input required type="text" id="newCountry" name="country">
                          </div>
                        </div>
                        <div class="info-item">
                          <div class="form-group">
                            <label for="newPostcode">Postcode:</label>
                            <input required type="text" min="3" max="15"  id="newPostcode" name="postcode">
                          </div>
                        </div>
                      
                      </div>
                      <button type="submit" name="updateUserInfo">Update</button>
                    </form>
                  </div>
                  

         <!-- ======================= Change Password section================== -->
<div class="change-password-section">
  <h2 class="product-heading">Change Password</h2>
  <form id="changePasswordForm" method="POST" action="update-script.php">
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
    </div>
    <button type="submit" name="updateUserPassword">Change Password</button>
  
  </form>
</div>


</div>
      
    </div>


     

<!-- this is all the javaScrit i'll link it later in a seperate file so that i will  not look cluster of thing in one html file /clutter  -->
  
<script src="javaScript/vendor.js"></script>
    
    

  </body>
</html>