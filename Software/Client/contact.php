<?php
require_once 'cart.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">




     <link rel="stylesheet" href="Vendorcss/style.css">  <!-- link css -->
     
</head>
<body>


<!-- this section was to creat the navbar -->
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

                <?php if(isset($_SESSION['uname'])){ ?>
                      <!-- User profile details -->
                    <div class="user-info">
                        <img src="img/user1.png" >
                        <h3><?= $_SESSION['uname'] ?></h3>
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


                    <?php } else{?>

                        <div class="user-info">
                        <img src="img/user1.png" >
                        <h3>Join us</h3>
                    </div>
                    <hr>
                        <!-- Sub-menu links -->      <!-- add the  links  here -->
                    <a href="register-page.php" class="sub-menu-link">
                        <i class="fas fa-user"></i>
                        <p>Sign in</p>
                        <span>></span>
                    </a>

                    <?php } ?>


                </div>
            </div>

        </ul>
    </div>
 </section>



    


<!-- this is the section to dispaly the products -->
<section id="product1" class = "section-p1">
   
<h3 style="text-align:left">
        Contact Us
    </h3>

    <div class="pro-container">
   
     


    <address style="text-align:justify; font-size:20px;">
    Address:
Rakusens Limited <br>
Rakusen House <br>
Clayton Wood Rise <br>
Ring Road West Park <br>
Leeds, LS16 6QN <br>


Telephone:
(+44) 0113 278 4821
<br>


Fax:
(+44) 0113 278 4064

<br>

Email:
sales@rakusens.com


    </address>



            

    </div>

</section>

<!-- Footer -->

<div>
    
</div>


<footer>
    <div class="footerContainer">
        <div class="socialIcon">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-google-plus"></i></a>
            <a href="#"><i class="fab fa-envelope"></i></a>
        </div>
        <div class="footerNav">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="#">Our Team</a></li>
                <li><a href="#">Services</a></li>
            </ul>
        </div>
        <div class="footerBottom">
        </div>
    </div>
</footer>


<script src="script.js"></script>        <!--  link  javaScript to Html -->


<script>
    function toggleMenu() {
      subMenu.classList.toggle("open-menu");
    }
 
</script>
    
    
</body>
</html>