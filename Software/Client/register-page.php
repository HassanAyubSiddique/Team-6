<?php
require_once 'cart.php';

if(isset($_SESSION['uname'])){

    
header('Location: AdProfile.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register || Login Page</title>
    <!-- Font Awesome CDN for icons -->
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- External CSS files -->
    <link rel="stylesheet" href="VendorCss/register.css" />
    <!-- Title for the page -->
    <title>Sign in & Sign up Form</title>
</head>
<body>
    <!-- Container for the entire content -->
    <div class="container">
        <!-- Container for the forms -->
        <div class="forms-container">
            <!-- Sign-in and sign-up forms -->
            <div class="signin-signup">
                <!-- Sign in form -->
                <form action="loginScript.php" method="POST" class="sign-in-form">
                    <h2 class="title">Sign in</h2>
                    <!-- Username input field -->
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input name="uname" type="text" placeholder="Username" />
                    </div>
                    <!-- Password input field -->
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input name="password" type="password" placeholder="Password" />
                    </div>
                    <!-- Login button -->
                    <input type="submit" name="loginSubmit" value="Login" class="btn solid" />
                    <!-- Or sign in with social platforms -->
                  
                </form>

                <!-- Sign up form -->
                <form action="registerScript.php" method="POST" class="sign-up-form">
                    <h2 class="title">Sign up</h2>
                    <!-- Table for aligning input fields horizontally -->
                    <table>
                        <tr>
                            <!-- First name input field -->
                            <td>
                                <div class="input-field">
                                    <i class="fas fa-user"></i>
                                    <input name="fname" type="text" placeholder="Full Name" />
                                </div>
                            </td>
                            <!-- Last name input field -->
                            <td>
                                <div class="input-field">
                                    <i class="fas fa-user"></i>
                                    <input name="uname" type="text" placeholder="User Name" />
                                </div>
                            </td>
                        </tr>
                        <!-- More rows for additional input fields -->
                        <tr>
                            <td>
                              <div class="input-field">
                                <i class="fas fa-envelope"></i>
                                <input name="email" type="email" placeholder="Email" />
                              </div>
                            </td>
                            <td>
                              <div class="input-field">
                                <i class="fas fa-phone"></i>
                                <input name="phone" type="tel" placeholder="Phone Number" />
                              </div>
                            </td>
                          </tr>
                          <tr>
                              <td>
                                  <div class="input-field">
                                      <i class="fas fa-address-card"></i>
                                      <input name="address" type="text" placeholder="Address" />
                                  </div>
                              </td>
                              <td>
                                  <div class="input-field">
                                      <i class="fas fa-city"></i>
                                      <input name="city" type="text" placeholder="City" />
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td>
                                  <div class="input-field">
                                      <i class="fas fa-lock"></i>
                                      <input name="password" type="text" placeholder="Password" />
                                  </div>
                              </td>

                              <td>
                                  <div class="input-field">
                                      <i class="fas fa-lock"></i>
                                      <input name="re_password" type="text" placeholder="Confirm Password" />
                                  </div>
                              </td>
                             

                          </tr>
                          <tr>
                              
                              <td>
                                  <div class="input-field">
                                      <i class="fas fa-map-marker-alt"></i>
                                      <input name="postcode" type="text" placeholder="Postcode" />
                                  </div>
                              </td>
                              <td>
                                  <div class="input-field">
                                      <i class="fas fa-globe"></i>
                                      <input name="country" type="text" placeholder="Country" />
                                  </div>
                              </td>
                          </tr>
                       
                    </table>
                    <!-- Sign up button -->
                    <input type="submit" name="registerSubmit" class="btn" value="Sign up" />
                </form>
            </div>
        </div>

        <!-- Panels for displaying content -->
        <div class="panels-container">
            <!-- Left panel for sign-up -->
            <div class="panel left-panel">
                <div class="content">
                    <h3>New here ?</h3>
                    <p>
                        Join our community - Sign up today
                    </p>
                    <!-- Button to switch to sign-up form -->
                    <button class="btn transparent" id="sign-up-btn">
                        Sign up
                    </button>
                </div>
                <!-- Image for left panel -->
                <img src="img/log.svg" class="image" alt="" />
            </div>
            <!-- Right panel for sign-in -->
            <div class="panel right-panel">
                <div class="content">
                    <h3>Welcome to the team!</h3>
                    <p>
                        You're one of us now. Get started by signing in below
                    </p>
                    <!-- Button to switch to sign-in form -->
                    <button class="btn transparent" id="sign-in-btn">
                        Sign in
                    </button>
                </div>
                <!-- Image for right panel -->
                <img src="img/register.svg" class="image" alt="" />
            </div>
        </div>
    </div>


    <!-- JavaScript file -->
    <script src="javaScript/registerpage.js"></script>


    <script>
    function toggleMenu() {
      subMenu.classList.toggle("open-menu");
    }
 
</script>

</body>
</html>