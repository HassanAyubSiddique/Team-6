<?php
require_once 'cart.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />




     <link rel="stylesheet" href="VendorCss/style.css">  <!-- link css -->
     
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


 <h2 style="color:black; text-align:center">
 
 <br>

    


<!-- this is the section to dispaly the products -->
<section id="product1" class = "section-p1">
   

    <div class="pro-container">
   
            <h1 style="text-align:justify;">
            Rakusen’s has been producing delicious, <br>
             healthy water crackers since 1900. <br>
             In 
            fact, we were the first manufacturer <br>
             in the UK to do so
            </h1>
 
            <br>   <br>
            
            <h4 style="text-align:justify;">
            <br>
            Our entire range of crackers is flame-baked to a traditional <br>
             recipe, giving each bite a unique but subtle nutty flavour.
            </h4>

            <br>  <br>

            <p style="text-align:justify; line-height:40px">
            Over the years, we’ve expanded our range beyond crackers to include biscuits, 
            margarines, meal and soups, while developing our core product out to adapt to the modern snacking market with things like Snackers and Chocolate Snackers. But, while our product range may have changed, our core aim has not. For over a century, we’ve sought to produce great tasting products made with simple ingredients – making them not only delicious, but also incredibly healthy.

                    
            </p>

            <p style="text-align:justify; line-height:40px">
            This began with our roots as a provider of kosher foods to the Jewish community, but today means we can serve those living a vegan, vegetarian or gluten free lifestyle – or looking for tasty foods which are low in fat, sugar and salt, or free-from dairy, lactose and nuts. Rakusen’s was established in Leeds in 1900 by Lloyd Rakusen, who partnered with Joseph Bonn and Theodore Carr in 1910 to form Bonn Rakusen & Co. Bonn had already established his own company as the country’s first kosher catering firm and in the years that followed the partnership went from strength to strength, with Lloyd bringing his son into
 the business in 1930 to carry on the family business after his death in 1944.
            </p>


    </div>

</section>

<!-- Footer -->
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