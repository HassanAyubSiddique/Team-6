<?php
require_once 'cart.php';
$statusMsg = '';



$id = $_GET['id'];

$qry = "SELECT * FROM products WHERE id = '$id'";
$result = mysqli_query($db, $qry);
$fetch = mysqli_fetch_array($result);

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <title>Product page</title>
    <link rel="stylesheet" href="VendorCss/style.css">    <!-- link css -->
    <style>
        button#add_to_cart{
            background-color: #088178 !important;
                color: #fff !important;
                font-size: 1.2rem !important;
                font-weight: bold !important;
                padding: 10px 20px !important;
                border-radius: 5px !important;
                box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2) !important;
                transition: all 0.3s ease !important;
    
        }
    </style>
</head>
<body>
    <!-- this is for the nav bar of the page -->
    <section id="header">
        <a href="landingpages.php"> <img src="img/Screenshot 2024-03-16 at 01.50.29.png" class="logo" al t=""></a>
        <div>
            <ul id="navbar">
                <li>
                    <div class="search-container">
                        <input type="text" placeholder="Search..." class="search-bar">
                        <i class="fas fa-search search-icon"></i>
                    </div>
                </li>
                
                <li><a class="active" href="landingpage.php">Home</a></li>
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

                

            
             
                <img src="img/user1.png"  class="user-pro" onclick="toggleMenu()">    

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
     <section id="prodetail" class="section-p1">
        <div class="single-prot-img">
            <img src="uploads/<?= $fetch['main_photo'] ?>" width="100%" id="MainImg" alt="">
    
            
            <div class="related-imgs-group">
                <div class="related-img-col">
                    <img src="uploads/<?= $fetch['photo_one'] ?>" width="100%" class="related-img" alt="">
                </div>
                <div class="related-img-col">
                    <img src="uploads/<?= $fetch['photo_two'] ?>" width="100%" class="related-img" alt="">
                </div>
                <div class="related-img-col">
                    <img src="uploads/<?= $fetch['photo_three'] ?>" width="100%" class="related-img" alt="">
                </div>
             
            </div>
            

        </div>
    
        <div class="single-prot-details">

        <h6> Rakusen’s</h6>
           
            <h4><?= $fetch['name'] ?> </h4>
            
          
            <form method="post" action="">
            
            <input type="hidden" name="id" value="<?php echo $fetch['id']; ?>" />
            <input type="hidden" name="name" value="<?php echo $fetch['name']; ?>" />
            <input type="hidden" name="photo" value="<?php echo $fetch['photo']; ?>" />
            <input type="hidden" name="price" value="<?php echo $fetch['price']; ?>" />
            <input type="number" name="quantity" class="form-control" value="1" />
            
            <input type="submit" style="background-color: #088178 !important;
    color: snow !important;
    font-size: 1.2rem !important;
    font-weight: bold !important;
    padding: 10px 20px !important;
    border-radius: 5px !important;
    box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
    position: absolute;
    top:330px;
    left:900px;
    font-weight:bolder
}" name="add_to_cart" id="add_to_cart" value="Add To Cart" class="btn btn-primary">

            </form>
            <div class=" m">
             
            </div>
            
            <h4>Product Detail</h4>
            <span>

             <?= $fetch['description'] ?>
            </span>

            
        </div>
      
       
       
          
     </section>

   
    

     <!-- here is the freature of the e-commers website offers to it's customers -->
<section id="feature" class = "section-p1" >
    <div class="feature-box2">
        <a href="#"><img src="img/features/free shiping.png" alt=""> </a>
        <h6>Free Shiaping</h6>  
    </div>
    <div class="feature-box2">
        <a href="#"><img src="img/features/easyExchange.png" alt=""></a>
        <h6>Online Order</h6>  
    </div>
    <div class="feature-box2">
       <a href="#"> <img src="img/features/HighQuality.png" alt=""></a>
        <h6>Save Money</h6>  
    </div>
</section>


<!-- this is for the product -->

<section id="product1" class = "section-p1">
    <h2>"Our Products"</h2>
    <p></p>

    <div class="pro-container">
     
    <?php 
        	$query1 = $db->query("SELECT * FROM products WHERE `category` = 'regular'");

        if($query1->num_rows > 0){
        while($row1 = $query1->fetch_assoc()){
    ?>

        <div class="pro" onclick="window.location.href='productPage.php?id=<?= $row1['id'] ?>';">
            <img src="uploads/<?= $row1["main_photo"] ?>" alt="">
            <div class="description">
                <span><?= $row1["price"] ?> </span>
                <h5><?= $row1["name"] ?></h5>
              
            
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





  <script>
    let subMenu = document.getElementById("subMenu");

    function toggleMenu() {
      subMenu.classList.toggle("open-menu");
    }
 

    var MainImg = document.getElementById("MainImg")
    var smallImg = document.getElementsByClassName("related-img")
    smallImg[0].onclick = function(){
        MainImg.src = smallImg[0].src;
    }
    smallImg[1].onclick = function(){
        MainImg.src = smallImg[1].src;
    }
    smallImg[2].onclick = function(){
        MainImg.src = smallImg[2].src;
    }
    smallImg[3].onclick = function(){
        MainImg.src = smallImg[3].src;
    }
    smallImg[4].onclick = function(){
        MainImg.src = smallImg[4].src;
    }


    
   
  </script>

</body>
</html>
