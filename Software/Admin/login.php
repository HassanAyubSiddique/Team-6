<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Register</title>
    <link rel="stylesheet" href="Customerlogin.css">

</head>
<body>
    
<input type="image" src="./img/back.png" alt="" style="display: block; margin: 0 auto; border: none; width: 50%;">

<div class="container">
      
      <div class="options">
      <br>
        <button id="existingBtn"  class = "button">Existing Customer</button>
        <button id="newBtn" class = "button">New Customer</button>
      </div>
      <div class="login hidden">
        <h2>Login</h2>
        <br>
        <form action = "php/customerlogin.php" method = "POST">
          <input type="email"  placeholder = "Please type email:" name = "email" id="email" required>
          <input type="password" placeholder = "Please type password:" name = "password" id="password" required>
          <br>
          <input type="submit" name = "submit" class = "button" id="loginBtn">Login</button>
        </form>
        <br>
        <a href="login.php" class = "button"> Return to main menu</a>
      </div>
      <div class="register hidden">
        <h2>Register</h2>
        <br>
        <form action = "php/uploadcustomer.php" method = "POST">
          <input type="text" placeholder = "First name:" name = "name" id="name" required>
          <input type="text" placeholder = "Last name:" name = "surname" id="surname" required>
          <input type="email" placeholder = "Email:" name = "email" id="email" required>
          <input type="text" placeholder = "Phone number:" name = "phonenumber" id="phonenumber" required>
          <input type="text" placeholder="Address" name="address" id="address" required />
          <input type="text" placeholder="City" name="city" id="city" required/>
          <input type="text" placeholder="Postcode" name="postcode" id="postcode" required/>
          <input type="text" placeholder="Country" name="country" id="country" required/>
          <input type="password" placeholder = "Password:" name = "password" id="password" required>
          <input type="password" placeholder="Confirm Password" name="confirmPassword" id="confirmPassword"required/>
          <select name="role" id="role" required>
                                    <option value="" disabled selected>Select your role</option>
                                    <option value="client">Client</option>
                                    <option value="staff">Staff Member</option>
            </select>
          <br>
          <input type="submit" class = "button" name = "submit" id="registerBtn">Register
        </form>
        <br>
        <a href="login.php" class = "button"> Return to main menu</a>
        <br>
        <div>
          
        </div>

      </div>
    </div>


    <script src="logincustomer.js"></script>
</body>
</html>