<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="VendorCss/style.css"> <!-- link css -->

</head>

<body>


    <!-- this section was to creat the navbar -->
    <!-- this is for the nav bar of the page -->
    <section id="header">
        <a href="landingpages.php"> <img src="img/Screenshot 2024-03-16 at 01.50.29.png" class="logo" alt=""></a>
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
                            <?php 
                                require_once 'cart.php';
                                if(empty($count)){ 
                                    echo '<span> 0  </span>'; 
                                }else{ 
                                    echo '<span> ' . $count . ' </span>'; 
                                } 
                            ?>
                     </a>
                </li>

                <!-- User profile image -->
                <img src="img/user1.png" class="user-pro" onclick="toggleMenu()">

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

    <section id="page-header" style="background-image: url(img/banner/rakusens_cover.jpeg) !important;">
        <h2>Welcome to Rakusen’s Online Shop</h2>
        <h3>Browse, add to cart, and checkout hassle-free</h3>
        <p>Experience the convenience of free UK delivery in just 2-3 days</p>
    </section>

    <!-- this is the section to display the products -->
    <section id="product1" class="section-p1">

        <div class="pro-container">
            <?php 
                $query1 = $db->query("SELECT * FROM products WHERE `category` = 'regular'");

                if($query1->num_rows > 0){
                    while($row1 = $query1->fetch_assoc()){
            ?>
            <div class="pro" onclick="window.location.href='productPage.php?id=<?= $row1['id'] ?>'; ">
                <img src="uploads/<?= $row1["main_photo"] ?>" alt="">
                <div class="description">
                    <h5><?= $row1["name"] ?></h5>
                    <div class="star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
            <?php
                    }
                } else { ?>
                <p>No featured products added yet...</p>
            <?php } ?>

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

    <script src="script.js"></script> <!--  link  javaScript to Html -->
    <script src="javaScript/vendor.js"></script>

</body>

</html>