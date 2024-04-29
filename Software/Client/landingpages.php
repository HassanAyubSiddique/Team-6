<?php
require_once 'cart.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />


    <title>Landing page</title>
    <link rel="stylesheet" href="VendorCss/style.css">    link css
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


       <!-- Slider section -->
     <section id="slider">
        <div class="slider-container">
             <!-- Slides with links -->
            <div class="slide active">
                <a href="shop.php"> <img src="img/slider/Slider_rakusens_01.jpg" alt="Slide 1"> </a>
            </div>
            <div class="slide">
                <a href="shop.php"> <img src="img/slider/Slider_rakusens_02.jpg" alt="Slide 2">  </a>
            </div>
            <div class="slide">
            <a href="shop.php">  <img src="img/slider/Slider_rakusens_03.jpg" alt="Slide 3">   </a>
            </div>
<!-- Manual arrows -->
<button class="prev" onclick="prevSlide()">&#10094;</button>
<button class="next" onclick="nextSlide()">&#10095;</button>
        </div>
    </section>
    

     <!-- here is the freature of the e-commers website offers to it's customers -->
<section id="feature" class = "section-p1" >
  
    <div class="feature-box">
        <img src="img/features/f2.png" alt="">
        <h6>Online Order</h6>  
    </div>
    <div class="feature-box">
        <img src="img/features/f3.png" alt="">
        <h6>Save Money</h6>  
    </div>
    <div class="feature-box">
        <img src="img/features/f4.png" alt="">
        <h6>Promotions</h6>  
    </div>
    <div class="feature-box">
        <img src="img/features/f5.png" alt="">
        <h6>Happy Sell</h6>  
    </div>
    <div class="feature-box">
        <img src="img/features/f6.png" alt="">
        <h6>24/7 Support</h6>  
    </div>


    

</section>
<!-- this is for the product section -->

<section id="product1" class = "section-p1">
    <h2>"Our Products"</h2>
    <p></p>

    <div class="pro-container">


    
                         <?php 
								$query1 = $db->query("SELECT * FROM products LIMIT 4");
                            

								if($query1->num_rows > 0){
									while($row1 = $query1->fetch_assoc()){
                        ?>

                    <div class="pro" onclick="window.location.href='productPage.php?id=<?= $row1['id'] ?>';">
                        <img  src="uploads/<?=$row1["main_photo"]?>" alt="">
                            <div class="description">
                                        
                                        <span>  <?=$row1["name"]?></span>
                                    <h5> <?= $row1["name"] ?></h5>
                                       
                                        <div class="star">
                                            <i class="fas fa-star"> </i>
                                            <i class="fas fa-star"> </i>
                                            <i class="fas fa-star"> </i>
                                            <i class="fas fa-star"> </i>
                                            <i class="fas fa-star"> </i>
                                            
                                        </div>
                                
                                </div>
                
                      </div>

                      <?php }
                            }else{ ?>
                                <p>No featured products added yet...</p>
					  <?php } ?>
 


</div>
</section>
<!-- this is the footer -->
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





<!-- this is all the javaScrit i'll link it later in a seperate file so that i will  not look cluster of thing in one html file /clutter  -->
  <script>
    let subMenu = document.getElementById("subMenu");

    function toggleMenu() {
      subMenu.classList.toggle("open-menu");
    }

    document.addEventListener("DOMContentLoaded", function() {
      let slides = document.querySelectorAll('.slide');
      let currentSlide = 0;
      let slideInterval = setInterval(nextSlide, 5000); // Change slide every 5 seconds

      function nextSlide() {
          slides[currentSlide].classList.remove('active');
          currentSlide = (currentSlide + 1) % slides.length;
          slides[currentSlide].classList.add('active');
      }
    });

    function prevSlide() {
        slides[currentSlide].classList.remove('active');
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        slides[currentSlide].classList.add('active');
    }
  </script>


<script>
    function toggleMenu() {
      subMenu.classList.toggle("open-menu");
    }
 
</script>
</body>
</html>