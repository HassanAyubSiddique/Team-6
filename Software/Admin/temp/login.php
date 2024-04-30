<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign in & Sign up Form</title>
    <!-- Font Awesome CDN for icons -->
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
    <!-- External CSS files -->
    <link rel="stylesheet" href="CSS/style.css" />
  </head>
  <body>
    <!-- Container for the entire content -->
    <div class="container">
      <!-- Container for the forms -->
      <div class="forms-container">
        <!-- Sign-in and sign-up forms -->
        <div class="signin-signup">
            <!-- Sign in form -->
            <form action="processLogin.php" class="sign-in-form" method="POST">
                <h2 class="title">Sign in</h2>
                <!-- Username input field -->
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" placeholder="Email" name="email"/>
                </div>
                <!-- Password input field -->
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" placeholder="Password" name="password" />
                </div>
                <!-- Login button -->
                <input type="submit" id="sign-in-btn" value="Login" class="btn solid" />
                <!-- Or sign in with social platforms -->
            
            </form>

            <!-- Sign up form -->
            <form action="signup.php" class="sign-up-form">
                <h2 class="title">Sign up</h2>
                <!-- Table for aligning input fields horizontally -->
                <table>
                    <tr>
                        <!-- First name input field -->
                        <td>
                            <div class="input-field">
                                <i class="fas fa-user"></i>
                                <input type="text" placeholder="First Name" name="firstName" />
                            </div>
                        </td>
                        <!-- Last name input field -->
                        <td>
                            <div class="input-field">
                                <i class="fas fa-user"></i>
                                <input type="text" placeholder="Last Name" name="lastName" />
                            </div>
                        </td>
                    </tr>
                    <!-- More rows for additional input fields -->
                    <tr>
                        <td>
                          <div class="input-field">
                            <i class="fas fa-envelope"></i>
                            <input type="email" placeholder="Email" name="email" />
                          </div>
                        </td>
                        <td>
                          <div class="input-field">
                            <i class="fas fa-phone"></i>
                            <input type="tel" placeholder="Phone Number" name="phoneNumber" />
                          </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="input-field">
                                <i class="fas fa-address-card"></i>
                                <input type="text" placeholder="Address" name="address" />
                            </div>
                        </td>
                        <td>
                            <div class="input-field">
                                <i class="fas fa-city"></i>
                                <input type="text" placeholder="City" name="city" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="input-field">
                                <i class="fas fa-map-marker-alt"></i>
                                <input type="text" placeholder="Postcode" name="postcode" />
                            </div>
                        </td>
                        <td>
                            <div class="input-field">
                                <i class="fas fa-globe"></i>
                                <input type="text" placeholder="Country" name="country" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="input-field">
                                <i class="fas fa-lock"></i>
                                <input type="password" placeholder="Password" name="password" />
                            </div>
                        </td>
                        <td>
                            <div class="input-field">
                                <i class="fas fa-lock"></i>
                                <input type="password" placeholder="Confirm Password" name="confirmPassword" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="input-field">
                                <i class="fas fa-user"></i>
                                <select name="role">
                                    <option value="" disabled selected>Select your role</option>
                                    <option value="client">Client</option>
                                    <option value="staff">Staff Member</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                </table>
                <!-- Sign up button -->
                <input type="submit" class="btn" value="Sign up" />
            </form>
            
        </div>
    </div>

      <!-- Error message display area -->
      <div id="error-message" style="color: red; display: none"></div>

      <!-- Panels for displaying content -->
      <div class="panels-container">
        <!-- Left panel for sign-up -->
        <div class="panel left-panel">
          <div class="content">
            <h3>New here ?</h3>
            <p>Join our community - Sign up today</p>
            <!-- Button to switch to sign-up form -->
            <button class="btn transparent" id="sign-up-btn">Sign up</button>
          </div>
          <!-- Image for left panel -->
          <img src="img/log.svg" class="image" alt="" />
        </div>
        <!-- Right panel for sign-in -->
        <div class="panel right-panel">
          <div class="content">
            <h3>Welcome to the team!</h3>
            <p>You're one of us now. Get started by signing in below</p>
            <!-- Button to switch to sign-in form -->
            <button class="btn transparent" id="sign-in-btn">Sign in</button>
          </div>
          <!-- Image for right panel -->
          <img src="img/register.svg" class="image" alt="" />
        </div>
      </div>
    </div>

    <style>
      #error-message {
        display: flex; /* Use flexbox */
        align-items: center; /* Align items vertically */
        justify-content: center; /* Align items horizontally */
        position: absolute; /* Position absolutely */
        top: 673%; /* Align to the top */
        left: 100%; /* Move to the center horizontally */
        transform: translateX(-50%); /* Center horizontally */
        background-color: rgba(255, 0, 0, 0.2); /* Background color */
        color: red; /* Text color */
        padding: 10px; /* Padding for spacing */
        border-radius: 5px; /* Rounded corners */
        white-space: nowrap; /* Prevent wrapping */
        z-index: 999; /* Ensure it appears above other content */
      }
    </style>
     <style>
      #sign-error-message {
        display: flex; /* Use flexbox */
        align-items: center; /* Align items vertically */
        justify-content: center; /* Align items horizontally */
        position: absolute; /* Position absolutely */
        top: 265%; /* Align to the top */
        left: 50%; /* Move to the center horizontally */
        transform: translateX(-50%); /* Center horizontally */
        background-color: rgba(255, 0, 0, 0.2); /* Background color */
        color: red; /* Text color */
        padding: 10px; /* Padding for spacing */
        border-radius: 5px; /* Rounded corners */
        white-space: nowrap; /* Prevent wrapping */
        z-index: 999; /* Ensure it appears above other content */
      }
    </style>

    <!-- JavaScript file -->
    <script src="login.js"></script>
  </body>
</html>
